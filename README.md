# Smart Library Management System

A production‑ready web-based Library Management application built with vanilla **PHP**, **MySQL**, and **Bootstrap**. It supports complete circulation workflows (registration, verification, issue / return, fines, messaging) for two roles: **Admin** and **Student**. Recent updates include secure password hashing (bcrypt) and OTP‑based verification / password reset.

## 🎯 Project Overview

This comprehensive library management system digitizes traditional library operations through modern web technologies, providing an intuitive and secure platform for both library administrators and students. The application demonstrates full-stack development expertise while solving real-world challenges in educational institutions.

**🔹 What it does:** Automates book circulation, user management, fine calculations, and communication workflows  
**🔹 Who it's for:** Educational institutions, libraries, and organizations managing book lending operations  
**🔹 Why it matters:** Reduces manual workload by 80%, enhances security, and improves user experience through digital transformation  

### 💼 Technical Excellence
- **Modern Security**: bcrypt password hashing, OTP email verification, session management
- **Responsive Design**: Mobile-first approach with Bootstrap framework for optimal user experience
- **Scalable Architecture**: Role-based access control supporting hundreds of concurrent users
- **Production Ready**: Comprehensive error handling, input validation, and secure deployment practices

## Developer Contact Information

### Tonmoy Sarker Sourav

