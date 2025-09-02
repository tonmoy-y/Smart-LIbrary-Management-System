# Smart Library Management System

A comprehensive web-based library management system built with PHP and MySQL that helps efficiently manage library resources, users, and operations. This system streamlines library operations and enhances user experience in educational institutions.

## Developer Contact Information

### Tonmoy Sarker Sourav

[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=flat&logo=linkedin)](https://www.linkedin.com/in/tonmoyy/)  <br>
[![Facebook](https://img.shields.io/badge/Facebook-1877F2?style=flat&logo=facebook&logoColor=white)](https://www.facebook.com/realtonmoysarker) <br>
<<<<<<< HEAD
[![Email](https://img.shields.io/badge/Email-D14836?style=flat&logo=gmail&logoColor=white)](mailto:tonmoy4451@gmail.com)  tonmoy4451@gmail.com
=======
[![Email](https://img.shields.io/badge/Email-D14836?style=flat&logo=gmail&logoColor=white)](mailto:tonmoy4451@gmail.com)  

## Features

### User Authentication and Management
- **Dual User System**: 
  - Separate interfaces for administrators and students
  - Role-based access control
  - Basic session management

- **Registration System**: 
  - Email verification with OTP
  - Username validation
  - Basic profile setup
  - Student roll number verification

- **Profile Management**: 
  - Edit personal information
  - Update profile picture
  - Modify contact details

- **Password Recovery**: 
  - Basic password reset system
  - Email-based recovery process

### Admin Features
1. **User Management**
   - View and manage student accounts
   - Approve/reject student registrations
   - Monitor borrowing history
   - Reset user passwords

2. **Book Management**
   - Add new books with details:
     - Title, Author, Edition
     - ISBN number
     - Category
     - Number of copies
   - Update book information
   - Track book inventory
   - Upload book cover images
   - Book status tracking

3. **Issue Management**
   - Process book issue requests
   - Track issued books
   - Manage return dates
   - Calculate fines for late returns
   - Track return history

4. **Communication**
   - Message system with students
   - View feedback submissions
   - Basic notifications for:
     - Due dates
     - Overdue books
     - Fine payments

### Student Features
1. **Book Access**
   - Browse book catalog
   - Search books by:
     - Title
     - Author
     - Category
   - View book availability
   - View book details and covers

2. **Book Operations**
   - Request books
   - Track borrowed books
   - View return dates
   - Check fine status
   - View borrowing history

3. **Account Features**
   - Dashboard showing:
     - Current loans
     - Due dates
     - Fines
   - Profile management
   - Message system with administrators
   - Email notifications

### Special Features
1. **Fine Management**
   - Automatic calculation of overdue fines
   - Fine payment tracking
   - Basic fine notifications

2. **Basic Analytics**
   - Book borrowing statistics
   - User activity tracking
   - Basic reports generation

3. **Responsive Design**
   - Mobile-friendly interface
   - Bootstrap 3.4.1 framework
   - Clean and intuitive UI

4. **Security**
   - Basic SQL injection protection
   - Input validation
   - Session management
   - Password protection

5. **Notifications**
   - Email notifications for:
     - Due dates
     - Registration
     - Password reset

## Technical Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache Web Server
- XAMPP/WAMP/MAMP or similar server package
- Web Browser (Chrome/Firefox/Safari)

## Installation

1. Clone the repository to your local machine
2. Place the files in your web server directory (e.g., htdocs for XAMPP)
3. Create a MySQL database and import the provided SQL file
4. Configure the database connection in `connection.php`
5. Start your web server and MySQL service
6. Access the system through your web browser

## Configuration

Update the database connection details in `connection.php`:
```php
$db = mysqli_connect("localhost","root","","library");
```

## Usage

1. **Admin Access**
   - Register as an admin through the registration page
   - Log in using admin credentials
   - Access the admin dashboard to manage library operations

2. **Student Access**
   - Register as a student
   - Verify email address
   - Log in to access student features
   - Browse and request books
   - Track borrowed items

## Security Features

- Password hashing
- Session management
- Input validation
- XSS prevention
- Email verification for student accounts
- Secure password recovery system

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the repository or contact the system administrator.
