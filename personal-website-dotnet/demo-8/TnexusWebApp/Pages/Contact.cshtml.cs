using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.ComponentModel.DataAnnotations;

namespace TnexusWebApp.Pages
{
    public class ContactModel : PageModel
    {
        private readonly ILogger<ContactModel> _logger;

        [BindProperty]
        public ContactForm Contact { get; set; } = new ContactForm();

        public bool FormSubmitted { get; private set; }

        public ContactModel(ILogger<ContactModel> logger)
        {
            _logger = logger;
        }

        public void OnGet()
        {
            FormSubmitted = false;
        }

        public IActionResult OnPost()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            // In a real application, you would process the form data here
            // For example, send an email or save to a database
            _logger.LogInformation($"Contact form submitted by {Contact.Name} ({Contact.Email})");
            
            FormSubmitted = true;
            ModelState.Clear();
            Contact = new ContactForm();
            
            return Page();
        }
    }

    public class ContactForm
    {
        [Required]
        public string Name { get; set; } = string.Empty;

        [Required]
        [EmailAddress]
        public string Email { get; set; } = string.Empty;

        [Required]
        public string Subject { get; set; } = string.Empty;

        [Required]
        public string Message { get; set; } = string.Empty;
    }
}
