using ADHDDiagnosticApp.Models;
using Microsoft.EntityFrameworkCore;

namespace ADHDDiagnosticApp.Data
{
    public class ApplicationDbContext : DbContext
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options)
            : base(options)
        {
        }

        public DbSet<Question> Questions { get; set; }
        public DbSet<Answer> Answers { get; set; }
        public DbSet<Assessment> Assessments { get; set; }
        public DbSet<Response> Responses { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            modelBuilder.Entity<Question>()
                .HasMany(q => q.PossibleAnswers)
                .WithOne(a => a.Question)
                .HasForeignKey(a => a.QuestionId);

            modelBuilder.Entity<Assessment>()
                .HasMany(a => a.Responses)
                .WithOne(r => r.Assessment)
                .HasForeignKey(r => r.AssessmentId);
        }
    }
}
