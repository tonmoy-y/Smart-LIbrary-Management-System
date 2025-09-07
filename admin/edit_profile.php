<?php
    include "connection.php";
    include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style type="text/css">
        form.write {
            width: 400px; 
          }

form.write input.form-control { 
            max-width: none;      
            width: 100%;       
                
          }
form {
    margin: 0 auto;
}
label {
    color: white;
}
    </style>
</head>
<body style="background-color:#246b74">
    
<h2 style="text-align:center; color: white;"> Edit Information</h2>
   
<?php
    $sql = "SELECT * FROM `admin` WHERE username='$_SESSION[login_admin]'";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        die(mysqli_error($db));
    }
   

    while ($row = mysqli_fetch_assoc($result)) {
        $name= $row['Name'];
        $dept= $row['dept'];    
        $phone= $row['phone'];
        $email= $row['email'];
        $username= $row['username'];
        $password= $row['password'];
        $currentPic = isset($row['pic']) ? $row['pic'] : '';

    }

?>



<div class="profile_info" style="text-align:center;">
        <span style="color: white;"> Welcome </span>
        <h4  style="color: white;">
            <?php 
                echo $_SESSION['login_admin'];
            ?>
        </h4>


        <form action="" method="post" enctype="multipart/form-data" class="write">

        <input type="file" name="file" class="form-control" style="width: 80%; height:40px; margin: 0 auto;">

        <label><h4><b>Name: </b></h4></label>
        <input class="form-control" type="text" name="Name" value="<?php echo $name; ?>">

        <label><h4><b> Department</b></h4></label>    
        <input class="form-control" type="text" name="dept" value="<?php echo $dept; ?>">
            
        <label><h4><b>Phone No:</b></h4></label>    
        <input class="form-control" type="text" name="phone" value="<?php echo $phone; ?>" >
            
        <label><h4><b>Email: </b></h4></label>
        <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" >
        
        <label><h4><b>Username :</b></h4></label>
        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" >
       
    <label><h4><b>Password:</b></h4></label>
    <input class="form-control" type="password" name="password" placeholder="Leave blank to keep current password"><br>
            <!-- <input type="text" name=""> -->
             <div style="text-align:center;">

                 <button class="btn btn-default" type="submit" name="submit"> Save</button>
                </div>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        if (!empty($_FILES['file']['name'])) {
            $original = $_FILES['file']['name'];
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $base = pathinfo($original, PATHINFO_FILENAME);
            $base = preg_replace('/[^A-Za-z0-9_-]+/', '_', $base);
            $base = trim($base, '_');
            if ($base === '') { $base = 'avatar'; }
            $pic = $base.'_'.time().'.'.$ext;
            $target = __DIR__ . '/../images/' . $pic;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $valid = (filesize($target) > 100) && @getimagesize($target);
                if ($valid) {
                    $_SESSION['pic'] = $pic;
                } else {
                    @unlink($target);
                    $pic = (!empty($_SESSION['pic'])) ? $_SESSION['pic'] : (isset($currentPic)?$currentPic:'');
                }
            } else {
                $pic = (!empty($_SESSION['pic'])) ? $_SESSION['pic'] : (isset($currentPic)?$currentPic:'');
            }
        } else {
            $pic = (!empty($_SESSION['pic'])) ? $_SESSION['pic'] : (isset($currentPic) ? $currentPic : '');
            if (empty($_SESSION['pic']) && !empty($pic)) {
                $_SESSION['pic'] = $pic;
            }
        }
        $name = $_POST['Name'];
        $dept = $_POST['dept'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $password_clause = '';
        if($new_password !== '') {
            $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $password_clause = ", password='$password_hashed'";
        }

    $picClean = preg_replace('/[^A-Za-z0-9._-]/','_', $pic);
    $sql1 = "UPDATE `admin` SET pic='$picClean', `Name`='$name', dept='$dept', phone='$phone', email='$email', username='$username' $password_clause WHERE username='$_SESSION[login_admin]'";
        
        if (mysqli_query($db, $sql1)) {

            if (!empty($username) && $username !== $_SESSION['login_admin']) {
                $_SESSION['login_admin'] = $username;
            }
?>
             <script type="text/javascript">
           Swal.fire({
  title: "Success!",
  text: "Profile updated successfully!",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "profile";
        });
        </script>
            
 <?php
        } else {
            
            ?>

            <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Error updating profile.",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "edit_profile";
        });
        </script>
        
            <?php
            
        }
    }
    ?>
</body>
</html>