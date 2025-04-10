# Booking System API

A RESTful API for managing appointment bookings built with ASP.NET Core and .NET 9.

## Features

- Appointment scheduling and management
- User management
- Service catalog
- Time slot availability checking
- Blue-themed Swagger UI

## Tech Stack

- ASP.NET Core (.NET 9)
- Entity Framework Core with In-Memory Database
- Swagger/OpenAPI for API documentation

## Getting Started

### Prerequisites

- .NET 9 SDK

### Running the Application

1. Clone the repository
2. Navigate to the project directory
```bash
cd BookingSystemAPI
```
3. Run the application
```bash
dotnet run
```
4. Open your browser and navigate to `https://localhost:5001/swagger` to access the Swagger UI

## API Endpoints

### Appointments

- `GET /api/appointments` - Get all appointments
- `GET /api/appointments/{id}` - Get appointment by ID
- `GET /api/appointments/user/{userId}` - Get appointments by user ID
- `GET /api/appointments/range?startDate={date}&endDate={date}` - Get appointments within a date range
- `GET /api/appointments/available?startTime={datetime}&endTime={datetime}` - Check if a time slot is available
- `POST /api/appointments` - Create a new appointment
- `PUT /api/appointments/{id}` - Update an existing appointment
- `DELETE /api/appointments/{id}` - Delete an appointment

### Users

- `GET /api/users` - Get all users
- `GET /api/users/{id}` - Get user by ID
- `GET /api/users/email/{email}` - Get user by email
- `POST /api/users` - Create a new user
- `PUT /api/users/{id}` - Update an existing user
- `DELETE /api/users/{id}` - Delete a user

### Services

- `GET /api/services` - Get all services
- `GET /api/services/{id}` - Get service by ID
- `POST /api/services` - Create a new service
- `PUT /api/services/{id}` - Update an existing service
- `DELETE /api/services/{id}` - Delete a service

## Data Models

### Appointment

```csharp
public class Appointment
{
    public int Id { get; set; }
    public int UserId { get; set; }
    public User? User { get; set; }
    public int ServiceId { get; set; }
    public Service? Service { get; set; }
    public DateTime StartTime { get; set; }
    public DateTime EndTime { get; set; }
    public AppointmentStatus Status { get; set; }
    public string? Notes { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime? UpdatedAt { get; set; }
}
```

### User

```csharp
public class User
{
    public int Id { get; set; }
    public string Name { get; set; }
    public string Email { get; set; }
    public string PhoneNumber { get; set; }
    public List<Appointment> Appointments { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime? UpdatedAt { get; set; }
}
```

### Service

```csharp
public class Service
{
    public int Id { get; set; }
    public string Name { get; set; }
    public string Description { get; set; }
    public int DurationMinutes { get; set; }
    public decimal Price { get; set; }
    public List<Appointment> Appointments { get; set; }
    public DateTime CreatedAt { get; set; }
    public DateTime? UpdatedAt { get; set; }
}
```
