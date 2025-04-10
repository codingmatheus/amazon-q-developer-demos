# Blue Lottery Web App

A simple Flask-based lottery web application with a blue theme. Users can select 6 numbers from 1 to 30, and the app will draw random numbers and show the results.

## Features

- Select 6 unique numbers from 1 to 30
- Random drawing of winning numbers
- Results page showing matches and prizes
- Responsive blue-themed design

## Installation

1. Clone this repository
2. Install the required packages:

```bash
pip install -r requirements.txt
```

## Running the Application

```bash
python app.py
```

The application will be available at http://127.0.0.1:5000/

## How to Play

1. Select exactly 6 numbers from the grid (1-30)
2. Click "Draw Numbers" to see the results
3. The app will show your selected numbers, the winning numbers, and any matches
4. Play again as many times as you want!

## Prize Structure

- 0 matches: No prize
- 1 match: No prize
- 2 matches: Small prize
- 3 matches: Decent prize
- 4 matches: Good prize
- 5 matches: Great prize
- 6 matches: JACKPOT!
