<?php
// ================= PHPMailer Import =================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// ================= SMTP Credentials =================
// Loaded from mail_config.php (kept out of git; contains the real secret).
require __DIR__ . '/mail_config.php';

// ================= Function =================
function sendOtp($db, $username, $email) {
    // Secure OTP
    $otp = random_int(100000, 999999);

    // DB à¦¤à§ OTP à¦¸à§à¦­ à¦à¦°
    if ($stmt = mysqli_prepare($db, "INSERT INTO `verify` (username, email, otp) VALUES(?, ?, ?)")) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $otp);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Mail content
    $subject = "Account Verification";
    $msg = "
    <html>
    <body style='font-family: Arial, sans-serif; color: #333;'>
      <p>Dear " . htmlspecialchars($username) . ",</p>

      <p>ð <b>Your One-Time Password (OTP) for Account Activation</b> is:</p>
      <div style='padding: 10px; margin: 10px 0; border: 2px dashed #4CAF50; 
                  display: inline-block; font-size: 24px; font-weight: bold; 
                  background: #f9f9f9; border-radius: 8px;'>
        $otp
      </div>

      <p>Please do not share this code with anyone.</p>
      <p style='margin-top: 20px; font-weight: bold;'>â Online Library</p>
    </body>
    </html>
    ";

    // ==== PHPMailer ====
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_EMAIL;      
        $mail->Password = SMTP_PASSWORD;   
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom(SMTP_EMAIL, 'Online Library');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $msg;

        if ($mail->send()) {
            $_SESSION['otp_expire'] = time() + 183; // 3 min
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // For debugging, you can echo $mail->ErrorInfo here à¦à¦¾à¦à¦²à§ à¦à¦à¦¾à¦¨à§ echo $mail->ErrorInfo à¦à¦°à¦¤à§ à¦ªà¦¾à¦°à¦¿à¦¸
        return false;
    }
}
?>
