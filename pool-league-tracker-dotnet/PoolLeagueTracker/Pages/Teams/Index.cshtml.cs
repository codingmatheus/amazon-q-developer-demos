using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PoolLeagueTracker.Data;
using PoolLeagueTracker.Models;

namespace PoolLeagueTracker.Pages.Teams
{
    public class IndexModel : PageModel
    {
        private readonly ApplicationDbContext _context;

        public IndexModel(ApplicationDbContext context)
        {
            _context = context;
        }

        public IList<Team> Teams { get; set; } = default!;

        public async Task OnGetAsync()
        {
            Teams = await _context.Teams
                .OrderByDescending(t => (t.Wins * 3) + t.Draws)
                .ThenByDescending(t => t.Wins)
                .ToListAsync();
        }
    }
}
