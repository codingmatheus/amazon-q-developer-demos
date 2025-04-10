Attribute VB_Name = "DirectProcessFile"
Option Explicit

' Constants for safety thresholds
Const MIN_SAFE_DB As Double = 80
Const MAX_SAFE_DB As Double = 100

' This is a simplified procedure that directly processes a specific file
' Use this if you're having trouble with the file dialog
Sub ProcessSpecificFile()
    Dim filePath As String
    Dim resultSheet As Worksheet
    
    ' Ask for the file path directly
    filePath = InputBox("Please enter the full path to your audio data file:" & vbCrLf & _
                       "(For example: /Users/guimathe/Documents/SampleAudioData.txt)", _
                       "Enter File Path")
    
    If filePath = "" Then
        MsgBox "Operation cancelled.", vbInformation
        Exit Sub
    End If
    
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
    
    ' Process the file
    DirectProcessFileInternal filePath, resultSheet
    
    ' Auto-fit columns for better readability
    resultSheet.Columns("A:E").AutoFit
    
    MsgBox "Audio measurement analysis complete!", vbInformation
End Sub

' Internal processing function
Sub DirectProcessFileInternal(filePath As String, resultSheet As Worksheet)
    Dim fileNum As Integer
    Dim line As String
    Dim parts() As String
    Dim audioType As String
    Dim decibelValue As Double
    Dim rowIndex As Long
    Dim fileName As String
    
    ' Extract file name from path
    On Error Resume Next
    fileName = Mid(filePath, InStrRev(filePath, "/") + 1)
    If fileName = "" Then
        fileName = filePath
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
