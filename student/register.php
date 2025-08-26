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

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="wrapper">
      <section>
     
        <div class="box2">
<br>
            <h1 style= "text-align: center; font-size: 35px;font-family: Lucida Console;">Library Management</h1>
        <h1 style="text-align: center; font-size: 25px;">User Registration Form</h1>
            <form name="Registration" action="" method="post">
                <div class="reg" class="form-control">
                <input class="form-control" type="text" id="Name" name="name" placeholder="Full Name" required>
                <input class="form-control" type="text" id="Roll" name="roll" placeholder="Roll Number" required>
                <input class="form-control" type="text" id="Dept" name="dept" placeholder="Department Name (Ex: CSE)" required>
                <input class="form-control" type="number" id="Phone" name="phone" placeholder="Phone No" required>
                <input class="form-control" type="email" id="email" name="email" placeholder="Email Address" required>
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required>
                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" class="btn btn-success" value="Register" name="submit" style="color: rgb(255, 255, 255); width: 100px ; height: 30ox; font-weight: 1000;">

            </div> 
            </form>
         
        </div>


    </section>

     <?php
        if(isset($_POST['submit'])) {
            $count = 0;
            $sql = "SELECT username,email,roll FROM student";
            $res = mysqli_query($db,$sql);
            while($row = mysqli_fetch_assoc($res)) { 
                if($row['username'] == $_POST['username'] || $row['email'] == $_POST['email'] || $row['roll'] == $_POST['roll']) {
                    $count =$count + 1;
                }
            }
            if($count==0) {
                // $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $hashed_password = ($_POST['password']);
                // $hashed_password = md5($_POST['password']);
                if (str_contains($_POST['username'], 'admin')) {
    ?>
     <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Username cannot contain 'admin' keyword. Please choose another username.",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "../verify.php";
        });
        </script>

    <?php
    exit();
}

        mysqli_query($db,"INSERT INTO `student` VALUES('$_POST[name]','$_POST[roll]','$_POST[dept]','$_POST[phone]','$_POST[email]','0','$_POST[username]','$hashed_password','user.jpg');");
        $otp = rand(100000,999999);
        mysqli_query($db,"INSERT INTO `verify` (username, email, otp) VALUES('$_POST[username]','$_POST[email]','$otp')");
        $to = $_POST['email'];
        $subject = "Account Verification";
        $msg = "Your OTP is: $otp.";
        $from = "From: tonmoy4451@gmail.com";
        if(mail($to, $subject, $msg, $from)) {
                 ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
           Swal.fire({
  title: "Success!",
  text: "Registration Successful! Now verify your email.",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "../verify.php";
        });
        </script>
        <?php
            }
else {
                ?>
                <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Error sending verification email. Please contact support.",
  icon: "error",
  confirmButtonText: "I Understand",
  confirmButtonColor: "#589cdbff"
}).then(() => {
            window.location = "register.php";
        });
        </script>
                <?php 
            }


             }
            else {
                ?>

                <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Username or Email or Roll already exists!",
  icon: "error",
  confirmButtonText: "I Understand",
  confirmButtonColor: "#468ed2ff"
}).then(() => {
            window.location = "register.php";
        });
        </script>

                
                <?php 
            }
        }
     ?>

    <footer>

    </footer>
    </div>
</body>
</html>