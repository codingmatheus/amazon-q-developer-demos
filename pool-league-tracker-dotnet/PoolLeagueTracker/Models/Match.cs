using System;
using System.ComponentModel.DataAnnotations;

namespace PoolLeagueTracker.Models
{
    public class Match
    {
        public int Id { get; set; }
        
        public int HomeTeamId { get; set; }
        public Team? HomeTeam { get; set; }
        
        public int AwayTeamId { get; set; }
        public Team? AwayTeam { get; set; }
        
        public int HomeTeamScore { get; set; }
        public int AwayTeamScore { get; set; }
        
        public DateTime MatchDate { get; set; }
        
        public int LeagueId { get; set; }
        public League? League { get; set; }
        
        public bool IsCompleted { get; set; }
        
        public string Result => IsCompleted 
            ? HomeTeamScore > AwayTeamScore 
                ? "Home Win" 
                : HomeTeamScore < AwayTeamScore 
                    ? "Away Win" 
                    : "Draw"
            : "Pending";
    }
}
