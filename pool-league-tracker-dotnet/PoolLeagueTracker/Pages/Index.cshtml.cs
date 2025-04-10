using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PoolLeagueTracker.Data;
using PoolLeagueTracker.Models;

namespace PoolLeagueTracker.Pages
{
    public class IndexModel : PageModel
    {
        private readonly ApplicationDbContext _context;
        private readonly ILogger<IndexModel> _logger;

        public IndexModel(ApplicationDbContext context, ILogger<IndexModel> logger)
        {
            _context = context;
            _logger = logger;
        }

        public List<League> ActiveLeagues { get; set; } = new List<League>();
        public List<Match> UpcomingMatches { get; set; } = new List<Match>();
        public List<Team> TopTeams { get; set; } = new List<Team>();

        public async Task OnGetAsync()
        {
            // Get active leagues
            ActiveLeagues = await _context.Leagues
                .Where(l => l.IsActive)
                .Include(l => l.Teams)
                .ToListAsync();

            // Get upcoming matches
            UpcomingMatches = await _context.Matches
                .Where(m => !m.IsCompleted && m.MatchDate > DateTime.Now)
                .Include(m => m.HomeTeam)
                .Include(m => m.AwayTeam)
                .Include(m => m.League)
                .OrderBy(m => m.MatchDate)
                .Take(5)
                .ToListAsync();

            // Get top teams by points
            TopTeams = await _context.Teams
                .OrderByDescending(t => (t.Wins * 3) + t.Draws)
                .ThenByDescending(t => t.Wins)
                .Take(10)
                .ToListAsync();
        }
    }
}
