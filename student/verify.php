<?php
include "navbar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verification </title>

    <style>
        .box1 {
    height: 400px;
    width: 400px;
    background-color:#610795;
    margin: 30px auto;
    opacity: .6;
    color: rgb(248, 242, 242);
    border-radius: 15px;
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
    </style>
</head>
<body class="bgs">
    <div class="box1" style="padding: 30px;">
        <br>
        <h3 style="text-align: center; text-weight=700;">Reset Your Password</h3>
        <p>Please enter the OTP sent to your registered email.</p>
       
        <br>
    <form action="" method="post" ">
        <input type="text" name="otp" class="form-control" placeholder="Enter OTP:" required> <br>
        <button type="submit" name="submit_v" class="btn btn-success">Verify</button>
    </form>
    </div>
    <?php
    $ver1=0;
if(isset($_POST['submit_v'])) {
$ver2 = mysqli_query($db,"SELECT * FROM verify;");
while($row= mysqli_fetch_assoc($ver2)) {
    if($row['otp'] == $_POST['otp']) {
        mysqli_query($db,"DELETE FROM verify WHERE username = '$row[username]';");
        mysqli_query($db,"UPDATE `student` SET `password` = '$_SESSION[password]' WHERE username = '$row[username]';");
        unset($_SESSION['password']);
        $ver1=$ver1+1;
    } 
}
if($ver1 ==1) {
    ?>
<script>
    alert("Account Verification Successful.");
    window.location = "../login.php";
</script>

<?php
}
else {
    ?>
<script>
    alert("Invalid OTP.");
</script>

<?php
}

}
    ?>
</body>
</html>