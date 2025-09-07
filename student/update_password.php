<?php
        include "connection.php";
        include "navbar.php"; // navbar already renders <head> & styles
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        margin:0;
        min-height:100vh;
        background: url("images/forget1.png") center/cover no-repeat;
    }
    .password-wrapper {
        max-width:400px;
        margin:130px auto 80px;
        background:rgba(0,0,0,.82);
        border-radius:15px;
        padding:25px 28px 30px;
        text-align:center;
    }
    .password-wrapper h1 {font-size:30px;font-family:"Lucida Console", monospace;color:#fff;margin:0 0 25px;}
    .password-wrapper .form-control {width:100%;max-width:300px;margin:0 auto;padding:10px 12px;font-size:16px;border-radius:6px;border:none;}
    .password-wrapper button.btn {background:#7272b6;color:#fff;font-weight:600;border:none;padding:10px 18px;border-radius:8px;transition:.25s;}
    .password-wrapper button.btn:hover{opacity:.85;}
    html,body {overscroll-behavior:contain;}
    @media (max-width:576px){.password-wrapper{margin:110px 12px 60px;padding:22px 20px 26px;} .password-wrapper h1{font-size:24px;}}
</style>

<div class="password-wrapper">
    <h1>Change your password</h1>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Enter your username" class="form-control" required><br>
        <input type="text" name="email" placeholder="Enter your email" class="form-control" required><br>
        <input type="text" name="password" placeholder="Enter your New password" class="form-control" required><br>
        <button class="btn btn-default" type="submit" name="submit">Change Password</button>
    </form>
</div>
    <?php
if(isset($_POST['submit'])) {
    $rest = mysqli_query($db,"SELECT * FROM `student` WHERE username='$_POST[username]' AND email='$_POST[email]'");
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['email'] = $_POST['email'];
    if($rest) { //  UPDATE 
        if(mysqli_affected_rows($db) > 0) { 
           
        include "send_otp.php";
        if(sendOtp($db, $_POST['username'], $_POST['email'])) {
            

                 ?>
        <script type="text/javascript">
           Swal.fire({
  title: "Success!",
  text: "OTP Sent To email",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "verify";
        });
        </script>
        <?php
            }
        } else { // 
            ?>
            <script type="text/javascript">
            Swal.fire({
                title: "Error!",
                text: "Username or email not found.",
                icon: "error",
                confirmButtonText: "OK",
                confirmButtonColor: "#589cdbff"
            });
            </script>
            <?php
            // Clear session variables
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['username']);

        }
    } else { // কুয়েরি fail হলে
        echo "Database error: " . mysqli_error($db);
    }
}
include "footer.php";
    ?>


<!-- Closing tags provided by included navbar layout -->