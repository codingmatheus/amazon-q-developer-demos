// Main JavaScript file for NexusAI website

document.addEventListener('DOMContentLoaded', function() {
    // Mobile navigation toggle
    const createMobileMenu = () => {
        const header = document.querySelector('header');
        const nav = document.querySelector('nav');
        
        // Create mobile menu button
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.classList.add('mobile-menu-btn');
        mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
        mobileMenuBtn.style.display = 'none';
        
        // Insert button before nav
        header.querySelector('.container').insertBefore(mobileMenuBtn, nav);
        
        // Toggle menu on click
        mobileMenuBtn.addEventListener('click', () => {
            nav.classList.toggle('active');
            mobileMenuBtn.innerHTML = nav.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });
        
        // Handle responsive behavior
        const handleResize = () => {
            if (window.innerWidth <= 768) {
                mobileMenuBtn.style.display = 'block';
                nav.classList.add('mobile');
            } else {
                mobileMenuBtn.style.display = 'none';
                nav.classList.remove('mobile', 'active');
            }
        };
        
        // Initial check and event listener
        handleResize();
        window.addEventListener('resize', handleResize);
    };
    
    // Smooth scrolling for anchor links
    const setupSmoothScrolling = () => {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    };
    
    // Add active class to current page in navigation
    const highlightCurrentPage = () => {
        const currentPage = window.location.pathname.split('/').pop();
        
        document.querySelectorAll('nav ul li a').forEach(link => {
            const linkPage = link.getAttribute('href');
            if (linkPage === currentPage || 
                (currentPage === '' && linkPage === 'index.html')) {
                link.classList.add('active');
            }
        });
    };
    
    // Initialize functions
    createMobileMenu();
    setupSmoothScrolling();
    highlightCurrentPage();
    
    // Simple form validation for contact form
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let valid = true;
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const messageInput = document.getElementById('message');
            
            // Reset error states
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            
            // Validate name
            if (!nameInput.value.trim()) {
                addErrorMessage(nameInput, 'Please enter your name');
                valid = false;
            }
            
            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value.trim())) {
                addErrorMessage(emailInput, 'Please enter a valid email address');
                valid = false;
            }
            
            // Validate message
            if (!messageInput.value.trim()) {
                addErrorMessage(messageInput, 'Please enter your message');
                valid = false;
            }
            
            if (valid) {
                // Show success message (in a real site, this would submit to a server)
                const successMessage = document.createElement('div');
                successMessage.classList.add('success-message');
                successMessage.textContent = 'Thank you for your message! We will get back to you soon.';
                contactForm.innerHTML = '';
                contactForm.appendChild(successMessage);
            }
        });
    }
    
    function addErrorMessage(inputElement, message) {
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message');
        errorMessage.textContent = message;
        inputElement.parentNode.appendChild(errorMessage);
        inputElement.classList.add('error');
    }
    
    // Simple animation for elements when they come into view
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.feature-card, .value-card, .team-member, .about-text');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        elements.forEach(element => {
            observer.observe(element);
        });
    };
    
    // Initialize animations if IntersectionObserver is supported
    if ('IntersectionObserver' in window) {
        animateOnScroll();
    }
});
