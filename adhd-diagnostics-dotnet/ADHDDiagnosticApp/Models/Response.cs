namespace ADHDDiagnosticApp.Models
{
    public class Response
    {
        public int Id { get; set; }
        public int QuestionId { get; set; }
        public Question? Question { get; set; }
        public int AnswerId { get; set; }
        public Answer? Answer { get; set; }
        public int AssessmentId { get; set; }
        public Assessment? Assessment { get; set; }
    }
}
