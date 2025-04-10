using BookingSystemAPI.Data;
using BookingSystemAPI.Models;
using Microsoft.EntityFrameworkCore;

namespace BookingSystemAPI.Services
{
    public class AppointmentService : IAppointmentService
    {
        private readonly BookingDbContext _context;

        public AppointmentService(BookingDbContext context)
        {
            _context = context;
        }

        public async Task<IEnumerable<Appointment>> GetAllAppointmentsAsync()
        {
            return await _context.Appointments
                .Include(a => a.User)
                .Include(a => a.Service)
                .ToListAsync();
        }

        public async Task<Appointment?> GetAppointmentByIdAsync(int id)
        {
            return await _context.Appointments
                .Include(a => a.User)
                .Include(a => a.Service)
                .FirstOrDefaultAsync(a => a.Id == id);
        }

        public async Task<IEnumerable<Appointment>> GetAppointmentsByUserIdAsync(int userId)
        {
            return await _context.Appointments
                .Include(a => a.Service)
                .Where(a => a.UserId == userId)
                .ToListAsync();
        }

        public async Task<IEnumerable<Appointment>> GetAppointmentsByDateRangeAsync(DateTime startDate, DateTime endDate)
        {
            return await _context.Appointments
                .Include(a => a.User)
                .Include(a => a.Service)
                .Where(a => a.StartTime >= startDate && a.EndTime <= endDate)
                .ToListAsync();
        }

        public async Task<Appointment> CreateAppointmentAsync(Appointment appointment)
        {
            // Check if the time slot is available
            bool isAvailable = await IsTimeSlotAvailableAsync(appointment.StartTime, appointment.EndTime);
            if (!isAvailable)
            {
                throw new InvalidOperationException("The requested time slot is not available.");
            }

            _context.Appointments.Add(appointment);
            await _context.SaveChangesAsync();
            return appointment;
        }

        public async Task<Appointment?> UpdateAppointmentAsync(int id, Appointment appointment)
        {
            var existingAppointment = await _context.Appointments.FindAsync(id);
            if (existingAppointment == null)
            {
                return null;
            }

            // Check if the new time slot is available (excluding the current appointment)
            bool isAvailable = await IsTimeSlotAvailableAsync(
                appointment.StartTime, 
                appointment.EndTime, 
                excludeAppointmentId: id);

            if (!isAvailable)
            {
                throw new InvalidOperationException("The requested time slot is not available.");
            }

            existingAppointment.UserId = appointment.UserId;
            existingAppointment.ServiceId = appointment.ServiceId;
            existingAppointment.StartTime = appointment.StartTime;
            existingAppointment.EndTime = appointment.EndTime;
            existingAppointment.Status = appointment.Status;
            existingAppointment.Notes = appointment.Notes;
            existingAppointment.UpdatedAt = DateTime.UtcNow;

            await _context.SaveChangesAsync();
            return existingAppointment;
        }

        public async Task<bool> DeleteAppointmentAsync(int id)
        {
            var appointment = await _context.Appointments.FindAsync(id);
            if (appointment == null)
            {
                return false;
            }

            _context.Appointments.Remove(appointment);
            await _context.SaveChangesAsync();
            return true;
        }

        public async Task<bool> IsTimeSlotAvailableAsync(DateTime startTime, DateTime endTime, int? excludeAppointmentId = null)
        {
            // Check if there are any overlapping appointments
            var query = _context.Appointments.AsQueryable();
            
            if (excludeAppointmentId.HasValue)
            {
                query = query.Where(a => a.Id != excludeAppointmentId.Value);
            }

            bool hasOverlap = await query.AnyAsync(a =>
                (startTime < a.EndTime && endTime > a.StartTime) &&
                a.Status != AppointmentStatus.Cancelled);

            return !hasOverlap;
        }
    }
}
