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
    <title>Admin Log in </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



</head>
<body>
    <div class="wrapper">
        

    <section class="log_img">
        <br>
        <div class="box1">
            <br> 
            <h1 style="text-align: center; font-size: 35px; font-family: 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Bitstream Vera Sans Mono', monospace;">Library Management System</h1>
        <h1 style="text-align: center; font-size: 25px;">Admin Login Form</h1>
            <form name="Login" action="" method="post">
                <div class="login">
                <input class="form-control" style="width:300px;" type="text" id="username" name="username" placeholder="Username" required>
                <input class="form-control" style="width:300px;" type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" class="btn btn-success" value="Login" name="submit" style="color: rgb(255, 255, 255); width: 70px ; height: 30px; font-weight: 1000;">
            </div> 
            </form>
            <p class="forget">
                <a style="color:#ffd700;; text-decoration:none;" href="update_password"> Forgot Password</a><br>
                New to this website? <a style="color:#ffd700;; text-decoration:none;" href="register">Register</a><br>
            </p>
        </div>


    </section>
    <?php
    if(isset($_POST['submit'])) {
        $count = 0;
        $res = mysqli_query($db,"SELECT * FROM `admin` WHERE username='$_POST[username]'");
        
        $row = mysqli_fetch_assoc($res);
        $count = mysqli_num_rows($res);
        if($count == 0) {
            ?>
        <script type="text/javascript">
            alert("Invalid Username or Password!");
        </script>
            <?php
        }
        else {


            /* if matched  */

            $stored_password = $row['password'];
            if(password_verify($_POST['password'], $stored_password)) {
                $_SESSION['login_admin'] = $_POST['username'];
                $_SESSION['pic'] = $row['pic'];

                ?>
               <script type="text/javascript">
                    alert("Login Successful!");
                   window.location = "index";
               </script>
<?php
            } 
            else {
                ?>
                <script type="text/javascript">
                    alert("Invalid Username or Password!");
                </script>





                <?php
            }
        }
    }
                ?>
<footer>

</footer>
    
    </div>
</body>
</html>