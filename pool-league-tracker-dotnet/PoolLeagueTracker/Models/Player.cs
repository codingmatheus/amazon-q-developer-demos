using System.ComponentModel.DataAnnotations;

namespace PoolLeagueTracker.Models
{
    public class Player
    {
        public int Id { get; set; }
        
        [Required]
        [StringLength(100)]
        public string Name { get; set; } = string.Empty;
        
        public int TeamId { get; set; }
        
        public Team? Team { get; set; }
        
        public int GamesWon { get; set; }
        
        public int GamesLost { get; set; }
        
        public double WinPercentage => GamesWon + GamesLost > 0 
            ? (double)GamesWon / (GamesWon + GamesLost) * 100 
            : 0;
    }
}
