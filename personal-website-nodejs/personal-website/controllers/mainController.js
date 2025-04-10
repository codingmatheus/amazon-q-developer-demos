const User = require('../models/User');

// Controller for main pages
exports.getHomePage = (req, res) => {
  res.render('pages/home', {
    title: 'Matheus Guimaraes | Home',
    name: 'Matheus Guimaraes',
    social: 'codingmatheus'
  });
};

exports.getAboutPage = (req, res) => {
  res.render('pages/about', {
    title: 'Matheus Guimaraes | About',
    name: 'Matheus Guimaraes',
    social: 'codingmatheus'
  });
};

exports.getContactPage = (req, res) => {
  res.render('pages/contact', {
    title: 'Matheus Guimaraes | Contact',
    name: 'Matheus Guimaraes',
    social: 'codingmatheus'
  });
};

exports.postContactForm = (req, res) => {
  const { name, email, message } = req.body;
  
  // Create a new user with the form data
  const newContact = new User(name, email, message);
  
  // In a real app, you would save this to a database
  console.log('New contact form submission:', newContact);
  
  // Redirect back to contact page with success message
  res.render('pages/contact', {
    title: 'Matheus Guimaraes | Contact',
    name: 'Matheus Guimaraes',
    social: 'codingmatheus',
    success: 'Your message has been sent successfully!'
  });
};
