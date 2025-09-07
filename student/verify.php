<?php
include "navbar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Verification </title>

    <style>
        .box1 {
    height: 400px;
    width: 400px;
    background-color:#610795;
    margin: 30px auto;
    opacity: .7;
    color: rgb(248, 242, 242);
    border-radius: 15px;
    /* nicer look */
    backdrop-filter: blur(4px);
    box-shadow: 0 10px 24px rgba(0,0,0,.25);
}

.bgs {
    margin-top: 0px;;
    width: 100%;
    height: calc(100vh - 200px);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-image: url("images/book-library.jpg");
}

/* OTP inputs styling */
.otp-group {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin: 10px 0 20px;
}

.otp-input {
    width: 48px;
    height: 56px;
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, .6);
    background: rgba(255, 255, 255, .9);
    color: #333;
    outline: none;
    transition: border-color .15s ease, box-shadow .15s ease, transform .05s ease;
}

.otp-input:focus {
    border-color: #9b5de5;
    box-shadow: 0 0 0 3px rgba(155, 93, 229, .2);
}

.btn.btn-success {
    width: 100%;
    font-weight: 600;
}
    </style>
</head>
<body class="bgs">
    <div class="box1" style="padding: 30px;">
        <br>
        <h3 style="text-align: center; text-weight=700;">Reset Your Password</h3>
        <p style="line-height: 1.3; text-align: center;">
    Please enter the OTP sent to 
    <span style="background: #fffbe6; color: #b36f00; font-weight: bold; padding: 8px 22px; border-radius: 7px; border: 1.5px solid #ffe58f; margin-left: 12px; margin-right: 12px; display: inline-block;">
        <?php echo $_SESSION['email']; ?>
    </span>.
</p>

