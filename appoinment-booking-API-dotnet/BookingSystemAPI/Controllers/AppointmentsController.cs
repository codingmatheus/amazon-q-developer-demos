using BookingSystemAPI.Models;
using BookingSystemAPI.Services;
using Microsoft.AspNetCore.Mvc;

namespace BookingSystemAPI.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class AppointmentsController : ControllerBase
    {
        private readonly IAppointmentService _appointmentService;

        public AppointmentsController(IAppointmentService appointmentService)
        {
            _appointmentService = appointmentService;
        }

        // GET: api/appointments
        [HttpGet]
        public async Task<ActionResult<IEnumerable<Appointment>>> GetAppointments()
        {
            var appointments = await _appointmentService.GetAllAppointmentsAsync();
            return Ok(appointments);
        }

        // GET: api/appointments/5
        [HttpGet("{id}")]
        public async Task<ActionResult<Appointment>> GetAppointment(int id)
        {
            var appointment = await _appointmentService.GetAppointmentByIdAsync(id);

            if (appointment == null)
            {
                return NotFound();
            }

            return Ok(appointment);
        }

        // GET: api/appointments/user/5
        [HttpGet("user/{userId}")]
        public async Task<ActionResult<IEnumerable<Appointment>>> GetAppointmentsByUser(int userId)
        {
            var appointments = await _appointmentService.GetAppointmentsByUserIdAsync(userId);
            return Ok(appointments);
        }

        // GET: api/appointments/range?startDate=2023-01-01&endDate=2023-01-31
        [HttpGet("range")]
        public async Task<ActionResult<IEnumerable<Appointment>>> GetAppointmentsByDateRange(
            [FromQuery] DateTime startDate, [FromQuery] DateTime endDate)
        {
            var appointments = await _appointmentService.GetAppointmentsByDateRangeAsync(startDate, endDate);
            return Ok(appointments);
        }

        // POST: api/appointments
        [HttpPost]
        public async Task<ActionResult<Appointment>> CreateAppointment(Appointment appointment)
        {
            try
            {
                var createdAppointment = await _appointmentService.CreateAppointmentAsync(appointment);
                return CreatedAtAction(nameof(GetAppointment), new { id = createdAppointment.Id }, createdAppointment);
            }
            catch (InvalidOperationException ex)
            {
                return BadRequest(ex.Message);
            }
        }

        // PUT: api/appointments/5
        [HttpPut("{id}")]
        public async Task<IActionResult> UpdateAppointment(int id, Appointment appointment)
        {
            if (id != appointment.Id)
            {
                return BadRequest("ID mismatch");
            }

            try
            {
                var updatedAppointment = await _appointmentService.UpdateAppointmentAsync(id, appointment);
                if (updatedAppointment == null)
                {
                    return NotFound();
                }

                return NoContent();
            }
            catch (InvalidOperationException ex)
            {
                return BadRequest(ex.Message);
            }
        }

        // DELETE: api/appointments/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteAppointment(int id)
        {
            var result = await _appointmentService.DeleteAppointmentAsync(id);
            if (!result)
            {
                return NotFound();
            }

            return NoContent();
        }

        // GET: api/appointments/available?startTime=2023-01-01T09:00:00&endTime=2023-01-01T10:00:00
        [HttpGet("available")]
        public async Task<ActionResult<bool>> CheckAvailability(
            [FromQuery] DateTime startTime, [FromQuery] DateTime endTime)
        {
            var isAvailable = await _appointmentService.IsTimeSlotAvailableAsync(startTime, endTime);
            return Ok(isAvailable);
        }
    }
}
