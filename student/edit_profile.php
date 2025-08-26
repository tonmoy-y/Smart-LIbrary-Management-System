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
    $sql = "SELECT * FROM `student` WHERE username='$_SESSION[login_user]'";
    $result = mysqli_query($db, $sql) or die(mysql_error());

    while ($row = mysqli_fetch_assoc($result)) {
        $name= $row['name'];
        $dept= $row['dept'];    
        $phone= $row['phone'];
        $email= $row['email'];
        $username= $row['username'];
        $password= $row['password'];

    }

?>



<div class="profile_info" style="text-align:center;">
        <span style="color: white;"> Welcome </span>
        <h4  style="color: white;">
            <?php 
                echo $_SESSION['login_user'];
            ?>
        </h4>


        <form action="" method="post" enctype="multipart/form-data" class="write">

        <input type="file" name="file" class="form-control" style="width: 80%; height:40px; margin: 0 auto;">

        <label><h4><b>Name: </b></h4></label>
        <input class="form-control" type="text" name="name" value="<?php echo $name; ?>">

        <label><h4><b> Department</b></h4></label>    
        <input class="form-control" type="text" name="dept" value="<?php echo $dept; ?>">
            
        <label><h4><b>Phone No:</b></h4></label>    
        <input class="form-control" type="text" name="phone" value="<?php echo $phone; ?>" >
            
        <label><h4><b>Email: </b></h4></label>
        <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" >
        
        <label><h4><b>Username :</b></h4></label>
        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>" >
       
        <label><h4><b>Password:</b></h4></label>
        <input class="form-control" type="text" name="password" value="<?php echo $password; ?>"><br>
            <!-- <input type="text" name=""> -->
             <div style="text-align:center;">

                 <button class="btn btn-default" type="submit" name="submit"> Save</button>
                </div>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {

        if (isset($_FILES['file']) && $_FILES['file']['name'] != "") {
            move_uploaded_file($_FILES['file']['tmp_name'], "../images/".$_FILES['file']['name']);
            $pic = $_FILES['file']['name'];
            $_SESSION['pic'] = $pic;

        }
        else {
            $pic = $_SESSION['pic']; // Keep the existing picture if no new file is uploaded
        }
        $name = $_POST['name'];
        $dept = $_POST['dept'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];


    
        $sql1 = "UPDATE `student` SET pic='$pic', `name`='$name', dept='$dept', phone='$phone', email='$email', username='$username', password='$password' WHERE username='$_SESSION[login_user]'";
        
        if (mysqli_query($db, $sql1)) {
            ?>

            <script type="text/javascript">
           Swal.fire({
  title: "Success!",
  text: "Profile updated successfully!",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#3085d6"
}).then(() => {
            window.location = "profile.php";
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
            window.location = "edit_profile.php";
        });
        </script>
        
            <?php
        }
    }
    ?>
</body>
</html>