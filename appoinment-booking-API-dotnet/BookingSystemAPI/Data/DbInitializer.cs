using BookingSystemAPI.Models;

namespace BookingSystemAPI.Data
{
    public static class DbInitializer
    {
        public static void Initialize(BookingDbContext context)
        {
            // Ensure database is created
            context.Database.EnsureCreated();

            // Check if there are any services
            if (context.Services.Any())
            {
                return; // DB has been seeded
            }

            // Add sample services
            var services = new Service[]
            {
                new Service
                {
                    Name = "Standard Consultation",
                    Description = "A 30-minute consultation with our specialist",
                    DurationMinutes = 30,
                    Price = 50.00m
                },
                new Service
                {
                    Name = "Extended Consultation",
                    Description = "A 60-minute in-depth consultation",
                    DurationMinutes = 60,
                    Price = 90.00m
                },
                new Service
                {
                    Name = "Quick Check-up",
                    Description = "A 15-minute quick check-up",
                    DurationMinutes = 15,
                    Price = 25.00m
                }
            };

            context.Services.AddRange(services);
            context.SaveChanges();

            // Add sample users
            var users = new User[]
            {
                new User
                {
                    Name = "John Doe",
                    Email = "john.doe@example.com",
                    PhoneNumber = "555-123-4567"
                },
                new User
                {
                    Name = "Jane Smith",
                    Email = "jane.smith@example.com",
                    PhoneNumber = "555-987-6543"
                }
            };

            context.Users.AddRange(users);
            context.SaveChanges();

            // Add sample appointments
            var appointments = new Appointment[]
            {
                new Appointment
                {
                    UserId = users[0].Id,
                    ServiceId = services[0].Id,
                    StartTime = DateTime.UtcNow.AddDays(1).Date.AddHours(9),
                    EndTime = DateTime.UtcNow.AddDays(1).Date.AddHours(9).AddMinutes(services[0].DurationMinutes),
                    Status = AppointmentStatus.Confirmed,
                    Notes = "First appointment"
                },
                new Appointment
                {
                    UserId = users[1].Id,
                    ServiceId = services[1].Id,
                    StartTime = DateTime.UtcNow.AddDays(2).Date.AddHours(14),
                    EndTime = DateTime.UtcNow.AddDays(2).Date.AddHours(14).AddMinutes(services[1].DurationMinutes),
                    Status = AppointmentStatus.Scheduled,
                    Notes = "Follow-up appointment"
                }
            };

            context.Appointments.AddRange(appointments);
            context.SaveChanges();
        }
    }
}
