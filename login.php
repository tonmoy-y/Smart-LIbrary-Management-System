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
        <title>Log in </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="wrapper">
            
            
            <section class="log_img">
                <br>
                <div class="box1">
                   <h6> <br> </h6>
                    <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console; ;">Library Management System</h1>
                    <h1 style="text-align: center; font-size: 25px;">User Login Form</h1>
                    <form name="Login" action="" method="post">
                        

<div style="text-align:center;">
    <span style="font-weight:bold; margin-right:10px;">Login for:</span>

    <label style="margin-right:15px; vertical-align: middle;">
        <input type="radio" name="user" value="admin" style="vertical-align: middle; margin-top:-2px;"> Admin
    </label>

    <label style="vertical-align: middle;">
        <input type="radio" name="user" value="student" checked="" style="vertical-align: middle; margin-top:-2px;"> Student
    </label>
</div>


                        <div class="login">
                            <input class="form-control" type="text" id="username" name="username" placeholder="Username" required>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                            <input type="submit" class="btn btn-success" value="Login" name="submit" style="color: rgb(255, 255, 255); width: 80px ; font-size: 16px; opacity:1; height: 40px; font-weight: 700;">
                        </div> 
                    </form>
                    <p class="forget">
                        <a style="color: yellow; text-decoration:none;" href="update_password.php"> Forgot Password</a><br>
                        New to this website? <a style="color:#ffd700;; text-decoration:none;" href="register.php">Register</a><br>
                    </p>
                </div>
                
                
            </section>
            <?php
    if(isset($_POST['submit'])) {

        if($_POST['user'] == 'admin') {

            $count = 0;
        $res = mysqli_query($db,"SELECT * FROM `admin` WHERE username='$_POST[username]' and status='Yes';");

        $row = mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);
        if($count == 0) {
            ?>
         <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Invalid Username or Password!",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "login.php";
        });
        </script>
            <?php
        }
        else {


            /* if matched  */

            // $row = mysqli_fetch_assoc($res);
            $stored_password = $row['password'];
            if(($_POST['password'] == $stored_password  )) { //password_verify($_POST['password'], $stored_password)) {
                $_SESSION['login_user'] = $_POST['username'];
                $_SESSION['pic'] = $row['pic'];

                ?>



               <script type="text/javascript">
                   Swal.fire({
  title: "Success!",
  text: "Login Successful!",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
           window.location = "admin/profile.php";
       });
               </script>
<?php
            } 
            else {
                ?>
                 <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Invalid Username or Password!",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "login.php";
        });
        </script>

                <?php
            }
        }
        }
        else {

            
            $count = 0;
            $res = mysqli_query($db,"SELECT * FROM student WHERE username='$_POST[username]'");
            $row = mysqli_fetch_assoc($res);
            $count = mysqli_num_rows($res);
            if($count == 0) {
                ?>
        <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Invalid Username or Password!",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "login.php";
        });
        </script>
            <?php
        }
        else {
            
                        $stored_password = $row['password'];
            // if(password_verify($_POST['password'], $stored_password)) {
            if($row['status'] == 1) {
                if(($_POST['password'] == $stored_password)  ) {
                    $_SESSION['login_user'] = $_POST['username'];
                    $_SESSION['pic'] = $row['pic'];
                    
                    ?>
               <script type="text/javascript">
                   Swal.fire({
  title: "Success!",
  text: "Login Successful!",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
           window.location = "student/profile.php";
       });
               </script>
<?php
            } 
            else {
                ?>
                <script type="text/javascript">
                    Swal.fire({
  title: "Error!",
  text: "Invalid Username or Password!",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "login.php";
        });
                </script>

                <?php
            }
        }
        elseif($row['status'] == 0) {
?>
               <script type="text/javascript">
                   Swal.fire({
  title: "Error!",
  text: "Your account is not verified yet!",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
           window.location = "verify.php";
       });
               </script>
  <?php
            }
            else {
                ?>
                <script type="text/javascript">
                    Swal.fire({
  title: "Error!",
  text: "Invalid Username or Password!",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
           window.location = "login.php";
       });
                </script>





<?php
            }
        }
    }
}
    include "footer.php";
    ?>


</div>
</body>
</html>