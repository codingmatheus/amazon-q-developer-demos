using ADHDDiagnosticApp.Models;
using Microsoft.EntityFrameworkCore;

namespace ADHDDiagnosticApp.Data
{
    public static class SeedData
    {
        public static void Initialize(ApplicationDbContext context)
        {
            // Check if we already have questions
            if (context.Questions.Any())
            {
                return; // DB has been seeded
            }

            // Add ADHD diagnostic questions
            var questions = new List<Question>
            {
                new Question
                {
                    Text = "How often do you have difficulty sustaining your attention when doing something for a long time?",
                    Category = "Attention",
                    Order = 1,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you have difficulty organizing tasks and activities?",
                    Category = "Organization",
                    Order = 2,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you fidget with your hands or feet or squirm in your seat?",
                    Category = "Hyperactivity",
                    Order = 3,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you feel restless or find it difficult to sit still for extended periods?",
                    Category = "Hyperactivity",
                    Order = 4,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you find yourself talking excessively?",
                    Category = "Hyperactivity",
                    Order = 5,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you have trouble waiting your turn or interrupting others?",
                    Category = "Impulsivity",
                    Order = 6,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you make careless mistakes or fail to pay close attention to details?",
                    Category = "Attention",
                    Order = 7,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you have difficulty following through on instructions or finishing tasks?",
                    Category = "Attention",
                    Order = 8,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often do you lose things necessary for tasks or activities?",
                    Category = "Organization",
                    Order = 9,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                },
                new Question
                {
                    Text = "How often are you easily distracted by external stimuli or unrelated thoughts?",
                    Category = "Attention",
                    Order = 10,
                    PossibleAnswers = new List<Answer>
                    {
                        new Answer { Text = "Never", Score = 0 },
                        new Answer { Text = "Rarely", Score = 1 },
                        new Answer { Text = "Sometimes", Score = 2 },
                        new Answer { Text = "Often", Score = 3 },
                        new Answer { Text = "Very Often", Score = 4 }
                    }
                }
            };

            context.Questions.AddRange(questions);
            context.SaveChanges();
        }
    }
}
