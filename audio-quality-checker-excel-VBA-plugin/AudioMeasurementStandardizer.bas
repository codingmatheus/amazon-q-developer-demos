Attribute VB_Name = "AudioMeasurementStandardizer"
Option Explicit

' Constants for safety thresholds
Const MIN_SAFE_DB As Double = 80
Const MAX_SAFE_DB As Double = 100

' Main procedure to process audio measurement files
Sub ProcessAudioMeasurements()
    Dim filePath As String
    Dim resultSheet As Worksheet
    
    ' Create or clear results worksheet
    On Error Resume Next
    Set resultSheet = ThisWorkbook.Sheets("Results")
    On Error GoTo 0
    
    If resultSheet Is Nothing Then
        Set resultSheet = ThisWorkbook.Sheets.Add
        resultSheet.Name = "Results"
    Else
        resultSheet.Cells.Clear
    End If
    
    ' Set up headers
    With resultSheet
        .Cells(1, 1).Value = "File Name"
        .Cells(1, 2).Value = "Audio Type"
        .Cells(1, 3).Value = "Decibel Value"
        .Cells(1, 4).Value = "Status"
        .Cells(1, 5).Value = "Comments"
        
        ' Format headers
        .Range("A1:E1").Font.Bold = True
        .Range("A1:E1").Interior.Color = RGB(200, 200, 200)
    End With
    
    ' Get file path from user
    filePath = GetFilePath()
    
    If filePath = "" Then
        MsgBox "Operation cancelled.", vbInformation
        Exit Sub
    End If
    
    ' Check if file exists
    On Error Resume Next
    Dim fileExists As Boolean
    Open filePath For Input As #1
    fileExists = (Err.Number = 0)
    If fileExists Then Close #1
    On Error GoTo 0
    
    If Not fileExists Then
        MsgBox "File not found: " & filePath & vbCrLf & _
               "Please check the file path and try again.", vbExclamation
        Exit Sub
    End If
    
    ' Process the selected file
    ProcessFile filePath, resultSheet
    
    ' Auto-fit columns for better readability
    resultSheet.Columns("A:E").AutoFit
    
    MsgBox "Audio measurement analysis complete!", vbInformation
End Sub

' Function to get file path from user
Function GetFilePath() As String
    Dim fd As Object
    
    ' Use error handling in case there's an issue with the FileDialog
    On Error Resume Next
    Set fd = Application.FileDialog(msoFileDialogFilePicker)
    
    ' Check if FileDialog was created successfully
    If fd Is Nothing Then
        ' Alternative approach if FileDialog fails
        GetFilePath = InputBox("Please enter the full path to the audio measurement text file:", _
                              "Enter File Path", _
                              Environ("HOME") & "/Documents/SampleAudioData.txt")
        On Error GoTo 0
        Exit Function
    End If
    On Error GoTo 0
    
    With fd
        .Title = "Select Audio Measurement Text File"
        .Filters.Clear
        
        ' Add filter with error handling
        On Error Resume Next
        .Filters.Add "Text Files", "*.txt"
        On Error GoTo 0
        
        .AllowMultiSelect = False
        
        ' Show dialog with error handling
        On Error Resume Next
        Dim dialogResult As Boolean
        dialogResult = .Show
        
        If Err.Number <> 0 Then
            ' If dialog fails, use input box instead
            GetFilePath = InputBox("Please enter the full path to the audio measurement text file:", _
                                  "Enter File Path", _
                                  Environ("HOME") & "/Documents/SampleAudioData.txt")
        ElseIf dialogResult = True Then
            GetFilePath = .SelectedItems(1)
        Else
            GetFilePath = ""
        End If
        On Error GoTo 0
    End With
End Function

