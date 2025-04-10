using Microsoft.EntityFrameworkCore;
using PoolLeagueTracker.Models;

namespace PoolLeagueTracker.Data
{
    public class ApplicationDbContext : DbContext
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options)
            : base(options)
        {
        }

        public DbSet<Team> Teams { get; set; }
        public DbSet<Player> Players { get; set; }
        public DbSet<League> Leagues { get; set; }
        public DbSet<Match> Matches { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Configure relationships
            modelBuilder.Entity<Team>()
                .HasMany(t => t.Players)
                .WithOne(p => p.Team)
                .HasForeignKey(p => p.TeamId);

            modelBuilder.Entity<League>()
                .HasMany(l => l.Teams);

            modelBuilder.Entity<Match>()
                .HasOne(m => m.HomeTeam)
                .WithMany()
                .HasForeignKey(m => m.HomeTeamId)
                .OnDelete(DeleteBehavior.Restrict);

            modelBuilder.Entity<Match>()
                .HasOne(m => m.AwayTeam)
                .WithMany()
                .HasForeignKey(m => m.AwayTeamId)
                .OnDelete(DeleteBehavior.Restrict);

            // Seed some initial data
            SeedData(modelBuilder);
        }

        private void SeedData(ModelBuilder modelBuilder)
        {
            // Seed a league
            modelBuilder.Entity<League>().HasData(
                new League { Id = 1, Name = "City Pool League", Description = "Official city-wide pool league", StartDate = DateTime.Now.AddDays(-30), IsActive = true }
            );

            // Seed teams
            modelBuilder.Entity<Team>().HasData(
                new Team { Id = 1, Name = "Cue Masters", Location = "Downtown Billiards", Wins = 5, Losses = 2, Draws = 1 },
                new Team { Id = 2, Name = "Pocket Rockets", Location = "Westside Pool Hall", Wins = 4, Losses = 3, Draws = 1 },
                new Team { Id = 3, Name = "Break Kings", Location = "Eastside Lounge", Wins = 6, Losses = 1, Draws = 1 },
                new Team { Id = 4, Name = "Chalk Dusters", Location = "Northside Bar", Wins = 3, Losses = 4, Draws = 1 }
            );

            // Seed players
            modelBuilder.Entity<Player>().HasData(
                new Player { Id = 1, Name = "John Smith", TeamId = 1, GamesWon = 12, GamesLost = 4 },
                new Player { Id = 2, Name = "Sarah Johnson", TeamId = 1, GamesWon = 10, GamesLost = 6 },
                new Player { Id = 3, Name = "Mike Williams", TeamId = 2, GamesWon = 8, GamesLost = 7 },
                new Player { Id = 4, Name = "Lisa Brown", TeamId = 2, GamesWon = 9, GamesLost = 5 },
                new Player { Id = 5, Name = "David Lee", TeamId = 3, GamesWon = 14, GamesLost = 2 },
                new Player { Id = 6, Name = "Emma Wilson", TeamId = 3, GamesWon = 11, GamesLost = 5 },
                new Player { Id = 7, Name = "Robert Taylor", TeamId = 4, GamesWon = 7, GamesLost = 8 },
                new Player { Id = 8, Name = "Jennifer Davis", TeamId = 4, GamesWon = 8, GamesLost = 7 }
            );

            // Seed matches
            modelBuilder.Entity<Match>().HasData(
                new Match { Id = 1, HomeTeamId = 1, AwayTeamId = 2, HomeTeamScore = 5, AwayTeamScore = 3, MatchDate = DateTime.Now.AddDays(-20), LeagueId = 1, IsCompleted = true },
                new Match { Id = 2, HomeTeamId = 3, AwayTeamId = 4, HomeTeamScore = 6, AwayTeamScore = 2, MatchDate = DateTime.Now.AddDays(-20), LeagueId = 1, IsCompleted = true },
                new Match { Id = 3, HomeTeamId = 1, AwayTeamId = 3, HomeTeamScore = 4, AwayTeamScore = 4, MatchDate = DateTime.Now.AddDays(-13), LeagueId = 1, IsCompleted = true },
                new Match { Id = 4, HomeTeamId = 2, AwayTeamId = 4, HomeTeamScore = 5, AwayTeamScore = 3, MatchDate = DateTime.Now.AddDays(-13), LeagueId = 1, IsCompleted = true },
                new Match { Id = 5, HomeTeamId = 2, AwayTeamId = 3, HomeTeamScore = 0, AwayTeamScore = 0, MatchDate = DateTime.Now.AddDays(7), LeagueId = 1, IsCompleted = false },
                new Match { Id = 6, HomeTeamId = 4, AwayTeamId = 1, HomeTeamScore = 0, AwayTeamScore = 0, MatchDate = DateTime.Now.AddDays(7), LeagueId = 1, IsCompleted = false }
            );
        }
    }
}
