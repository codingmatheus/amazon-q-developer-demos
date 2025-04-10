// This is a simple model example
class User {
  constructor(name, email, message) {
    this.name = name;
    this.email = email;
    this.message = message;
    this.date = new Date();
  }

  // Example method
  getFormattedDate() {
    return this.date.toLocaleDateString();
  }
}

module.exports = User;
