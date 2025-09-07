<?php
    include "connection.php";
    include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Password Reset </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
/* .box {

} */

</style>

</head>
<body>
    <div class="wrapper">
      <section>
     <div class="box" style="text-align:center; font-size: 20px;">
<br><br>

<form action="" name="signup" method="post">
    <h2 style="font-size: 24px; font-weight: bold;"> Reset Password</h2> <br>
    <span style="font-size: 20px; font-weight:bold; margin-right:10px;">Reset for:</span>
    
    <label style="margin-right:15px; vertical-align: middle;">
        <input type="radio" name="user" value="admin" style="vertical-align: middle; margin-top:-2px;"> Admin
    </label>
    
    <label style="vertical-align: middle;">
        <input type="radio" name="user" value="student" checked="" style="vertical-align: middle; margin-top:-2px;"> Student
    </label>
    <br><br>
    <button class="btn btn-primary btn-lg" type="submit" name="submit1" style="margin-top: 8px; font-weight: 700; color: white; font-size: 16px;">Reset </button>

</form>

     </div>

    </section>

     <?php
       
    if (isset($_POST['submit1'])) {
     if (isset($_POST['user']) && $_POST['user'] == 'admin') {
         $_SESSION['admin_reset'] = true;
        $_SESSION['admin_reset_time'] = time();

 ?>
        <script>
            // alert("You have selected Admin. Redirecting to Admin Registration.");
            window.location.href = "admin/update_password";
        </script>
<?php
} elseif (isset($_POST['user']) && $_POST['user'] == 'student') {
     $_SESSION['student_reset'] = true;
        $_SESSION['student_reset_time'] = time();
            echo "<script>
            // alert('You have selected Student. Redirecting to Student Registration.');
            window.location.href = 'student/update_password';
        </script>";
        } else {
            echo "<script>alert('Please select a user type.');</script>";
        }   
    }
        ?>
       
      
          

    <footer>

    </footer>
    </div>
</body>
</html>