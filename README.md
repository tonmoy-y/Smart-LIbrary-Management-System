# Smart Library Management System

A production‑ready web-based Library Management application built with vanilla **PHP**, **MySQL**, and **Bootstrap**. It supports complete circulation workflows (registration, verification, issue / return, fines, messaging) for two roles: **Admin** and **Student**, with bcrypt password hashing, OTP‑based email verification, CSRF-protected forms, and prepared-statement database access throughout.

## 🎯 Project Overview

This comprehensive library management system digitizes traditional library operations through modern web technologies, providing an intuitive and secure platform for both library administrators and students. The application demonstrates full-stack development expertise while solving real-world challenges in educational institutions.

**🔹 What it does:** Automates book circulation, user management, fine calculations, and communication workflows  
**🔹 Who it's for:** Educational institutions, libraries, and organizations managing book lending operations  
**🔹 Why it matters:** Reduces manual workload by 80%, enhances security, and improves user experience through digital transformation  

### 💼 Technical Excellence
- **Modern Security**: bcrypt password hashing, OTP email verification, CSRF-protected forms, prepared SQL statements
- **Responsive Design**: Mobile-first approach with Bootstrap framework for optimal user experience
- **Scalable Architecture**: Role-based access control supporting hundreds of concurrent users
- **Production Ready**: Input validation, image-upload allowlisting, and secure deployment practices

## Developer Contact Information

### Tonmoy Sarker Sourav

