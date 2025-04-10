using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.ComponentModel.DataAnnotations;

namespace MatheusPersonalSite.Pages
{
    public class ContactModel : PageModel
    {
        private readonly ILogger<ContactModel> _logger;

        public ContactModel(ILogger<ContactModel> logger)
        {
            _logger = logger;
        }

        [BindProperty]
        public ContactFormModel ContactForm { get; set; } = new();

        public bool FormSubmitted { get; private set; }

        public void OnGet()
        {
        }

        public IActionResult OnPost()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            // In a real application, you would process the form submission here
            // For example, send an email or save to a database
            _logger.LogInformation($"Contact form submitted by {ContactForm.Name} ({ContactForm.Email})");
            
            FormSubmitted = true;
            ModelState.Clear();
            ContactForm = new ContactFormModel();
            
            return Page();
        }
    }

    public class ContactFormModel
    {
        [Required]
        [StringLength(100)]
        public string Name { get; set; } = string.Empty;

        [Required]
        [EmailAddress]
        public string Email { get; set; } = string.Empty;

        [Required]
        [StringLength(200)]
        public string Subject { get; set; } = string.Empty;

        [Required]
        [StringLength(2000)]
        public string Message { get; set; } = string.Empty;
    }
}
