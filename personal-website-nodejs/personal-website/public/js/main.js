// Main JavaScript file for the personal website

document.addEventListener('DOMContentLoaded', function() {
  // Add active class to current navigation item
  const currentLocation = window.location.pathname;
  const navLinks = document.querySelectorAll('nav ul li a');
  
  navLinks.forEach(link => {
    const linkPath = link.getAttribute('href');
    if (currentLocation === linkPath) {
      link.style.borderBottom = '2px solid #1e88e5';
    }
  });
  
  // Form validation for contact form
  const contactForm = document.querySelector('form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      const nameInput = document.getElementById('name');
      const emailInput = document.getElementById('email');
      const messageInput = document.getElementById('message');
      
      let isValid = true;
      
      if (nameInput.value.trim() === '') {
        isValid = false;
        highlightInvalid(nameInput);
      } else {
        removeHighlight(nameInput);
      }
      
      if (emailInput.value.trim() === '' || !isValidEmail(emailInput.value)) {
        isValid = false;
        highlightInvalid(emailInput);
      } else {
        removeHighlight(emailInput);
      }
      
      if (messageInput.value.trim() === '') {
        isValid = false;
        highlightInvalid(messageInput);
      } else {
        removeHighlight(messageInput);
      }
      
      if (!isValid) {
        e.preventDefault();
      }
    });
  }
  
  // Helper functions for form validation
  function highlightInvalid(element) {
    element.style.borderColor = 'red';
  }
  
  function removeHighlight(element) {
    element.style.borderColor = '#ddd';
  }
  
  function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
});
