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
    <title>Admin Registration </title>

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
        <h1 style="text-align: center; font-size: 25px;">Admin Registration Form</h1> <br>
            <form name="Registration" action="" method="post">
                <div class="reg" >
                <input class="form-control" style="width:300px;" type="text" id="Name" name="name" placeholder="Full Name" required>
                <!-- <input class="form-control" type="text" id="Roll" name="roll" placeholder="Roll Number" required> -->
                <input class="form-control" style="width:300px;" type="text" id="Dept" name="dept" placeholder="Department Name (Ex: CSE)" required>
                <input class="form-control" style="width:300px;" type="number" id="Phone" name="phone" placeholder="Phone No" required>
                <input class="form-control" style="width:300px;" type="email" id="email" name="email" placeholder="Email Address" required>
                <input class="form-control" style="width:300px;" type="text" id="username" name="username" placeholder="Username" required>
                <input class="form-control" style="width:300px;" type="password" id="password" name="password" placeholder="Password" required>
             
                <!-- space  -->


                <input type="submit" class="btn btn-success" value="Register" name="submit" style="color: rgb(255, 255, 255); width: 200px ; height: 40px; font-weight: 1000;">

            </div> 
            </form>
         
        </div>


    </section>

     <?php
        if(isset($_POST['submit'])) {
            $count = 0;
            $sql = "SELECT username FROM `admin`";
            $res = mysqli_query($db,$sql);
            while($row = mysqli_fetch_assoc($res)) { 
                if($row['username'] == $_POST['username']) {
                    $count =$count + 1;
                }
            }
            if($count==0) {
                // $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $hashed_password = ($_POST['password']);
                // $hashed_password = md5($_POST['password']);
              mysqli_query($db,"INSERT INTO `admin` VALUES( ' ', '$_POST[name]','$_POST[dept]','$_POST[phone]','$_POST[email]','$_POST[username]','$hashed_password','admin.jpg','');");
        
        ?>
        <script type="text/javascript">
            alert("Registration Successful! Now you can login.");
            window.location = "../login.php";
        </script>
        <?php
            }
            
            else {
                ?>
                <script type="text/javascript">
                    alert("Username already exists! Please choose another username.");
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