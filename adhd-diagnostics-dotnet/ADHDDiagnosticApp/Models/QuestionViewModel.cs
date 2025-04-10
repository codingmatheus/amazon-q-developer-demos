namespace ADHDDiagnosticApp.Models
{
    public class QuestionViewModel
    {
        public Question CurrentQuestion { get; set; } = new Question();
        public int SelectedAnswerId { get; set; }
        public int CurrentQuestionIndex { get; set; }
        public int TotalQuestions { get; set; }
        public int AssessmentId { get; set; }
    }
}
