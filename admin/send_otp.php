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

    // Save the OTP so it can be checked against what the user submits
    if ($stmt = mysqli_prepare($db, "INSERT INTO `verify_admin` (username, email, otp) VALUES(?, ?, ?)")) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $otp);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Mail content — branded to match the site's indigo/gold theme, laid
    // out with tables/inline styles for broad email-client compatibility.
    $subject = "Reset your Online Library admin password";
    $safeName = htmlspecialchars($username, ENT_QUOTES);
    $msg = "
    <html>
    <body style='margin:0; padding:0; background:#f4f2f7; font-family: Arial, Helvetica, sans-serif;'>
      <table role='presentation' width='100%' cellpadding='0' cellspacing='0' style='background:#f4f2f7; padding: 24px 0;'>
        <tr><td align='center'>
          <table role='presentation' width='480' cellpadding='0' cellspacing='0' style='max-width:480px; width:100%; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow: 0 6px 24px rgba(20,15,40,0.12);'>
            <tr>
              <td style='background: linear-gradient(120deg, #443a68 0%, #2b2444 100%); padding: 24px 28px;'>
                <span style='color:#ffffff; font-size:20px; font-weight:bold;'>&#128218; Online Library</span>
              </td>
            </tr>
            <tr>
              <td style='padding: 28px 28px 8px 28px; color:#2b2444;'>
                <p style='margin:0 0 12px 0; font-size:15px;'>Hi <b>{$safeName}</b>,</p>
                <p style='margin:0 0 20px 0; font-size:15px; line-height:1.5;'>Use the code below to reset your admin password. It expires in <b>3 minutes</b>.</p>
              </td>
            </tr>
            <tr>
              <td align='center' style='padding: 0 28px 24px 28px;'>
                <div style='display:inline-block; padding: 14px 32px; border: 2px dashed #d4a656; border-radius: 10px; background:#faf6ec;'>
                  <span style='font-size:30px; font-weight:bold; letter-spacing: 6px; color:#443a68;'>{$otp}</span>
                </div>
              </td>
            </tr>
            <tr>
              <td style='padding: 0 28px 28px 28px;'>
                <p style='margin:0; font-size:13px; color:#756a8f;'>Please don't share this code with anyone. If you didn't request this, you can safely ignore this email.</p>
              </td>
            </tr>
            <tr>
              <td style='background:#f4f2f7; padding: 16px 28px; text-align:center;'>
                <span style='font-size:12px; color:#9089a3;'>&mdash; Online Library Management System</span>
              </td>
            </tr>
          </table>
        </td></tr>
      </table>
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
        // For debugging, you can echo $mail->ErrorInfo here
        return false;
    }
}
?>
