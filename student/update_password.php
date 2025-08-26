<?php
    include "connection.php";
    include "navbar.php";
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>

    <style type="text/css">
        body {
            display: flex;
            margin-bottom: 0;
            height: calc(100vh - 190px);
            width: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;

            background-image: url("images/forget1.png");
            /* background-color: rgb(36, 107, 116); */

        }
        .wrapper {
            width  : 400px;
            /* height : 300px; */
            margin: 75px auto;
            background-color: black;
            opacity: 0.8;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            /* justify-content: center; */
            align-items: center;


        }
input.form-control {
    width: 300px;
    max-width: 300px;
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
}


    </style>
</head>
<body>
    <div class="wrapper" >
        <div style="text-align:center; color: white;">
            <!-- <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Library Management System</h1> -->
            <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Change your password</h1>

        </div>

        <form action="" method="post" >
            <input type="text" name="username" placeholder="Enter your username" class="form-control" required> <br>
            <input type="text" name="email" placeholder="Enter your email" class="form-control" required> <br>
            <input type="text" name="password" placeholder="Enter your New password" class="form-control" required> <br>
            <button class="btn btn-default" type="submit" style="float:right; margin-top: 10px; " name="submit">
                Change Password
            </button>
        </form>

    </div>
    <?php
if(isset($_POST['submit'])) {
    $rest = mysqli_query($db,"SELECT * FROM `student` WHERE username='$_POST[username]' AND email='$_POST[email]'");
    $_SESSION['password'] = $_POST['password'];
    if($rest) { // যদি UPDATE সফল হয়
        if(mysqli_affected_rows($db) > 0) { // কতগুলা রো affected হয়েছে চেক করবে
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
  text: "OTP Sent To email",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "verify.php";
        });
        </script>
        <?php
            }
        } else { // যদি username/email মেল না খায়
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
        }
    } else { // কুয়েরি fail হলে
        echo "Database error: " . mysqli_error($db);
    }
}

    ?>


</body>
</html>