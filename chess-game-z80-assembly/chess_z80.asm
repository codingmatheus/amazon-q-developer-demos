; =======================================
; 1K Chess Program for Z80
; =======================================
; A minimal chess implementation in Z80 assembly
; Fits in 1K of memory with basic functionality
; =======================================

; Memory layout
BOARD_START:     EQU $8000      ; Start of board in memory
SCREEN_START:    EQU $4000      ; Screen memory location
INPUT_BUFFER:    EQU $8100      ; Buffer for user input
MOVE_BUFFER:     EQU $8110      ; Buffer for move generation

; Piece definitions
EMPTY:          EQU 0
W_PAWN:         EQU 1
W_KNIGHT:       EQU 2
W_BISHOP:       EQU 3
W_ROOK:         EQU 4
W_QUEEN:        EQU 5
W_KING:         EQU 6
B_PAWN:         EQU 9
B_KNIGHT:       EQU 10
B_BISHOP:       EQU 11
B_ROOK:         EQU 12
B_QUEEN:        EQU 13
B_KING:         EQU 14

; Game state
CURRENT_PLAYER: EQU $8120       ; 0 = white, 1 = black

; ASCII characters for pieces
PIECE_CHARS:    DB " PNBRQKpnbrqk"

    ORG $0000

; =======================================
; Program entry point
; =======================================
START:
    CALL INIT_BOARD
    CALL DISPLAY_BOARD
    JP MAIN_LOOP

; =======================================
; Initialize the chess board
; =======================================
INIT_BOARD:
    LD HL, BOARD_START
    LD B, 64                    ; 8x8 board
    LD A, EMPTY
    
CLEAR_BOARD:
    LD (HL), A
    INC HL
    DJNZ CLEAR_BOARD
    
    ; Set up white pieces
    LD HL, BOARD_START+48       ; 6th rank (from bottom)
    LD B, 8
    LD A, W_PAWN
    
WHITE_PAWNS:
    LD (HL), A
    INC HL
    DJNZ WHITE_PAWNS
    
    ; White back rank
    LD HL, BOARD_START+56       ; 8th rank (from bottom)
    LD (HL), W_ROOK
    INC HL
    LD (HL), W_KNIGHT
    INC HL
    LD (HL), W_BISHOP
    INC HL
    LD (HL), W_QUEEN
    INC HL
    LD (HL), W_KING
    INC HL
    LD (HL), W_BISHOP
    INC HL
    LD (HL), W_KNIGHT
    INC HL
    LD (HL), W_ROOK
    
    ; Set up black pieces
    LD HL, BOARD_START+8        ; 2nd rank (from bottom)
    LD B, 8
    LD A, B_PAWN
    
BLACK_PAWNS:
    LD (HL), A
    INC HL
    DJNZ BLACK_PAWNS
    
    ; Black back rank
    LD HL, BOARD_START          ; 1st rank (from bottom)
    LD (HL), B_ROOK
    INC HL
    LD (HL), B_KNIGHT
    INC HL
    LD (HL), B_BISHOP
    INC HL
    LD (HL), B_QUEEN
    INC HL
    LD (HL), B_KING
    INC HL
    LD (HL), B_BISHOP
    INC HL
    LD (HL), B_KNIGHT
    INC HL
    LD (HL), B_ROOK
    
    ; Initialize current player to white
    LD A, 0
    LD (CURRENT_PLAYER), A
    
    RET

; =======================================
; Display the chess board
; =======================================
DISPLAY_BOARD:
    LD HL, SCREEN_START
    LD DE, BOARD_START
    LD C, 8                     ; 8 rows
    
ROW_LOOP:
    LD B, 8                     ; 8 columns
    
    ; Print row number
    LD A, '1'
    ADD A, 8
    SUB C
    LD (HL), A
    INC HL
    LD (HL), ' '
    INC HL
    
COL_LOOP:
    LD A, (DE)                  ; Get piece from board
    CALL GET_PIECE_CHAR
    LD (HL), A                  ; Display piece
    INC HL
    LD (HL), ' '                ; Add space
    INC HL
    INC DE                      ; Next board position
    DJNZ COL_LOOP
    
    ; New line
    LD (HL), 13                 ; Carriage return
    INC HL
    LD (HL), 10                 ; Line feed
    INC HL
    
    DEC C
    JR NZ, ROW_LOOP
    
    ; Print column letters
    LD (HL), ' '
    INC HL
    LD (HL), ' '
    INC HL
    
    LD B, 8
    LD A, 'a'
    
PRINT_COLS:
    LD (HL), A
    INC HL
    LD (HL), ' '
    INC HL
    INC A
    DJNZ PRINT_COLS
    
    RET

; =======================================
; Get character for piece
; =======================================
GET_PIECE_CHAR:
    LD HL, PIECE_CHARS
    LD B, 0
    LD C, A
    ADD HL, BC
    LD A, (HL)
    RET