' Process a single file
Sub ProcessFile(filePath As String, resultSheet As Worksheet)
    Dim fileNum As Integer
    Dim line As String
    Dim parts() As String
    Dim audioType As String
    Dim decibelValue As Double
    Dim rowIndex As Long
    Dim fileName As String
    
    ' Extract file name from path
    On Error Resume Next
    fileName = Mid(filePath, InStrRev(filePath, Application.PathSeparator) + 1)
    If Err.Number <> 0 Or fileName = "" Then
        ' Try with slash as separator if PathSeparator doesn't work
        fileName = Mid(filePath, InStrRev(filePath, "/") + 1)
        If fileName = "" Then
            ' Last resort - use the full path
            fileName = filePath
        End If
    End If
    On Error GoTo 0
    
    ' Start at row 2 (after headers)
    rowIndex = 2
    
    ' Open the file with error handling
    On Error Resume Next
    fileNum = FreeFile
    Open filePath For Input As #fileNum
    
    If Err.Number <> 0 Then
        MsgBox "Error opening file: " & Err.Description, vbExclamation
        Exit Sub
    End If
    On Error GoTo 0
    
    ' Read each line
    Do While Not EOF(fileNum)
        Line Input #fileNum, line
        
        ' Skip empty lines
        If Trim(line) <> "" Then
            ' Parse the line (assuming format: "AudioType,DecibelValue")
            parts = Split(line, ",")
            
            If UBound(parts) >= 1 Then
                audioType = Trim(parts(0))
                
                ' Try to convert the decibel value to a number
                If IsNumeric(Trim(parts(1))) Then
                    decibelValue = CDbl(Trim(parts(1)))
                    
                    ' Write to results sheet
                    With resultSheet
                        .Cells(rowIndex, 1).Value = fileName
                        .Cells(rowIndex, 2).Value = audioType
                        .Cells(rowIndex, 3).Value = decibelValue
                        
                        ' Evaluate if within safe range
                        If decibelValue >= MIN_SAFE_DB And decibelValue <= MAX_SAFE_DB Then
                            .Cells(rowIndex, 4).Value = "SAFE"
                            .Cells(rowIndex, 4).Interior.Color = RGB(0, 255, 0) ' Green
                            .Cells(rowIndex, 5).Value = "Within safe range"
                        ElseIf decibelValue < MIN_SAFE_DB Then
                            .Cells(rowIndex, 4).Value = "LOW"
                            .Cells(rowIndex, 4).Interior.Color = RGB(255, 255, 0) ' Yellow
                            .Cells(rowIndex, 5).Value = "Below minimum safe level"
                        Else
                            .Cells(rowIndex, 4).Value = "DANGER"
                            .Cells(rowIndex, 4).Interior.Color = RGB(255, 0, 0) ' Red
                            .Cells(rowIndex, 5).Value = "Exceeds maximum safe level"
                        End If
                    End With
                    
                    rowIndex = rowIndex + 1
                End If
            End If
        End If
    Loop
    
    ' Close the file
    Close #fileNum
End Sub

