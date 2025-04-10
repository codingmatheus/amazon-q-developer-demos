# ADHD Diagnostic Web Application

This is a web-based application built with ASP.NET Core (.NET 9) that provides a preliminary ADHD diagnostic assessment. The application presents users with a series of questions related to ADHD symptoms and provides a score-based assessment of the likelihood of ADHD.

## Features

- User-friendly interface with a yellow theme for branding
- Sequential question screens with progress tracking
- Score calculation based on user responses
- Detailed results page with score interpretation
- Responsive design for mobile and desktop use

## Technical Details

- Built with ASP.NET Core (.NET 9)
- Uses Entity Framework Core with SQLite database
- MVC architecture
- Custom CSS styling with yellow theme

## Getting Started

### Prerequisites

- .NET 9 SDK
- Visual Studio 2022 or Visual Studio Code

### Running the Application

1. Clone the repository
2. Navigate to the project directory
3. Run the following commands:

```bash
dotnet restore
dotnet run
```

4. Open your browser and navigate to `https://localhost:5001` or `http://localhost:5000`

## Database

The application uses SQLite with Entity Framework Core. The database is automatically created and seeded with ADHD diagnostic questions when the application starts.

## Disclaimer

This application is for educational purposes only and is not intended to provide medical advice or diagnosis. The assessment provided by this application is not a substitute for professional medical evaluation. If you have concerns about ADHD, please consult with a qualified healthcare provider.
