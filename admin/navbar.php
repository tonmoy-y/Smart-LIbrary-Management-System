<?php
session_start();
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Online Library Management</title>
  <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

</head>
<body>
    <!-- <div class="wrapper"> -->
<?php
if(isset($_SESSION['login_user'])) {
  $r=mysqli_query($db, "SELECT COUNT(status) AS total FROM `message` WHERE sender='student' AND status='no' ;");
  $c=mysqli_fetch_assoc($r);

  $sql_app= mysqli_query($db, "SELECT COUNT(status) AS total FROM `admin` WHERE status='';");
  $a=mysqli_fetch_assoc($sql_app);

}
?>
        <header>
            <a href="index.php">
            <img src="images/logo.png" alt="Library Logo" class="logo">

            <p class="logofont">Online Library Management System</p>
            </a >
            <nav class="navbar">


                <a href="index.php" class="nav-btn home">Home</a>
                <a href="books.php" class="nav-btn books">Books</a>
                <a href="contact.php" class="nav-btn feedback">Feedback</a>

                <?php
                      if(isset($_SESSION['login_user'])) {
                        ?>

<a href="student.php" class="nav-btn admin"> Student-Info </a>
 <a href="fine.php" class="nav-btn books"> Fines </a> 

                        <?php
                      }
?>
                
                <div class="rightend">
                  <?php
                      if(isset($_SESSION['login_user'])) {
                        ?>
                        
                         <a href="admin_status.php" class="nav-btn admin"><span class="glyphicon glyphicon-user"> </span>
                        <span class="badge bg-green">
                          <?php echo $a['total']; ?>
                         </span></a>
&nbsp;&nbsp;

                        <a href="message.php" class="nav-btn admin"><span class="glyphicon glyphicon-envelope"> </span>
                         <span class="badge bg-green">
                          <?php echo $c['total']; ?>
                         </span></a> &nbsp;&nbsp;
                            <a href="profile.php" class="nav-btn admin">
                                       
                           <?php
                           echo "<img class='img-circle profile_img' height=25 width=25 src='images/".$_SESSION['pic']." '>  ";
                           echo "  ". $_SESSION['login_user'] . "!";
                        ?>
                    
                        </a>
                      
                        &nbsp;&nbsp;
                    <a href="logout.php" class="nav-btn student"><span class="glyphicon glyphicon-log-out"> </span>Log out</a>

                    <?php
                      }
                      else {
                    ?>
                    <a href="../login.php" class="nav-btn admin"><span class="glyphicon glyphicon-log-in"> </span>  Login</a>
                    &nbsp;
                    
                    <?php
                      }
                    ?>
                </div>

                
            </nav>
            
        </header>
    <!-- </div> -->
     
</body>
</html>