; =======================================
; Main game loop
; =======================================
MAIN_LOOP:
    ; Display current player
    LD A, (CURRENT_PLAYER)
    OR A
    JR NZ, BLACK_TURN
    
    ; White's turn
    LD HL, WHITE_MSG
    CALL PRINT_STRING
    JR GET_MOVE
    
BLACK_TURN:
    LD HL, BLACK_MSG
    CALL PRINT_STRING
    
GET_MOVE:
    CALL READ_INPUT
    CALL PARSE_MOVE
    JR C, INVALID_MOVE
    
    CALL MAKE_MOVE
    CALL DISPLAY_BOARD
    
    ; Switch player
    LD A, (CURRENT_PLAYER)
    XOR 1
    LD (CURRENT_PLAYER), A
    
    JP MAIN_LOOP
    
INVALID_MOVE:
    LD HL, INVALID_MSG
    CALL PRINT_STRING
    JP MAIN_LOOP

; =======================================
; Print null-terminated string
; =======================================
PRINT_STRING:
    LD A, (HL)
    OR A
    RET Z
    RST $10                     ; Print character
    INC HL
    JR PRINT_STRING

; =======================================
; Read input from user
; =======================================
READ_INPUT:
    LD HL, INPUT_BUFFER
    LD B, 5                     ; Max 5 chars (e.g., "e2-e4")
    
READ_CHAR:
    RST $08                     ; Get character
    CP 13                       ; Check for Enter
    JR Z, END_INPUT
    LD (HL), A
    INC HL
    DJNZ READ_CHAR
    
END_INPUT:
    LD (HL), 0                  ; Null-terminate
    RET

; =======================================
; Parse move from input buffer
; =======================================
PARSE_MOVE:
    LD HL, INPUT_BUFFER
    
    ; Parse source square
    LD A, (HL)                  ; Get file (a-h)
    SUB 'a'
    JR C, PARSE_ERROR
    CP 8
    JR NC, PARSE_ERROR
    LD B, A                     ; B = source file
    
    INC HL
    LD A, (HL)                  ; Get rank (1-8)
    SUB '1'
    JR C, PARSE_ERROR
    CP 8
    JR NC, PARSE_ERROR
    LD C, A                     ; C = source rank
    
    ; Check for separator
    INC HL
    LD A, (HL)
    CP '-'
    JR NZ, PARSE_ERROR
    
    ; Parse destination square
    INC HL
    LD A, (HL)                  ; Get file (a-h)
    SUB 'a'
    JR C, PARSE_ERROR
    CP 8
    JR NC, PARSE_ERROR
    LD D, A                     ; D = dest file
    
    INC HL
    LD A, (HL)                  ; Get rank (1-8)
    SUB '1'
    JR C, PARSE_ERROR
    CP 8
    JR NC, PARSE_ERROR
    LD E, A                     ; E = dest rank
    
    ; Store parsed move
    LD HL, MOVE_BUFFER
    LD (HL), B                  ; Source file
    INC HL
    LD (HL), C                  ; Source rank
    INC HL
    LD (HL), D                  ; Dest file
    INC HL
    LD (HL), E                  ; Dest rank
    
    OR A                        ; Clear carry flag (success)
    RET
    
PARSE_ERROR:
    SCF                         ; Set carry flag (error)
    RET

; =======================================
; Make a move on the board
; =======================================
MAKE_MOVE:
    ; Get source and destination coordinates
    LD HL, MOVE_BUFFER
    LD B, (HL)                  ; Source file
    INC HL
    LD C, (HL)                  ; Source rank
    INC HL
    LD D, (HL)                  ; Dest file
    INC HL
    LD E, (HL)                  ; Dest rank
    
    ; Calculate source address
    LD HL, BOARD_START
    LD A, C
    LD C, 8
    MUL_LOOP1:
    ADD HL, BC
    DEC A
    JR NZ, MUL_LOOP1
    LD C, B
    LD B, 0
    ADD HL, BC                  ; HL = source address
    
    ; Get piece at source
    LD A, (HL)
    LD (MOVE_BUFFER+4), A       ; Store piece
    
    ; Calculate destination address
    LD HL, BOARD_START
    LD A, E
    LD C, 8
    MUL_LOOP2:
    ADD HL, BC
    DEC A
    JR NZ, MUL_LOOP2
    LD C, D
    LD B, 0
    ADD HL, BC                  ; HL = destination address
    
    ; Move piece
    LD A, (MOVE_BUFFER+4)
    LD (HL), A
    
    ; Clear source square
    LD HL, BOARD_START
    LD A, C
    LD C, 8
    MUL_LOOP3:
    ADD HL, BC
    DEC A
    JR NZ, MUL_LOOP3
    LD C, B
    LD B, 0
    ADD HL, BC                  ; HL = source address
    LD (HL), EMPTY
    
    RET

; =======================================
; Messages
; =======================================
WHITE_MSG:      DB "White's move: ", 0
BLACK_MSG:      DB "Black's move: ", 0
INVALID_MSG:    DB "Invalid move! Try again.", 13, 10, 0

; =======================================
; End of program
; =======================================
    END START