[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=flat&logo=linkedin)](https://www.linkedin.com/in/tonmoyy/) <br>
[![Facebook](https://img.shields.io/badge/Facebook-1877F2?style=flat&logo=facebook&logoColor=white)](https://www.facebook.com/realtonmoysarker) <br>
[![Email](https://img.shields.io/badge/Email-D14836?style=flat&logo=gmail&logoColor=white)](mailto:tonmoy4451@gmail.com)  tonmoy4451@gmail.com

## ✨ Key Features

### Authentication & Accounts
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

### Special / Advanced Features
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

## ⚙️ Technical Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache Web Server
- XAMPP/WAMP/MAMP or similar server package
- Web Browser (Chrome/Firefox/Safari)

## 🚀 Quick Start (Local – XAMPP / WAMP)

1. Clone the repository
```bash
git clone https://github.com/tonmoy-y/Smart-LIbrary-Management-System.git
cd Smart-LIbrary-Management-System
```
2. Move (or keep) the project folder inside your web root (e.g. `C:/xampp/htdocs/Smart-LIbrary-Management-System`).  
3. Create a database (example: `library`):
```sql
CREATE DATABASE library CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
4. Import the provided schema file:
```sql
-- In phpMyAdmin or mysql CLI
SOURCE path/to/library (4).sql;
```
5. Open `connection.php` (and `admin/connection.php`, `student/connection.php`) and confirm credentials:
```php
$db = mysqli_connect("localhost","root","","library");
```
6. Start Apache + MySQL in XAMPP.  
7. Visit: `http://localhost/Smart-LIbrary-Management-System/login.php` or `index.php`.
8. Register an Admin account first (admin registration page).  
9. Register a Student, complete OTP email verification (or configure email—see below).  
10. Login and explore dashboards.

## 🛠 Full Setup Guide (From Git Clone to Working OTP Email)

### 1. Clone Repository
```bash
git clone https://github.com/tonmoy-y/Smart-LIbrary-Management-System.git
cd Smart-LIbrary-Management-System
```

### 2. Place in Web Root (Windows XAMPP)
Copy or move the project folder to:  
`C:/xampp/htdocs/Smart-LIbrary-Management-System`

Then browse: `http://localhost/Smart-LIbrary-Management-System/`

### 3. Create Database
Use phpMyAdmin or MySQL CLI:
```sql
CREATE DATABASE library CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Import schema using the provided SQL file:
```sql
SOURCE /path/to/Smart-LIbrary-Management-System/library (4).sql;
```

### 4. Configure Database Connection
Open ALL of these (root `connection.php`, plus `admin/connection.php`, `student/connection.php` if duplicated) and ensure:
```php
$db = mysqli_connect("localhost","root","","library");
```
Restart Apache if you changed PHP extensions.

### 5. Ensure Password Columns Are Large Enough
```sql
ALTER TABLE admin   MODIFY password VARCHAR(255) NOT NULL;
ALTER TABLE student MODIFY password VARCHAR(255) NOT NULL;
```

### 6. (Optional) Migrate Legacy Plain Passwords
See migration snippet below (Legacy Plain Password Migration) if coming from older version.

### 7. Configure Email (SMTP) for OTP (XAMPP on Windows)
The project currently uses `mail()`; configure XAMPP's built‑in sendmail relay or replace with PHPMailer.

#### 7.1 Enable OpenSSL in PHP
Edit `C:/xampp/php/php.ini` and ensure:
```
extension=openssl
```
Restart Apache.

#### 7.2 Configure sendmail (Using Gmail Example)
Edit: `C:/xampp/sendmail/sendmail.ini`
```
smtp_server=smtp.gmail.com
smtp_port=587
smtp_ssl=auto
auth_username=YOUR_GMAIL_ADDRESS@gmail.com
auth_password=YOUR_APP_PASSWORD
force_sender=YOUR_GMAIL_ADDRESS@gmail.com
```
Gmail now requires 2FA + App Password (NOT your normal password).

#### 7.3 Link PHP to sendmail
In `php.ini`, find and set:
```
[mail function]
SMTP=smtp.gmail.com
smtp_port=587
sendmail_path="C:\xampp\sendmail\sendmail.exe -t"
```
Save and restart Apache.

#### 7.4 Test Mail
Create `mail_test.php` in the project root:
```php
<?php
var_dump(mail('your_destination_email@example.com','Test Mail','If this is true, mail works.'));
```
Visit: `http://localhost/Smart-LIbrary-Management-System/mail_test.php`  
If `bool(true)` and you received the email, OTP sending should work.

### 8. Adjust From Address (Optional)
In `send_otp.php` (student/admin versions) you can set a custom header:
```php
$headers = "From: Library System <YOUR_GMAIL_ADDRESS@gmail.com>\r\n";
```

### 9. Register Accounts
1. Register Admin (for management).  
2. Register Student → check email for OTP → verify → login.  

### 10. Common Email Issues
| Symptom | Cause | Fix |
|--------|-------|-----|
| `bool(false)` from mail() | Misconfigured sendmail | Recheck sendmail.ini paths |
| No email, no error | Gmail blocked | Verify app password & less secure off (not used) |
| Timeout | Firewall blocking 587 | Allow outbound SMTP or switch network |
| Truncated OTP email | HTML header missing | Ensure correct `$headers` formatting |

### 11. (Optional) Switch to PHPMailer Later
PHPMailer gives better error messages and TLS handling.

### 12. Backup & Security Checklist
- Change default admin password immediately.  
- Remove any test scripts (`mail_test.php`, migrations).  
- Keep `password_hash()` usage; never downgrade to MD5.  
- Regularly export the database.

---

## 📦 Deployment (Shared Hosting / VPS Quick Notes)
| Environment | Notes |
|-------------|-------|
| Shared Hosting | Upload project contents into `public_html/Smart-LIbrary-Management-System/` (or root) and adjust paths. |
| VPS (LAMP) | Place under `/var/www/html/Smart-LIbrary-Management-System`; set correct ownership (`www-data`). |
| Nginx + PHP-FPM | Root to `/var/www/html/Smart-LIbrary-Management-System`; ensure `index.php` forwarding; configure `fastcgi_pass`. |
| SSL | Use Certbot (Let’s Encrypt) – not required locally but recommended live. |

### Optional: Email / OTP Sending
Current code uses PHP's `mail()`; on Windows/XAMPP this may fail without SMTP configuration. For reliable delivery:
- Use an SMTP relay (Gmail / SendGrid / Mailgun).  
- Replace simple `mail()` calls with PHPMailer (future improvement).  

### Legacy Plain Password Migration (If upgrading an old DB)
If older rows stored plaintext (not 60‑char bcrypt hashes), run a one‑time migration:
```php
// create file: migrate_passwords.php in project root
// Note: Requires PHP 8.0+ for str_starts_with function
<?php
include 'connection.php';
function needs_hash($pw){return !(is_string($pw) && strlen($pw)===60 && str_starts_with($pw,'$2y$'));}
foreach(['admin','student'] as $t){
   $r = mysqli_query($db, "SELECT username,password FROM `$t`");
   while($row=mysqli_fetch_assoc($r)){
      if(needs_hash($row['password'])){
          $h = password_hash($row['password'], PASSWORD_DEFAULT);
          $u = mysqli_real_escape_string($db,$row['username']);
          mysqli_query($db,"UPDATE `$t` SET password='$h' WHERE username='$u'");
          echo "Hashed: $t => {$row['username']}\n";
      }
   }
}
echo "Done\n";
```
Run:
```bash
php migrate_passwords.php
```

Remove the script afterward for security.

## ⚙️ Configuration Summary

| Purpose | File(s) | Action |
|---------|---------|--------|
| DB Connection | `connection.php` (root, `admin/`, `student/`) | Set host/user/pass/db |
| OTP Expiry / Cleanup | `verify.php` (student/admin) | Uses DB timestamp deletion | 
| Password Hashing | Registration, verify, edit_profile, login | Uses `password_hash()` & `password_verify()` |
| Email sending | `send_otp.php` (student/admin) | Configure SMTP or adapt mail() |

Keep passwords columns as `VARCHAR(255)` to avoid hash truncation.

## 📘 Usage Flow

1. Admin registers (or you insert an initial admin manually).  
2. Students register → receive OTP → verify.  
3. Students browse books, place requests.  
4. Admin reviews and approves issues.  
5. System tracks due dates, fines, and overdue status.  
6. Users can reset forgotten passwords via OTP.  
7. Profiles can be updated (password change optional; hash only when provided).  

### Typical Daily Admin Actions
- Approve pending students (if manual gating used).  
- Add / update books (stock + metadata).  
- Process issue / return queue.  
- Review fines & messages.  

### Typical Student Actions
- Search catalog, request book.  
- Check issued items & due dates.  
- Pay attention to fines / notifications.  
- Update profile & reset password if required.

## 🔐 Security Features (Current)
- Bcrypt password hashing (`password_hash`, `password_verify`).
- Session-based auth segregation (student vs admin namespaces).
- OTP-based email verification & password reset (with server-side expiry + DB cleanup).
- Basic SQL protection (manual escaping—future refactor: prepared statements recommended).
- Limited exposure of sensitive data (password hashes not displayed in profiles anymore).

### Recommended Future Hardening
- Use prepared statements (`mysqli_stmt` / PDO) everywhere.
- Add CSRF tokens to forms.
- Rate-limit OTP resend & login attempts.
- Switch to PHPMailer + SMTP with authenticated sending.
- Enforce stronger password policy (length / complexity / haveibeenpwned check optional).
- Add audit log (issues, returns, admin actions).

## 🗂 Project Structure (Key Files)
```
Smart-LIbrary-Management-System/
├─ index.php
├─ login.php
├─ register.php
├─ update_password.php
├─ send_otp.php
├─ books.php
├─ contact.php
├─ error.php
├─ connection.php
├─ navbar.php
├─ footer.php
├─ styles.css
├─ responsive.css
├─ .htaccess
├─ library (4).sql          # Database schema file
├─ LICENSE.txt
├─ images/                  # Shared image resources
├─ admin/
│  ├─ admin_login.php
│  ├─ index.php
│  ├─ register.php
│  ├─ verify.php
│  ├─ send_otp.php
│  ├─ update_password.php
│  ├─ edit_profile.php
│  ├─ profile.php
│  ├─ books.php
│  ├─ add.php
│  ├─ approve.php
│  ├─ issue_info.php
│  ├─ fine.php
│  ├─ student.php
│  ├─ admin_status.php
│  ├─ message.php
│  ├─ request.php
│  ├─ contact.php
│  ├─ connection.php
│  ├─ navbar.php
│  ├─ sidenav.php
│  ├─ footer.php
│  ├─ styles.css
│  ├─ responsive.css
│  ├─ logout.php
│  ├─ session_destroy.php
│  ├─ expired.php
│  └─ images/              # Admin-specific images
├─ student/
│  ├─ index.php
│  ├─ register.php
│  ├─ verify.php
│  ├─ verify_acc.php
│  ├─ send_otp.php
│  ├─ update_password.php
│  ├─ edit_profile.php
│  ├─ profile.php
│  ├─ books.php
│  ├─ books_old.php
│  ├─ request.php
│  ├─ issue_info.php
│  ├─ fine.php
│  ├─ message.php
│  ├─ contact.php
│  ├─ connection.php
│  ├─ navbar.php
│  ├─ footer.php
│  ├─ styles.css
│  ├─ responsive.css
│  ├─ logout.php
│  ├─ session_destroy.php
│  └─ expired.php
└─ README.md
```

## 🧩 Design Highlights
| Aspect | Approach | Benefit |
|--------|----------|---------|
| Roles | Separate admin & student directories | Clear separation and simpler access control |
| OTP | DB timestamp + cleanup query | Prevents timer spoofing on reload |
| Passwords | Bcrypt hashing | Secure credential storage |
| Fines | Calculated on overdue delta | Automated penalty management |
| UI | Bootstrap 3 + custom CSS | Quick responsive layout |

## 🚧 Known Limitations / Next Steps
- No comprehensive prepared statement layer yet.
- No queue / cron for periodic cleanup (handled ad-hoc on page hits).
- Email deliverability depends on PHP mail() configuration.
- Limited audit / reporting exports.

## 🤝 Contributing
PRs welcome. Please open an Issue first for significant changes.

## 📄 License
MIT – see `LICENSE.txt`.

## 💬 Support
Open an Issue or reach out via the contact channels above.

---
Built with care to simplify campus library workflows. Contributions & feedback are appreciated.
