# Smart Library Management System

A comprehensive web-based library management system built with PHP and MySQL that helps efficiently manage library resources, users, and operations. This system is designed to streamline library operations, enhance user experience, and provide efficient management of library resources in educational institutions.

## Developer Contact Information

- **LinkedIn**: [Tonmoy Sarker](https://www.linkedin.com/in/tonmoyy/)
- **Facebook**: [Tonmoy Sarker](https://www.facebook.com/realtonmoysarker)
- **Email**: tonmoy4451@gmail.com

## Features

### User Authentication and Management
- **Dual User System**: 
  - Separate interfaces for administrators and students
  - Role-based access control
  - Customized dashboards for different user types
  - Session management and security

- **Secure Registration**: 
  - Email verification system for students with OTP (One-Time Password)
  - Username validation to prevent conflicts and admin impersonation
  - Secure password management with encryption
  - Duplicate email and roll number prevention
  - Profile picture upload capability

- **Profile Management**: 
  - Users can edit their personal information
  - Update profile pictures
  - Modify contact details
  - Change account credentials
  - View account activity history

- **Password Recovery**: 
  - Built-in password recovery system
  - Secure password reset mechanism
  - Email-based recovery process
  - User verification before password reset

### Admin Features
1. **User Management**
   - Comprehensive student account management
   - Approve/reject student registrations with email notifications
   - Monitor student activities and borrowing history
   - View and manage user profiles
   - Block/unblock user accounts
   - Reset user passwords
   - Track user login activities

2. **Book Management**
   - Add new books with detailed information
     - Title, Author, Edition
     - ISBN number
     - Category/Genre
     - Publication details
     - Number of copies
   - Update book information and status in real-time
   - Track book inventory and availability
   - Manage book categories
   - Upload book cover images
   - Generate book QR codes/barcodes
   - Book status tracking (Available, Issued, Reserved, Under Maintenance)

3. **Issue Management**
   - Process book issue requests with automated workflows
   - Track issued books with due dates
   - Manage return dates and extensions
   - Calculate and handle fines for late returns
   - Generate issue receipts
   - Automated overdue notifications
   - Reserve books for students
   - Track book return history
   - Generate reports of issued books

4. **Communication and Notifications**
   - Receive and respond to student messages
   - Send individual and bulk notifications to students
   - View and manage feedback submissions
   - Send automated reminders for:
     - Due dates
     - Overdue books
     - Fine payments
     - Account status updates
   - Announcement system for library updates

### Student Features
1. **Book Access and Search**
   - Browse complete book catalog
   - Advanced search functionality with multiple parameters:
     - Title
     - Author
     - Category
     - ISBN
     - Publication year
   - Real-time book availability status
   - Book recommendations based on interests
   - View book details and cover images
   - Check number of available copies

2. **Book Operations and Management**
   - Request books with preferred pickup dates
   - Track current borrowed books status
   - View upcoming return dates with countdown
   - Request book renewal/extension
   - Check and pay fine status
   - Reserve books for future borrowing
   - Get notifications for book availability
   - Download borrowing history

3. **Account Features and Dashboard**
   - Personalized user dashboard showing:
     - Currently borrowed books
     - Due dates
     - Fine details
     - Recent activities
   - Complete profile customization
     - Update personal information
     - Change profile picture
     - Manage contact details
   - Interactive message system to communicate with administrators
   - Detailed borrowing history with filters
   - Email notifications for account activities
   - Reading progress tracking
   - Save favorite books and authors

### Special Features
1. **Advanced Fine Management System**
   - Automatic calculation of overdue fines based on:
     - Number of overdue days
     - Book category
     - Student category
   - Progressive fine calculation
   - Fine payment tracking
   - Payment history
   - Automatic fine notifications
   - Fine waiver management
   - Generate fine reports

2. **Comprehensive Analytics Dashboard**
   - Real-time statistics and reports
   - Most popular books
   - Active borrowers
   - Overdue analysis
   - Fine collection reports
   - User activity tracking
   - Book utilization reports
   - Category-wise book distribution

3. **Modern Responsive Design**
   - Mobile-first approach
   - Clean and intuitive user interface
   - Bootstrap 3.4.1 based responsive layout
   - Cross-browser compatibility
   - Touch-friendly interface
   - Accessible design features
   - Custom CSS styling
   - Interactive UI elements

4. **Security Features**
   - Protection against SQL injection
   - XSS prevention
   - CSRF protection
   - Secure session management
   - Password encryption
   - Input validation and sanitization
   - Role-based access control
   - Activity logging

5. **Notification System**
   - Email notifications
   - Browser notifications
   - Due date reminders
   - Fine alerts
   - Book availability notifications
   - Account status updates
   - System announcements

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
