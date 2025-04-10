from flask import Flask, render_template, request, redirect, url_for, session
import random
import os

app = Flask(__name__)
app.secret_key = os.urandom(24)  # Set a secret key for session management

@app.route('/about')
def about():
    return render_template('about.html')

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        # Get selected numbers from form
        selected_numbers = []
        for i in range(1, 7):  # We'll let users pick 6 numbers
            num = request.form.get(f'number{i}')
            if num and num.isdigit():
                selected_numbers.append(int(num))
        
        # Validate selection (must be 6 unique numbers between 1-30)
        if len(selected_numbers) == 6 and len(set(selected_numbers)) == 6 and all(1 <= n <= 30 for n in selected_numbers):
            # Store selected numbers in session
            session['selected_numbers'] = selected_numbers
            return redirect(url_for('results'))
        else:
            error = "Please select 6 unique numbers between 1 and 30."
            return render_template('index.html', error=error)
    
    return render_template('index.html')

@app.route('/results')
def results():
    if 'selected_numbers' not in session:
        return redirect(url_for('index'))
    
    selected_numbers = session['selected_numbers']
    
    # Draw winning numbers (6 unique numbers between 1-30)
    winning_numbers = random.sample(range(1, 31), 6)
    
    # Check matches
    matches = set(selected_numbers).intersection(set(winning_numbers))
    num_matches = len(matches)
    
    # Determine prize based on matches
    prize = {
        0: "Sorry, no matches. Try again!",
        1: "1 match. No prize, but nice try!",
        2: "2 matches. You win a small prize!",
        3: "3 matches. You win a decent prize!",
        4: "4 matches. You win a good prize!",
        5: "5 matches. You win a great prize!",
        6: "JACKPOT! All 6 numbers match. You win the grand prize!"
    }
    
    return render_template('results.html', 
                          selected_numbers=sorted(selected_numbers),
                          winning_numbers=sorted(winning_numbers),
                          matches=sorted(matches),
                          num_matches=num_matches,
                          prize=prize[num_matches])

if __name__ == '__main__':
    app.run(debug=True)
