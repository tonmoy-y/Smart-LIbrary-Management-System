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
    <title>Student Registration </title>

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
<br><br><br>

<form action="" name="signup" method="post">

    <span style="font-size: 20px; font-weight:bold; margin-right:10px;">Sign up as:</span>
    
    <label style="margin-right:15px; vertical-align: middle;">
        <input type="radio" name="user" value="admin" style="vertical-align: middle; margin-top:-2px;"> Admin
    </label>
    
    <label style="vertical-align: middle;">
        <input type="radio" name="user" value="student" checked="" style="vertical-align: middle; margin-top:-2px;"> Student
    </label>
    <br><br>
    <button class="btn btn-primary" type="submit" name="submit1" style="margin-top: 10px; font-weight: 700; color: white;">Next</button>

</form>

     </div>

    </section>

     <?php
       
    if (isset($_POST['submit1'])) {
     if (isset($_POST['user']) && $_POST['user'] == 'admin') {
 ?>
        <script>
            // alert("You have selected Admin. Redirecting to Admin Registration.");
            window.location.href = "admin/update_password.php";
        </script>
<?php
} elseif (isset($_POST['user']) && $_POST['user'] == 'student') {
            echo "<script>
            // alert('You have selected Student. Redirecting to Student Registration.');
            window.location.href = 'student/update_password.php';
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