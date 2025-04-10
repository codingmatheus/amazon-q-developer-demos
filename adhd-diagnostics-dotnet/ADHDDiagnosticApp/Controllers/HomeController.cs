using System.Diagnostics;
using Microsoft.AspNetCore.Mvc;
using ADHDDiagnosticApp.Models;
using ADHDDiagnosticApp.Data;
using Microsoft.EntityFrameworkCore;

namespace ADHDDiagnosticApp.Controllers;

public class HomeController : Controller
{
    private readonly ILogger<HomeController> _logger;
    private readonly ApplicationDbContext _context;

    public HomeController(ILogger<HomeController> logger, ApplicationDbContext context)
    {
        _logger = logger;
        _context = context;
    }

    public IActionResult Index()
    {
        return View();
    }

    public IActionResult StartAssessment()
    {
        // Create a new assessment
        var assessment = new Assessment();
        _context.Assessments.Add(assessment);
        _context.SaveChanges();

        return RedirectToAction("Question", new { assessmentId = assessment.Id, questionIndex = 1 });
    }

    public async Task<IActionResult> Question(int assessmentId, int questionIndex)
    {
        var assessment = await _context.Assessments
            .Include(a => a.Responses)
            .FirstOrDefaultAsync(a => a.Id == assessmentId);

        if (assessment == null)
        {
            return NotFound();
        }

        var questions = await _context.Questions
            .Include(q => q.PossibleAnswers)
            .OrderBy(q => q.Order)
            .ToListAsync();

        if (questionIndex > questions.Count)
        {
            // All questions answered, calculate result
            return RedirectToAction("CalculateResult", new { assessmentId });
        }

        var currentQuestion = questions[questionIndex - 1];

        var viewModel = new QuestionViewModel
        {
            CurrentQuestion = currentQuestion,
            CurrentQuestionIndex = questionIndex,
            TotalQuestions = questions.Count,
            AssessmentId = assessmentId
        };

        return View(viewModel);
    }

    [HttpPost]
    public async Task<IActionResult> SubmitAnswer(int assessmentId, int questionId, int answerId, int questionIndex)
    {
        var assessment = await _context.Assessments.FindAsync(assessmentId);
        var answer = await _context.Answers.FindAsync(answerId);

        if (assessment == null || answer == null)
        {
            return NotFound();
        }

        // Record the response
        var response = new Response
        {
            QuestionId = questionId,
            AnswerId = answerId,
            AssessmentId = assessmentId
        };

        _context.Responses.Add(response);
        await _context.SaveChangesAsync();

        // Move to the next question
        return RedirectToAction("Question", new { assessmentId, questionIndex = questionIndex + 1 });
    }

    public async Task<IActionResult> CalculateResult(int assessmentId)
    {
        var assessment = await _context.Assessments
            .Include(a => a.Responses)
            .ThenInclude(r => r.Answer)
            .FirstOrDefaultAsync(a => a.Id == assessmentId);

        if (assessment == null)
        {
            return NotFound();
        }

        // Calculate the total score
        int totalScore = assessment.Responses.Sum(r => r.Answer?.Score ?? 0);
        assessment.TotalScore = totalScore;

        // Determine the result based on the score
        // This is a simplified scoring system - in a real application, you would use clinically validated thresholds
        if (totalScore >= 30)
        {
            assessment.Result = "High likelihood of ADHD. Consider consulting with a healthcare professional for a comprehensive evaluation.";
        }
        else if (totalScore >= 20)
        {
            assessment.Result = "Moderate likelihood of ADHD. Some symptoms are present that may warrant further investigation.";
        }
        else if (totalScore >= 10)
        {
            assessment.Result = "Low likelihood of ADHD. Some symptoms are present but they may not significantly impact daily functioning.";
        }
        else
        {
            assessment.Result = "Minimal likelihood of ADHD. Few symptoms are present.";
        }

        await _context.SaveChangesAsync();

        return RedirectToAction("Result", new { assessmentId });
    }

    public async Task<IActionResult> Result(int assessmentId)
    {
        var assessment = await _context.Assessments
            .Include(a => a.Responses)
            .ThenInclude(r => r.Question)
            .Include(a => a.Responses)
            .ThenInclude(r => r.Answer)
            .FirstOrDefaultAsync(a => a.Id == assessmentId);

        if (assessment == null)
        {
            return NotFound();
        }

        return View(assessment);
    }

    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    public IActionResult Error()
    {
        return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
    }
}
