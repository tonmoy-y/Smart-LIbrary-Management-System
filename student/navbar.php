<?php
 include "connection.php";
session_start();
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

<style>
.timer-box {
    display: inline-block;
    background: linear-gradient(90deg, #ffecd2 0%, #fcb69f 100%);
    color: #333;
    font-weight: bold;
    font-size: 15px;
    border-radius: 25px;
    padding: 10px 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    margin-right: 15px;
    letter-spacing: 2px;
    border: 2px solid #fcb69f;
    transition: background 0.3s, color 0.3s;
}
.timer-box.expired {
    background: #ff4e50;
    color: #fff;
    border-color: #ff4e50;
}
</style>

</head>
<body>
    <!-- <div class="wrapper"> -->
<?php
if(isset($_SESSION['login_user'])) {
  $r=mysqli_query($db, "SELECT COUNT(status) AS total FROM `message` WHERE sender='admin' AND status='no' AND username='$_SESSION[login_user]';");
  $c=mysqli_fetch_assoc($r);

  //timer---------------------------
  $b= mysqli_query($db, "SELECT * FROM `issue_book` WHERE username='$_SESSION[login_user]' AND approve='Yes' ORDER BY `return` ASC limit 0,1;");
  $bid = mysqli_fetch_assoc($b);
  $re = null;
  if ($bid && isset($bid['bid'])) {
    $t = mysqli_query($db, "SELECT * FROM timer WHERE `name`= '$_SESSION[login_user]' AND bid = '{$bid['bid']}';");
    $re = mysqli_fetch_assoc($t);
  }
  
}
?>
        <header>
            <a href="index.php">
            <img src="images/logo.png" alt="Library Logo" class="logo">

            <p class="logofont">Online Library Management System</p>
            </a>
            <nav class="navbar">
              
<!-- -------------------------------------Timer ------------------------------->
<script>
              // Set the date we're counting down to
              var countDownDate = new Date("<?php echo $re['tm']; ?>").getTime();
              
              // Update the count down every 1 second
              var x = setInterval(function() {
              
              // Get today's date and time
              var now = new Date().getTime();
              
              // Find the distance between now and the count down date
              var distance = countDownDate - now;
              
              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
              
              // Display the result in the element with id="demo"
              var demoElem = document.getElementById("demo");
              demoElem.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

if (distance < 0) {
    clearInterval(x);
    demoElem.innerHTML = "EXPIRED";
    demoElem.classList.add("expired");
} else {
    demoElem.classList.remove("expired");
}
              
              // If the count down is finished, write some text
              if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
              }
              }, 1000);
 </script>                             
                                    
 <!-- -----------------------------------------------------------------------------  -->
              
           <a href="index.php" class="nav-btn home">Home</a>
             <a href="books.php" class="nav-btn books">Books</a>
            <a href="contact.php" class="nav-btn feedback">Feedback</a>
                <?php
                if(isset($_SESSION['login_user'])) {
                        ?>
                <a href="fine.php" class="nav-btn books"> Fines </a> 
                
                <?php
                      }
                      ?>

<div class="rightend ">
  <?php
                      if(isset($_SESSION['login_user'])) {
                        ?>  
                        <a> <span id="demo" class="timer-box"></span> </a>
                        <a href="message.php" class="nav-btn admin"><span class="glyphicon glyphicon-envelope"> </span>
                         <span class="badge bg-green">
                          <?php echo $c['total']; ?>
                         </span></a> &nbsp;&nbsp;
                        <a href="profile.php" class="nav-btn admin">
                                 
                        <?php  
                          echo "<img class='img-circle profile_img' height=25 width=25 src='images/".$_SESSION['pic']." '>  ";
                          echo " " . $_SESSION['login_user'] . "!";
                        ?>
                    
                        </a>
                        &nbsp;&nbsp;
                    <a href="logout.php" class="nav-btn student"><span class="glyphicon glyphicon-log-out"> </span>Log out</a>

                    <?php
                      }
                      else {
                    ?>
                    <a href="../login.php" class="nav-btn student"><span class="glyphicon glyphicon-log-in"> </span>  Student Login</a>
           
                    <?php
                      }
                    ?>
                </div>
            </nav>
            
    <?php
    if(isset($_SESSION['login_user'])) {
      $day=0;
        $exp= '<p style="color:yellow; background-color: red;"> EXPIRED </p>';

        $res = mysqli_query($db, "SELECT `return` from issue_book WHERE username='$_SESSION[login_user]' AND approve = '$exp';");
        while($row = mysqli_fetch_assoc($res)) {
            $d = strtotime($row['return']);
            $c = strtotime(date("Y-m-d"));
            $diff = $c - $d;
            if($diff > 0) {
              $day = $day + floor($diff / (60 * 60 * 24)); // Convert seconds to days
             
            }
          }
           $_SESSION['fine'] = $day*.10;
           // echo $day."<br>";

    } else {
        
    }
    ?>
        </header>
    <!-- </div> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
</body>
</html>