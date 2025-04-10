using BookingSystemAPI.Data;
using BookingSystemAPI.Models;
using Microsoft.EntityFrameworkCore;

namespace BookingSystemAPI.Services
{
    public class UserService : IUserService
    {
        private readonly BookingDbContext _context;

        public UserService(BookingDbContext context)
        {
            _context = context;
        }

        public async Task<IEnumerable<User>> GetAllUsersAsync()
        {
            return await _context.Users.ToListAsync();
        }

        public async Task<User?> GetUserByIdAsync(int id)
        {
            return await _context.Users.FindAsync(id);
        }

        public async Task<User?> GetUserByEmailAsync(string email)
        {
            return await _context.Users.FirstOrDefaultAsync(u => u.Email == email);
        }

        public async Task<User> CreateUserAsync(User user)
        {
            // Check if user with the same email already exists
            var existingUser = await GetUserByEmailAsync(user.Email);
            if (existingUser != null)
            {
                throw new InvalidOperationException("A user with this email already exists.");
            }

            _context.Users.Add(user);
            await _context.SaveChangesAsync();
            return user;
        }

        public async Task<User?> UpdateUserAsync(int id, User user)
        {
            var existingUser = await _context.Users.FindAsync(id);
            if (existingUser == null)
            {
                return null;
            }

            // Check if email is being changed and if it's already in use
            if (existingUser.Email != user.Email)
            {
                var userWithSameEmail = await GetUserByEmailAsync(user.Email);
                if (userWithSameEmail != null)
                {
                    throw new InvalidOperationException("A user with this email already exists.");
                }
            }

            existingUser.Name = user.Name;
            existingUser.Email = user.Email;
            existingUser.PhoneNumber = user.PhoneNumber;
            existingUser.UpdatedAt = DateTime.UtcNow;

            await _context.SaveChangesAsync();
            return existingUser;
        }

        public async Task<bool> DeleteUserAsync(int id)
        {
            var user = await _context.Users.FindAsync(id);
            if (user == null)
            {
                return false;
            }

            // Check if user has any appointments
            bool hasAppointments = await _context.Appointments
                .AnyAsync(a => a.UserId == id && a.Status != AppointmentStatus.Cancelled);

            if (hasAppointments)
            {
                throw new InvalidOperationException("Cannot delete user with active appointments.");
            }

            _context.Users.Remove(user);
            await _context.SaveChangesAsync();
            return true;
        }
    }
}
