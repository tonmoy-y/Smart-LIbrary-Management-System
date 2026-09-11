<?php
    include "connection.php";
    include "navbar.php";
    include "csrf.php";
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
<style>
    .field-check { position: relative; width: 100%; max-width: 300px; }
    .field-check input { padding-right: 34px !important; width: 100%; max-width: none; }
    .field-check .check-icon {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        font-size: 15px; font-weight: bold; display: none; pointer-events: none;
    }
    .field-check .check-icon.ok { display: block; color: #2fae56; }
    .field-check .check-icon.taken { display: block; color: #e04b4b; }
    .field-check .check-icon.checking { display: block; color: rgba(255,255,255,0.7); font-size: 12px; }
    .field-hint { font-size: 12px; color: #ffb4b4; text-align: left; width: 100%; max-width: 300px; }
    .field-hint:empty { display: none; }
    #register-error { width: 100%; max-width: 300px; text-align: center; color: #ffb4b4; font-size: 14px; font-weight: 600; }
    #register-error:empty { display: none; }
</style>
</head>
<body>
    <div class="wrapper">
      <section>
     
        <div class="box2">
<br>
            <h1 style= "text-align: center; font-size: 35px; font-family: 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Bitstream Vera Sans Mono', monospace;">Library Management</h1>
        <h1 style="text-align: center; font-size: 25px;">Admin Registration Form</h1> <br>
            <form name="Registration" action="" method="post">
                <?php echo csrf_field(); ?>
                <div class="reg" >
                <input class="form-control" style="width:300px;" type="text" id="Name" name="name" placeholder="Full Name" required>
                <!-- <input class="form-control" type="text" id="Roll" name="roll" placeholder="Roll Number" required> -->
                <input class="form-control" style="width:300px;" type="text" id="Dept" name="dept" placeholder="Department Name (Ex: CSE)" required>
                <input class="form-control" style="width:300px;" type="number" id="Phone" name="phone" placeholder="Phone No" required>
                <div class="field-check">
                <input class="form-control" style="width:300px;" type="email" id="email" name="email" placeholder="Email Address" required autocomplete="off">
                <span class="check-icon" id="email-icon"></span>
                </div>
                <div class="field-hint" id="email-hint"></div>

                <div class="field-check">
                <input class="form-control" style="width:300px;" type="text" id="username" name="username" placeholder="Username" required autocomplete="off">
                <span class="check-icon" id="username-icon"></span>
                </div>
                <div class="field-hint" id="username-hint"></div>

                <input class="form-control" style="width:300px;" type="password" id="password" name="password" placeholder="Password" required>

                <!-- space  -->


                <input type="submit" class="btn btn-success" value="Register" name="submit" style="color: rgb(255, 255, 255); width: 200px ; height: 40px; font-weight: 1000;">
                <div id="register-error"></div>

            </div>
            </form>
            <script>
            (function() {
                var fields = [
                    { id: 'username', key: 'username', label: 'Username' },
                    { id: 'email', key: 'email', label: 'Email' }
                ];
                var timers = {};

                fields.forEach(function(f) {
                    var input = document.getElementById(f.id);
                    var icon = document.getElementById(f.id + '-icon');
                    var hint = document.getElementById(f.id + '-hint');
                    if (!input) return;

                    input.addEventListener('input', function() {
                        var value = input.value.trim();
                        icon.className = 'check-icon';
                        hint.textContent = '';
                        clearTimeout(timers[f.id]);

                        if (value === '') return;

                        icon.className = 'check-icon checking';
                        icon.textContent = '…';

                        timers[f.id] = setTimeout(function() {
                            fetch('check_availability.php?field=' + f.key + '&value=' + encodeURIComponent(value))
                                .then(function(r) { return r.json(); })
                                .then(function(data) {
                                    if (data.available === true) {
                                        icon.className = 'check-icon ok';
                                        icon.textContent = '✓';
                                        hint.textContent = '';
                                    } else if (data.available === false) {
                                        icon.className = 'check-icon taken';
                                        icon.textContent = '✕';
                                        hint.textContent = f.label + ' is already taken';
                                    } else {
                                        icon.className = 'check-icon';
                                    }
                                })
                                .catch(function() { icon.className = 'check-icon'; });
                        }, 400);
                    });
                });
            })();
            </script>
         
        </div>


    </section>

     <?php
        if(isset($_POST['submit'])) {
            csrf_verify();
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
               
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
              $stmt = mysqli_prepare($db, "INSERT INTO `admin` VALUES( ' ', ?, ?, ?, ?, ?, ?, 'admin.jpg', '')");
              mysqli_stmt_bind_param($stmt, "ssssss", $_POST['name'], $_POST['dept'], $_POST['phone'], $_POST['email'], $_POST['username'], $hashed_password);
              mysqli_stmt_execute($stmt);
        
        ?>
                  <script type="text/javascript">
Swal.fire({
    title: "Success!",
    text: "Registration Successful. You can login after approval.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "../login";
});
</script>
        <?php
            }
            
            else {
                ?>
                           <script type="text/javascript">
document.getElementById('register-error').textContent = "Username already exists! Please choose another username.";
Swal.fire({
    title: "Error!",
    text: "Username already exists! Please choose another username.",
    icon: "error",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "../login";
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