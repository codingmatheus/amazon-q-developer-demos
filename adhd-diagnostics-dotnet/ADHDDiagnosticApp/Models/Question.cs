namespace ADHDDiagnosticApp.Models
{
    public class Question
    {
        public int Id { get; set; }
        public string Text { get; set; } = string.Empty;
        public string Category { get; set; } = string.Empty;
        public int Order { get; set; }
        public List<Answer> PossibleAnswers { get; set; } = new List<Answer>();
    }
}
