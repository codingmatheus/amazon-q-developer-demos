namespace ADHDDiagnosticApp.Models
{
    public class Answer
    {
        public int Id { get; set; }
        public string Text { get; set; } = string.Empty;
        public int Score { get; set; }
        public int QuestionId { get; set; }
        public Question? Question { get; set; }
    }
}