<div style="text-align:center; margin-top:25px;">
  <span id="timer1"
        style="display:inline-block;
               font-family: 'Segoe UI', Tahoma, sans-serif;
               background: linear-gradient(135deg, #667eea, #764ba2);
               color: #fff;
               font-weight: 600;
               font-size: 20px;
               letter-spacing: 1px;
               padding: 10px 28px;
               border-radius: 50px;
               box-shadow: 0 6px 15px rgba(0,0,0,0.25);
               transition: all 0.3s ease;">
    ⏳ Time left: 03:00
  </span>
</div>


        <br>
    <form id="otpForm" action="" method="post">
        <!-- OTP digit boxes (UI only) -->
        <div class="otp-group" data-length="6">
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" autocomplete="one-time-code" />
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" />
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" />
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" />
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" />
            <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" />
        </div>
        <!-- Hidden field that preserves the original PHP behavior -->
        <input type="hidden" name="otp" id="otpHidden" />
        <button type="submit" name="submit_v" class="btn btn-success">Verify</button>
    </form>
    </div>

    <!-- OTP UI behavior (no backend change) -->
    <script>
    (function () {
      const form = document.getElementById('otpForm');
      const inputs = Array.from(document.querySelectorAll('.otp-input'));
      const hidden = document.getElementById('otpHidden');
      const len = inputs.length;

      // Focus first box on load
      window.addEventListener('DOMContentLoaded', () => inputs[0]?.focus());

      // Only allow digits, auto-advance
      inputs.forEach((inp, idx) => {
        inp.addEventListener('input', (e) => {
          let v = e.target.value.replace(/\D/g, '');
          e.target.value = v.slice(0, 1);
          if (v && idx < len - 1) inputs[idx + 1].focus();
          updateHidden();
        });

        // Handle backspace and arrow navigation
        inp.addEventListener('keydown', (e) => {
          if (e.key === 'Backspace' && !inp.value && idx > 0) {
            inputs[idx - 1].focus();
            inputs[idx - 1].value = '';
            e.preventDefault();
            updateHidden();
          }
          if (e.key === 'ArrowLeft' && idx > 0) {
            inputs[idx - 1].focus();
            e.preventDefault();
          }
          if (e.key === 'ArrowRight' && idx < len - 1) {
            inputs[idx + 1].focus();
            e.preventDefault();
          }
        });

        // Paste full OTP
        inp.addEventListener('paste', (e) => {
          const text = (e.clipboardData || window.clipboardData).getData('text');
          if (!text) return;
          const digits = text.replace(/\D/g, '').slice(0, len);
          if (!digits) return;
          e.preventDefault();
          for (let i = 0; i < len; i++) {
            inputs[i].value = digits[i] || '';
          }
          const lastFilled = Math.min(digits.length, len) - 1;
          inputs[Math.max(0, lastFilled)].focus();
          updateHidden();
        });
      });

      function updateHidden() {
        hidden.value = inputs.map(i => i.value).join('');
      }

      form.addEventListener('submit', (e) => {
        updateHidden();
        if (hidden.value.length !== len) {
          e.preventDefault();
          if (window.Swal) {
            Swal.fire({
              title: 'Incomplete OTP',
              text: 'Please enter all digits.',
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          } else {
            alert('Please enter all digits.');
          }
        }
      });
    })();
    </script>

<script>
let expireAt = <?php echo isset($_SESSION['otp_expire']) ? $_SESSION['otp_expire'] : time(); ?> * 1000;
const timerEl = document.getElementById('timer1');

function updateTimer() {
  let diff = Math.floor((expireAt - Date.now()) / 1000);
  if (diff <= 0) {
    timerEl.textContent = "⏳ OTP Expired!";
    timerEl.style.background = "#f8d7da";
    timerEl.style.color = "#721c24";
    timerEl.style.borderColor = "#f5c6cb";
    return;
  }
  let m = Math.floor(diff / 60);
  let s = diff % 60;
  timerEl.textContent = `⏳ Time left: ${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
  setTimeout(updateTimer, 1000);
}
updateTimer();
</script>




    <?php
if (isset($_POST['submit_v'])) {

    // ensure expired rows removed again (race-safe)
    mysqli_query($db, "DELETE FROM verify WHERE created_at < DATE_SUB(NOW(), INTERVAL 3 MINUTE)");

    $username = isset($_SESSION['username']) ? mysqli_real_escape_string($db, $_SESSION['username']) : '';
    $otp = isset($_POST['otp']) ? mysqli_real_escape_string($db, $_POST['otp']) : '';

    if (empty($username) || strlen($otp) != 6) {
        echo "<script>
        Swal.fire({ title: 'Warning!', text: 'Invalid OTP.', icon: 'warning', confirmButtonText: 'OK' })
             .then(()=>{ window.location='verify'; });
        </script>";
        exit;
    }

    // check exact match — expired rows were already deleted, so presence = valid & not expired
    $res = mysqli_query($db, "SELECT * FROM verify WHERE username='$username' AND otp='$otp' LIMIT 1");
    if ($res && mysqli_num_rows($res) === 1) {
        
  // hash password before saving to DB
  $raw_password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
  $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

  mysqli_query($db, "DELETE FROM verify WHERE username='$username'");
  mysqli_query($db, "UPDATE `student` SET `password`='$hashed_password' WHERE username='$username'");

        // clear session
        unset($_SESSION['email'], $_SESSION['username'], $_SESSION['password'], $_SESSION['student_reset'], $_SESSION['student_reset_time']);

        echo "<script>
          Swal.fire({ title: 'Success!', text: 'Password Changed Successfully.', icon: 'success', confirmButtonText: 'OK' })
               .then(()=>{ window.location='../login'; });
          </script>";
        exit;
    } else {
        // either invalid or expired (already removed)
        echo "<script>
          Swal.fire({ title: 'Warning!', text: 'Invalid OTP.', icon: 'warning', confirmButtonText: 'OK' })
               .then(()=>{ window.location='verify'; });
          </script>";
        exit;
    }
}
?>