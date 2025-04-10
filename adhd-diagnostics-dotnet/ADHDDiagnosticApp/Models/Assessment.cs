namespace ADHDDiagnosticApp.Models
{
    public class Assessment
    {
        public int Id { get; set; }
        public DateTime CreatedAt { get; set; } = DateTime.Now;
        public int TotalScore { get; set; }
        public string Result { get; set; } = string.Empty;
        public List<Response> Responses { get; set; } = new List<Response>();
    }
}
