using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PoolLeagueTracker.Data;
using PoolLeagueTracker.Models;

namespace PoolLeagueTracker.Pages.Teams
{
    public class DetailsModel : PageModel
    {
        private readonly ApplicationDbContext _context;

        public DetailsModel(ApplicationDbContext context)
        {
            _context = context;
        }

        public Team Team { get; set; } = default!;
        public List<Match> TeamMatches { get; set; } = new List<Match>();

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var team = await _context.Teams
                .Include(t => t.Players)
                .FirstOrDefaultAsync(m => m.Id == id);
            
            if (team == null)
            {
                return NotFound();
            }
            
            Team = team;

            // Get matches for this team
            TeamMatches = await _context.Matches
                .Where(m => m.HomeTeamId == id || m.AwayTeamId == id)
                .Include(m => m.HomeTeam)
                .Include(m => m.AwayTeam)
                .OrderByDescending(m => m.MatchDate)
                .ToListAsync();

            return Page();
        }
    }
}
