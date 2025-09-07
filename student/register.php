<?php
    include "connection.php";
    include "navbar.php";
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style type="text/css" >
    .wapr {
        
        height: 629px !important;
    
       
    }
    
    </style>
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
<h6><br></h6>
            <h1 style= "text-align: center; font-size: 35px; font-family: 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Bitstream Vera Sans Mono', monospace;">Library Management</h1>
        <h1 style="text-align: center; font-size: 25px;">Registration Form</h1>
            <form name="Registration" action="" method="post">
                <div class="reg" class="form-control">
                <input class="form-control" type="text" id="Name" name="name" placeholder="Full Name" required
       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ''; ?>">
                <input class="form-control" type="text" id="Roll" name="roll" placeholder="Roll Number: 2103XXX" required
       value="<?php echo isset($_POST['roll']) ? htmlspecialchars($_POST['roll'], ENT_QUOTES) : ''; ?>">
                <input class="form-control" type="text" id="Dept" name="dept" placeholder="Department Name (Ex: CSE)" required
       value="<?php echo isset($_POST['dept']) ? htmlspecialchars($_POST['dept'], ENT_QUOTES) : ''; ?>">
                <input class="form-control" type="number" id="Phone" name="phone" placeholder="Phone No 017XXXXXXX" required
       value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone'], ENT_QUOTES) : ''; ?>">
                <input class="form-control" type="email" id="email" name="email" placeholder="Email Address" required
       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required
       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">
                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" class="btn btn-success" value="Register" name="submit" style="color: rgb(255, 255, 255); width: 120px ; height: 40px; font-weight: 700;">

            </div> 
            </form>
         
        </div>


    </section>

     <?php
        if(isset($_POST['submit'])) {
            $count = 0;
            $dupUsername = false; $dupEmail = false; $dupRoll = false;
            $sql = "SELECT username,email,roll FROM student";
            $res = mysqli_query($db,$sql);
            while($row = mysqli_fetch_assoc($res)) { 
                if($row['username'] == $_POST['username']) { $dupUsername = true; $count++; }
                if($row['email'] == $_POST['email'])       { $dupEmail = true;    $count++; }
                if($row['roll'] == $_POST['roll'])         { $dupRoll = true;     $count++; }
            }
            if($count==0) {
                // store password as a secure hash
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
            window.location = "../verify";
        });
        </script>

    <?php
    exit();
}

        mysqli_query($db,"INSERT INTO `student` VALUES('$_POST[name]','$_POST[roll]','$_POST[dept]','$_POST[phone]','$_POST[email]','0','$_POST[username]','$hashed_password','user.jpg');");
       include "../send_otp.php";
        if(sendOtp($db, $_POST['username'], $_POST['email'])) {
        $_SESSION['username'] = $_POST['username'];
         $_SESSION['student_reset'] = true;
        $_SESSION['student_reset_time'] = time();
                 ?>
        <script type="text/javascript">
           Swal.fire({
  title: "Success!",
  text: "Registration Successful! Now verify your email.",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "verify_acc";
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
            window.location = "register";
        });
        </script>
                <?php 
            }


             }
            else {
                // Show specific popup based on which field conflicts (priority: Roll, Email, Username)
                if ($dupRoll) { ?>
                <script type="text/javascript">
                  Swal.fire({
                    title: "Error!",
                    text: "Roll number already exists!",
                    icon: "error",
                    confirmButtonText: "I Understand",
                    confirmButtonColor: "#468ed2ff"
                  }).then(() => { // window.location = "register"; 

                  });
                </script>
                <?php } else if ($dupEmail) { ?>
                <script type="text/javascript">
                  Swal.fire({
                    title: "Error!",
                    text: "Email already exists!",
                    icon: "error",
                    confirmButtonText: "I Understand",
                    confirmButtonColor: "#468ed2ff"
                  }).then(() => { //window.location = "register";

                   });
                </script>
                <?php } else if ($dupUsername) { ?>
                <script type="text/javascript">
                  Swal.fire({
                    title: "Error!",
                    text: "Username already exists!",
                    icon: "error",
                    confirmButtonText: "I Understand",
                    confirmButtonColor: "#468ed2ff"
                  }).then(() => { // window.location = "register"; 

                  });
                </script>
                <?php }
            }
        }
     ?>

    </div>
    <?php
        include "footer.php";
    ?>
</body>
</html>