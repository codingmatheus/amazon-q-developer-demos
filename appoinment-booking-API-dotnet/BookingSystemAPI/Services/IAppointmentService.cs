using BookingSystemAPI.Models;

namespace BookingSystemAPI.Services
{
    public interface IAppointmentService
    {
        Task<IEnumerable<Appointment>> GetAllAppointmentsAsync();
        Task<Appointment?> GetAppointmentByIdAsync(int id);
        Task<IEnumerable<Appointment>> GetAppointmentsByUserIdAsync(int userId);
        Task<IEnumerable<Appointment>> GetAppointmentsByDateRangeAsync(DateTime startDate, DateTime endDate);
        Task<Appointment> CreateAppointmentAsync(Appointment appointment);
        Task<Appointment?> UpdateAppointmentAsync(int id, Appointment appointment);
        Task<bool> DeleteAppointmentAsync(int id);
        Task<bool> IsTimeSlotAvailableAsync(DateTime startTime, DateTime endTime, int? excludeAppointmentId = null);
    }
}
