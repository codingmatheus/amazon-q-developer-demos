# Pool League Tracker

A web application for tracking pool leagues, teams, players, and matches built with ASP.NET Core (.NET 9) and a green theme.

## Features

- Track multiple pool leagues
- Manage teams and players
- Record match results
- View league standings and statistics
- Player performance tracking
- Responsive design with green theme

## Technologies Used

- ASP.NET Core 9.0
- Entity Framework Core
- SQLite Database
- Bootstrap 5
- Razor Pages

## Getting Started

### Prerequisites

- .NET 9 SDK
- Visual Studio 2022, Visual Studio Code, or any preferred IDE

### Installation

1. Clone the repository
2. Navigate to the project directory
3. Run the application:

```bash
dotnet run
```

The application will be available at `https://localhost:5001` or `http://localhost:5000`.

## Database

The application uses SQLite for data storage. The database will be automatically created on first run with seed data.

## Project Structure

- **Models**: Contains the data models for League, Team, Player, and Match
- **Pages**: Razor Pages for the UI
- **Data**: Contains the database context and configuration
- **wwwroot**: Static files (CSS, JavaScript, images)

## License

This project is licensed under the MIT License.

## Acknowledgments

- Bootstrap for the responsive design
- Entity Framework Core for data access
- ASP.NET Core team for the framework