' Function to process multiple files at once
Sub ProcessMultipleFiles()
    Dim fd As Object
    Dim filePath As String
    Dim resultSheet As Worksheet
    Dim i As Integer
    
    ' Create or clear results worksheet
    On Error Resume Next
    Set resultSheet = ThisWorkbook.Sheets("Results")
    On Error GoTo 0
    
    If resultSheet Is Nothing Then
        Set resultSheet = ThisWorkbook.Sheets.Add
        resultSheet.Name = "Results"
    Else
        resultSheet.Cells.Clear
    End If
    
    ' Set up headers
    With resultSheet
        .Cells(1, 1).Value = "File Name"
        .Cells(1, 2).Value = "Audio Type"
        .Cells(1, 3).Value = "Decibel Value"
        .Cells(1, 4).Value = "Status"
        .Cells(1, 5).Value = "Comments"
        
        ' Format headers
        .Range("A1:E1").Font.Bold = True
        .Range("A1:E1").Interior.Color = RGB(200, 200, 200)
    End With
    
    ' Get file paths from user with error handling
    On Error Resume Next
    Set fd = Application.FileDialog(msoFileDialogFilePicker)
    
    If fd Is Nothing Then
        MsgBox "Could not create file dialog. Please use ProcessAudioMeasurements instead.", vbExclamation
        Exit Sub
    End If
    On Error GoTo 0
    
    With fd
        .Title = "Select Audio Measurement Text Files"
        .Filters.Clear
        
        On Error Resume Next
        .Filters.Add "Text Files", "*.txt"
        On Error GoTo 0
        
        .AllowMultiSelect = True
        
        On Error Resume Next
        Dim dialogResult As Boolean
        dialogResult = .Show
        
        If Err.Number <> 0 Then
            MsgBox "Error showing file dialog: " & Err.Description & vbCrLf & _
                   "Please use ProcessAudioMeasurements instead.", vbExclamation
            Exit Sub
        ElseIf dialogResult = True Then
            ' Process each selected file
            For i = 1 To .SelectedItems.Count
                filePath = .SelectedItems(i)
                ProcessFile filePath, resultSheet
            Next i
            
            ' Auto-fit columns for better readability
            resultSheet.Columns("A:E").AutoFit
            
            MsgBox "Audio measurement analysis complete for " & .SelectedItems.Count & " files!", vbInformation
        Else
            MsgBox "Operation cancelled.", vbInformation
        End If
        On Error GoTo 0
    End With
End Sub

' Generate a summary report
Sub GenerateSummaryReport()
    Dim resultSheet As Worksheet
    Dim summarySheet As Worksheet
    Dim lastRow As Long
    Dim i As Long
    Dim safeCount As Long, lowCount As Long, dangerCount As Long
    Dim audioTypes As Object
    Dim audioType As Variant
    Dim chartObj As ChartObject
    
    ' Check if results sheet exists
    On Error Resume Next
    Set resultSheet = ThisWorkbook.Sheets("Results")
    On Error GoTo 0
    
    If resultSheet Is Nothing Then
        MsgBox "Please run the analysis first to generate results.", vbExclamation
        Exit Sub
    End If
    
    ' Create or clear summary worksheet
    On Error Resume Next
    Set summarySheet = ThisWorkbook.Sheets("Summary")
    On Error GoTo 0
    
    If summarySheet Is Nothing Then
        Set summarySheet = ThisWorkbook.Sheets.Add
        summarySheet.Name = "Summary"
    Else
        summarySheet.Cells.Clear
        ' Remove any existing charts
        For Each chartObj In summarySheet.ChartObjects
            chartObj.Delete
        Next chartObj
    End If
    
    ' Set up dictionary to track audio types
    Set audioTypes = CreateObject("Scripting.Dictionary")
    
    ' Count results
    lastRow = resultSheet.Cells(resultSheet.Rows.Count, 1).End(xlUp).Row
    
    For i = 2 To lastRow
        ' Count by status
        Select Case resultSheet.Cells(i, 4).Value
            Case "SAFE"
                safeCount = safeCount + 1
            Case "LOW"
                lowCount = lowCount + 1
            Case "DANGER"
                dangerCount = dangerCount + 1
        End Select
        
        ' Track audio types
        audioType = resultSheet.Cells(i, 2).Value
        If Not audioTypes.Exists(audioType) Then
            audioTypes.Add audioType, 1
        Else
            audioTypes(audioType) = audioTypes(audioType) + 1
        End If
    Next i
    
    ' Write summary
    With summarySheet
        .Cells(1, 1).Value = "Audio Measurement Analysis Summary"
        .Cells(1, 1).Font.Bold = True
        .Cells(1, 1).Font.Size = 14
        
        .Cells(3, 1).Value = "Total Measurements:"
        .Cells(3, 2).Value = lastRow - 1
        
        .Cells(4, 1).Value = "Safe Range (80-100 dB):"
        .Cells(4, 2).Value = safeCount
        .Cells(4, 3).Value = Format(safeCount / (lastRow - 1), "0.0%")
        
        .Cells(5, 1).Value = "Below Safe Range (<80 dB):"
        .Cells(5, 2).Value = lowCount
        .Cells(5, 3).Value = Format(lowCount / (lastRow - 1), "0.0%")
        
        .Cells(6, 1).Value = "Above Safe Range (>100 dB):"
        .Cells(6, 2).Value = dangerCount
        .Cells(6, 3).Value = Format(dangerCount / (lastRow - 1), "0.0%")
        
        ' Audio type breakdown
        .Cells(8, 1).Value = "Audio Type Breakdown:"
        .Cells(8, 1).Font.Bold = True
        
        i = 9
        For Each audioType In audioTypes.Keys
            .Cells(i, 1).Value = audioType
            .Cells(i, 2).Value = audioTypes(audioType)
            .Cells(i, 3).Value = Format(audioTypes(audioType) / (lastRow - 1), "0.0%")
            i = i + 1
        Next audioType
    End With
    
    ' Create pie chart for safety status
    Set chartObj = summarySheet.ChartObjects.Add(Left:=300, Width:=300, Top:=50, Height:=200)
    
    With chartObj.Chart
        .SetSourceData Source:=summarySheet.Range("A4:B6")
        .ChartType = xlPie
        .HasTitle = True
        .ChartTitle.Text = "Audio Safety Distribution"
        .ApplyLayout 2
        .ApplyDataLabels xlDataLabelsShowPercent
    End With
    
    ' Auto-fit columns
    summarySheet.Columns("A:C").AutoFit
    
    MsgBox "Summary report generated!", vbInformation
