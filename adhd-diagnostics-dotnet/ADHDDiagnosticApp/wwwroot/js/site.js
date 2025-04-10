// JavaScript for enhancing the ADHD Diagnostic App

document.addEventListener('DOMContentLoaded', function() {
    // Highlight selected answer option
    const answerOptions = document.querySelectorAll('.answer-option');
    
    answerOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Find the radio input within this option
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                
                // Remove highlight from all options
                answerOptions.forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add highlight to selected option
                this.classList.add('selected');
            }
        });
    });
});
