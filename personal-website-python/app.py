from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

@app.route('/')
def home():
    return render_template('home.html', title='Home')

@app.route('/about')
def about():
    return render_template('about.html', title='About')

@app.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        # Here you would process the form data
        # For now, we'll just redirect back to the contact page
        # In a real application, you might send an email or store in a database
        return redirect(url_for('contact'))
    return render_template('contact.html', title='Contact')

if __name__ == '__main__':
    app.run(debug=True)
