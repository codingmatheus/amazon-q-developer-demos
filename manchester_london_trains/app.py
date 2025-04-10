from flask import Flask, render_template
import requests
from datetime import datetime
import os

app = Flask(__name__)

# This would normally come from a real API
# For demo purposes, we'll use mock data
def get_train_times():
    # In a real application, you would call a train API here
    # For example: response = requests.get('https://trainapi.example.com/manchester-london')
    
    # Mock data for demonstration
    return [
        {
            "departure": "06:15",
            "arrival": "08:30",
            "duration": "2h 15m",
            "operator": "Avanti West Coast",
            "price": "£65.00",
            "status": "On time"
        },
        {
            "departure": "07:00",
            "arrival": "09:15",
            "duration": "2h 15m",
            "operator": "Avanti West Coast",
            "price": "£78.50",
            "status": "On time"
        },
        {
            "departure": "07:30",
            "arrival": "09:45",
            "duration": "2h 15m",
            "operator": "Avanti West Coast",
            "price": "£78.50",
            "status": "Delayed 10m"
        },
        {
            "departure": "08:00",
            "arrival": "10:15",
            "duration": "2h 15m",
            "operator": "Avanti West Coast",
            "price": "£92.00",
            "status": "On time"
        },
        {
            "departure": "08:30",
            "arrival": "10:45",
            "duration": "2h 15m",
            "operator": "Avanti West Coast",
            "price": "£92.00",
            "status": "On time"
        },
        {
            "departure": "09:00",
            "arrival": "11:15",
            "duration": "2h 15m",
            "operator": "Avanti West Coast",
            "price": "£65.00",
            "status": "Cancelled"
        }
    ]

@app.route('/')
def index():
    train_times = get_train_times()
    current_date = datetime.now().strftime("%d %B %Y")
    return render_template('index.html', train_times=train_times, current_date=current_date)

if __name__ == '__main__':
    app.run(debug=True)
