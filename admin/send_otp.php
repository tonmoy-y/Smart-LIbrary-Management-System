<?php
function sendOtp($db, $username, $email) {
    // Secure OTP
    $otp = random_int(100000, 999999);

    // DB তে OTP সেভ কর
    mysqli_query($db, "INSERT INTO `verify_admin` (username, email, otp) VALUES('$username','$email','$otp')");

    // Mail setup
    $subject = "Rest Your Password";
    $msg = "
    <html>
    <body style='font-family: Arial, sans-serif; color: #333;'>
      <p>Dear " . htmlspecialchars($username) . ",</p>

      <p>🔐 <b>Your One-Time Password (OTP) for Password Reset</b> is:</p>
      <div style='padding: 10px; margin: 10px 0; border: 2px dashed #4CAF50; 
                  display: inline-block; font-size: 24px; font-weight: bold; 
                  background: #f9f9f9; border-radius: 8px;'>
        $otp
      </div>

      <p>Please do not share this code with anyone.</p>
      <p style='margin-top: 20px; font-weight: bold;'>– Online Library</p>
    </body>
    </html>
    ";

    // Headers
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Online Library <tonmoy4451@gmail.com>" . "\r\n";

    // Send mail
    if(mail($email, $subject, $msg, $headers)) {
        $_SESSION['otp_expire'] = time() + 183; // 3 min
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        return true;
    } else {
        return false;
    }
}

?>
