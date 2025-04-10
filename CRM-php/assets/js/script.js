/**
 * BlueCRM JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    document.getElementById('sidebarCollapse').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('content').classList.toggle('active');
    });
    
    // Initialize tabs
    const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
    if (tabLinks.length > 0) {
        tabLinks.forEach(function(tabLink) {
            tabLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get the tab target
                const tabId = this.getAttribute('href').substring(1);
                
                // Hide all tab panes
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('active');
                });
                
                // Show the selected tab pane
                document.getElementById(tabId).classList.add('active');
                
                // Update active tab
                document.querySelectorAll('.nav-tabs .nav-link').forEach(function(link) {
                    link.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    }
    
    // Contact search functionality
    const contactSearch = document.getElementById('contactSearch');
    if (contactSearch) {
        contactSearch.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            
            tableRows.forEach(function(row) {
                const name = row.cells[0].textContent.toLowerCase();
                const company = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(searchValue) || company.includes(searchValue) || email.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Contact filter functionality
    const contactFilter = document.getElementById('contactFilter');
    if (contactFilter) {
        contactFilter.addEventListener('change', function() {
            const filterValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            
            tableRows.forEach(function(row) {
                if (!filterValue) {
                    row.style.display = '';
                    return;
                }
                
                const type = row.cells[4].textContent.toLowerCase();
                if (type.includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Highlight invalid fields
                const invalidFields = form.querySelectorAll(':invalid');
                invalidFields.forEach(function(field) {
                    field.classList.add('is-invalid');
                    
                    field.addEventListener('input', function() {
                        if (this.checkValidity()) {
                            this.classList.remove('is-invalid');
                        }
                    });
                });
                
                // Show validation message
                const firstInvalid = invalidFields[0];
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });
    });
    
    // Notification dropdown toggle
    const notificationBtn = document.querySelector('.notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    }
    
    // User dropdown toggle
    const userBtn = document.querySelector('.user-btn');
    if (userBtn) {
        userBtn.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.notification-btn') && !event.target.matches('.user-btn')) {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(function(dropdown) {
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            });
        }
    });
});
