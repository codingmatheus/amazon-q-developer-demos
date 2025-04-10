from flask import Flask, render_template, request, redirect, url_for, flash
import os

app = Flask(__name__)
app.secret_key = os.urandom(24)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/speakers')
def speakers():
    return render_template('speakers.html')

@app.route('/schedule')
def schedule():
    return render_template('schedule.html')

@app.route('/venue')
def venue():
    return render_template('venue.html')

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        # In a real application, you would process the form data here
        # For example, save to database, send confirmation email, etc.
        flash('Thank you for registering for DTX Manchester! A confirmation email has been sent to your inbox.')
        return redirect(url_for('index'))
    return render_template('register.html')

if __name__ == '__main__':
    app.run(debug=True)