End Sub

' Create a sample text file for testing
Sub CreateSampleFile()
    Dim filePath As String
    Dim fileNum As Integer
    Dim fd As Office.FileDialog
    
    ' Create a default file path in the user's Documents folder
    filePath = Environ("HOME") & "/Documents/SampleAudioData.txt"
    
    ' Ask user if they want to use this default path
    If MsgBox("Create sample file at:" & vbCrLf & filePath & vbCrLf & vbCrLf & _
              "Click Yes to use this location, or No to select a different location.", _
              vbYesNo + vbQuestion, "Create Sample File") = vbNo Then
        
        ' Use FileDialog instead of GetSaveAsFilename for better macOS compatibility
        Set fd = Application.FileDialog(msoFileDialogSaveAs)
        
        With fd
            .Title = "Save Sample Audio Data File"
            .InitialFileName = "SampleAudioData.txt"
            .FilterIndex = 1
            
            If .Show = True Then
                filePath = .SelectedItems(1)
            Else
                MsgBox "Operation cancelled.", vbInformation
                Exit Sub
            End If
        End With
    End If
    
    ' Create the file
    On Error Resume Next
    fileNum = FreeFile
    Open filePath For Output As #fileNum
    
    If Err.Number <> 0 Then
        MsgBox "Error creating file: " & Err.Description, vbExclamation
        Exit Sub
    End If
    On Error GoTo 0
    
    ' Write sample data
    Print #fileNum, "Rock Music, 95.5"
    Print #fileNum, "Classical Music, 78.2"
    Print #fileNum, "Heavy Metal, 105.7"
    Print #fileNum, "Podcast, 82.3"
    Print #fileNum, "Movie Soundtrack, 88.9"
    Print #fileNum, "Industrial Noise, 110.2"
    Print #fileNum, "Ambient Sound, 65.4"
    Print #fileNum, "Live Concert, 98.7"
    Print #fileNum, "TV Show, 85.1"
    Print #fileNum, "Construction Site, 103.8"
    
    ' Close the file
    Close #fileNum
    
    MsgBox "Sample file created at:" & vbCrLf & filePath, vbInformation
End Sub