[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=flat&logo=linkedin)](https://www.linkedin.com/in/tonmoyy/) <br>
[![Facebook](https://img.shields.io/badge/Facebook-1877F2?style=flat&logo=facebook&logoColor=white)](https://www.facebook.com/realtonmoysarker) <br>
[![Email](https://img.shields.io/badge/Email-D14836?style=flat&logo=gmail&logoColor=white)](mailto:tonmoy4451@gmail.com)  tonmoy4451@gmail.com

Check the live demo: https://onlinelibrary.tonmoyy.me/

## ✨ Key Features

### Authentication & Accounts
- **Dual User System**: 
  - Separate interfaces for administrators and students
  - Role-based access control
  - Basic session management

- **Registration System**: 
  - Email verification with OTP
  - Real-time username/email/roll-number availability check as you type
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
   - Prepared-statement SQL queries
   - CSRF-protected forms
   - Input validation & escaped output
   - Session management
   - Password protection (bcrypt)

5. **Notifications**
   - Email notifications for:
     - Due dates
     - Registration
     - Password reset

## ⚙️ Technical Requirements

- PHP 8.1 or higher (uses `mysqli_report()`, `str_contains()`; earlier PHP 7.x will run in a more error-tolerant mode but 8.1+ is recommended)
- MySQL 5.7 or higher / MariaDB 10.3+
- Apache Web Server with `mod_rewrite` enabled (used by `.htaccess` for clean URLs)
- A local server stack: XAMPP (Windows/Linux/macOS), WAMP (Windows), MAMP (macOS), or a native LAMP setup (Linux)
- Web Browser (Chrome/Firefox/Safari/Edge)
- Composer is **not** required — PHPMailer is vendored directly under `PHPMailer/`, `admin/PHPMailer/`, `student/PHPMailer/`

## 🚀 Quick Start

Pick your OS below, then jump to [Database Setup](#database-setup) and [Email / OTP Setup](#-email--otp-setup-phpmailer) — those steps are the same on every platform.

<details>
<summary><b>🪟 Windows (XAMPP)</b></summary>

1. Install [XAMPP](https://www.apachefriends.org/) and start it, then start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Clone the repo directly into `htdocs`:
```bat
cd C:\xampp\htdocs
git clone https://github.com/tonmoy-y/Smart-LIbrary-Management-System.git
```
3. Open a browser at `http://localhost/Smart-LIbrary-Management-System/`.
4. PHP/MySQL binaries live under `C:\xampp\php` and `C:\xampp\mysql\bin` — add them to your `PATH` if you want to run `php`/`mysql` from a terminal.

</details>

<details>
<summary><b>🍎 macOS (MAMP or Homebrew)</b></summary>

**Option A — MAMP** (easiest, GUI-based):
1. Install [MAMP](https://www.mamp.info/), start it, and set the document root to a folder of your choice.
2. Clone the repo into that folder:
```bash
cd /Applications/MAMP/htdocs
git clone https://github.com/tonmoy-y/Smart-LIbrary-Management-System.git
```
3. Visit `http://localhost:8888/Smart-LIbrary-Management-System/` (MAMP's default Apache port is 8888, not 80).

**Option B — Homebrew (native PHP + MySQL, no GUI)**:
```bash
brew install php mysql
brew services start mysql
git clone https://github.com/tonmoy-y/Smart-LIbrary-Management-System.git
cd Smart-LIbrary-Management-System
php -S localhost:8000
```
Since PHP's built-in server doesn't apply `.htaccess` rewrite rules, add a tiny router so clean URLs (e.g. `/login` instead of `/login.php`) still work:
```bash
cat > router.php << 'EOF'
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && !is_file($file) && is_file($file . '.php')) {
    require $file . '.php';
    return true;
}
return false;
EOF
php -S localhost:8000 router.php
```
Then visit `http://localhost:8000/`.

</details>

<details>
<summary><b>🐧 Linux (LAMP)</b></summary>

Debian/Ubuntu example:
```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysqli libapache2-mod-php
sudo a2enmod rewrite
sudo systemctl restart apache2

cd /var/www/html
sudo git clone https://github.com/tonmoy-y/Smart-LIbrary-Management-System.git
sudo chown -R www-data:www-data Smart-LIbrary-Management-System
```
Make sure your Apache vhost/`.htaccess` has `AllowOverride All` so the project's `.htaccess` rewrite rules take effect. Then visit `http://localhost/Smart-LIbrary-Management-System/`.

Fedora/RHEL: swap the install commands for `sudo dnf install httpd mariadb-server php php-mysqlnd` and use `systemctl` the same way.

</details>

### Database Setup

Works the same on every OS — from a terminal (`mysql` CLI) or phpMyAdmin:
```sql
CREATE DATABASE library CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Import the provided schema file (adjust the path to wherever you cloned the repo):
```bash
mysql -u root library < "library (4).sql"
```

### Configure the Database Connection

Open `connection.php`, `admin/connection.php`, and `student/connection.php` and set your local credentials:
```php
mysqli_report(MYSQLI_REPORT_OFF); // keep this line — restores classic mysqli error handling on PHP 8.1+
$db = mysqli_connect("localhost","root","","library");
```
- **Windows (XAMPP)**: default is `root` with an **empty** password.
- **macOS (MAMP)**: default is `root` / `root`, and MAMP's MySQL often runs on port `8889` — use `mysqli_connect("localhost:8889","root","root","library")` if you hit a connection error.
- **Linux**: use whatever user/password you configured when installing `mysql-server`/`mariadb-server`.

### Run It

1. Visit the project URL for your OS (see above) and register an **Admin** account first via the registration flow.
2. Register a **Student** account, complete OTP email verification (see [Email / OTP Setup](#-email--otp-setup-phpmailer) below to make this actually send).
3. Log in as either role and explore the dashboards.

## 📧 Email / OTP Setup (PHPMailer)

Registration, password reset, and admin due-date reminders all send email through **PHPMailer** (vendored under `PHPMailer/`, `admin/PHPMailer/`, `student/PHPMailer/` — no Composer needed) over an authenticated Gmail SMTP connection.

1. Copy each `mail_config.example.php` to `mail_config.php` in the same folder:
```bash
cp mail_config.example.php mail_config.php
cp admin/mail_config.example.php admin/mail_config.php
cp student/mail_config.example.php student/mail_config.php
```
   (On Windows, use `copy` instead of `cp`, or just duplicate the files in File Explorer and rename them.)

2. Edit each `mail_config.php` with a real Gmail address and an **App Password** (not your normal Gmail password — generate one at [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords), which requires 2-Step Verification to be enabled):
```php
define('SMTP_EMAIL', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-16-character-app-password');
```

3. `mail_config.php` is listed in `.gitignore` — it's meant to hold a real secret locally and should never be committed.

4. Test it by registering a new student account; you should receive an OTP email within a few seconds. If it fails, check:
   - The app password is correct and 2-Step Verification is enabled on the Gmail account.
   - Outbound port `587` isn't blocked by your firewall/network (common on some corporate or school networks).
   - PHP's `openssl` extension is enabled (`php -m | grep openssl` on macOS/Linux, or check `php.ini` on Windows).

### Password Column Length (upgrading from an older schema)
If you're importing an older database dump that predates bcrypt hashing, make sure the password columns can hold a 60-character hash:
```sql
ALTER TABLE admin   MODIFY password VARCHAR(255) NOT NULL;
ALTER TABLE student MODIFY password VARCHAR(255) NOT NULL;
```

---

## 📦 Deployment (Shared Hosting / VPS Quick Notes)
| Environment | Notes |
|-------------|-------|
| Shared Hosting | Upload project contents into `public_html/Smart-LIbrary-Management-System/` (or root) and adjust paths. |
| VPS (LAMP) | Place under `/var/www/html/Smart-LIbrary-Management-System`; set correct ownership (`www-data`). |
| Nginx + PHP-FPM | Root to `/var/www/html/Smart-LIbrary-Management-System`; ensure `index.php` forwarding; configure `fastcgi_pass`. |
| SSL | Use Certbot (Let’s Encrypt) – not required locally but recommended live. |

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
| Email sending | `mail_config.php` (root, `admin/`, `student/`) | Set `SMTP_EMAIL` / `SMTP_PASSWORD` — see [Email / OTP Setup](#-email--otp-setup-phpmailer) |
| CSRF Protection | `csrf.php` (root, `admin/`, `student/`) | Included automatically on every page with a state-changing form |

Keep password columns as `VARCHAR(255)` to avoid hash truncation.

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

## 🔐 Security Features
- Bcrypt password hashing (`password_hash`, `password_verify`).
- Session-based auth segregation (student vs admin namespaces).
- OTP-based email verification & password reset (with server-side expiry + DB cleanup), sent via authenticated SMTP through PHPMailer.
- SQL queries built with `mysqli` prepared statements and bound parameters throughout, rather than raw string interpolation.
- CSRF tokens on every state-changing form, verified server-side before the request is processed.
- File uploads (book covers, profile pictures) are restricted to an image-extension allowlist and validated with `getimagesize()` before being accepted.
- Output escaped with `htmlspecialchars()` where user-supplied data is rendered back into HTML.
- Limited exposure of sensitive data (password hashes not displayed in profiles).

### Recommended Future Hardening
- Rate-limit OTP resend & login attempts.
- Enforce a stronger password policy (length / complexity / breached-password check).
- Add an audit log for issues, returns, and admin actions.
- Add automated tests around the circulation/fine workflows.

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
├─ csrf.php
├─ mail_config.example.php  # copy to mail_config.php and fill in real credentials
├─ styles.css
├─ responsive.css
├─ .htaccess
├─ .gitignore
├─ library (4).sql          # Database schema file
├─ LICENSE.txt
├─ PHPMailer/               # Vendored PHPMailer library
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
│  ├─ check_availability.php  # AJAX endpoint for live username/email checks
│  ├─ connection.php
│  ├─ navbar.php
│  ├─ sidenav.php
│  ├─ footer.php
│  ├─ csrf.php
│  ├─ mail_config.example.php
│  ├─ styles.css
│  ├─ responsive.css
│  ├─ logout.php
│  ├─ session_destroy.php
│  ├─ expired.php
│  ├─ PHPMailer/
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
│  ├─ request.php
│  ├─ issue_info.php
│  ├─ fine.php
│  ├─ message.php
│  ├─ contact.php
│  ├─ check_availability.php
│  ├─ connection.php
│  ├─ navbar.php
│  ├─ footer.php
│  ├─ csrf.php
│  ├─ mail_config.example.php
│  ├─ styles.css
│  ├─ responsive.css
│  ├─ logout.php
│  ├─ session_destroy.php
│  ├─ expired.php
│  └─ PHPMailer/
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
- No queue / cron for periodic cleanup (expired OTPs and overdue-book checks run ad-hoc on page hits, not on a schedule).
- No login/OTP-resend rate limiting yet.
- Limited audit / reporting exports.
- Email deliverability depends on the Gmail SMTP app-password configured in `mail_config.php`.

## 🤝 Contributing
PRs welcome. Please open an Issue first for significant changes.

## 📄 License
MIT – see `LICENSE.txt`.

## 💬 Support
Open an Issue or reach out via the contact channels above.

---
Built with care to simplify campus library workflows. Contributions & feedback are appreciated.
