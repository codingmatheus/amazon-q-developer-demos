# Z80 Chess Program

This is a simple 1K chess program written in Z80 assembly language. The program implements a basic chess game with a text-based interface.

## Files

- `chess_z80.asm`: The Z80 assembly source code for the chess program
- `chess_z80.bin`: The assembled binary file
- `z80_runner.c`: A simple Z80 emulator to demonstrate loading the program
- `Makefile`: Build instructions for assembling and running the program

## Requirements

The following tools are required to build and run the program:

- `z80asm`: Z80 assembler
- `gcc`: C compiler for the emulator
- `make`: Build automation tool

## Building and Running

To build the chess program and emulator:

```
make
```

To run the chess program in the emulator:

```
make run
```

## Program Features

- 8x8 chess board representation
- Basic piece movement
- Turn-based gameplay (alternating between white and black)
- Simple text-based interface
- Move input in algebraic notation (e.g., "e2-e4")

## Limitations

Due to the 1K size constraint, this implementation doesn't include:

- Full move validation (legal chess moves)
- Check/checkmate detection
- Special moves like castling or en passant
- Computer AI opponent

## Using a Full Z80 Emulator

For a more complete experience, consider using a dedicated Z80 emulator like:

- MAME/MESS
- Z80 Simulator IDE
- Fuse (Free Unix Spectrum Emulator)

## Memory Layout

- `$8000-$807F`: Chess board (8x8 = 64 bytes)
- `$8100-$810F`: Input buffer
- `$8110-$811F`: Move buffer
- `$8120`: Current player (0 = white, 1 = black)

## Piece Representation

- `0`: Empty square
- `1-6`: White pieces (Pawn, Knight, Bishop, Rook, Queen, King)
- `9-14`: Black pieces (Pawn, Knight, Bishop, Rook, Queen, King)
