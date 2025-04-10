using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;

namespace PoolLeagueTracker.Models
{
    public class League
    {
        public int Id { get; set; }
        
        [Required]
        [StringLength(100)]
        public string Name { get; set; } = string.Empty;
        
        [StringLength(500)]
        public string? Description { get; set; }
        
        public List<Team> Teams { get; set; } = new List<Team>();
        
        public DateTime StartDate { get; set; }
        
        public DateTime? EndDate { get; set; }
        
        public bool IsActive { get; set; } = true;
    }
}
