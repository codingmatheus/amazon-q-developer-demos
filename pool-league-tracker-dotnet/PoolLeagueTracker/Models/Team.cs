using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;

namespace PoolLeagueTracker.Models
{
    public class Team
    {
        public int Id { get; set; }
        
        [Required]
        [StringLength(100)]
        public string Name { get; set; } = string.Empty;
        
        [StringLength(200)]
        public string? Location { get; set; }
        
        public int Wins { get; set; }
        
        public int Losses { get; set; }
        
        public int Draws { get; set; }
        
        public int MatchesPlayed => Wins + Losses + Draws;
        
        public int Points => (Wins * 3) + Draws;
        
        public List<Player> Players { get; set; } = new List<Player>();
    }
}
