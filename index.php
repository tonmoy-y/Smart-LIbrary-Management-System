<?php
     include "navbar.php";
    // session_start();

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

<!-- <header> -->
    
         <!-- <a href="index.php">
                <img src="images/logo.png" alt="Library Logo" class="logo">
    
                <p class="logofont">Online Library Management System</p>
                </a>


    <?php
    //  if(isset($_SESSION['login_user'])) {
        ?>
         <nav class="navbar">
                <a href="index.php" class="nav-btn home">Home</a>
                <a href="books.php" class="nav-btn books">Books</a>
                <a href="contact.php" class="nav-btn feedback">Feedback</a>
                <div class="nav navbar-nav navbar-right">
                    <a href="logout.php" class="nav-btn student"><span class="glyphicon glyphicon-log-in"> </span>  Log out</a>
                    <!-- <a href="admin.php" class="nav-btn admin"> </a> -->
                <!-- </div>
            </nav> -->
            <!-- <?php
    //  }
    
    // else {
        ?> -->
                <!-- <nav class="navbar">
                <a href="index.php" class="nav-btn home">Home</a>
                <a href="books.php" class="nav-btn books">Books</a>
                <a href="contact.php" class="nav-btn feedback">Feedback</a>
                <div class="nav navbar-nav navbar-right">
                    <a href="student_login.php" class="nav-btn student"><span class="glyphicon glyphicon-log-in"> </span>  Student Login</a>
                    <a href="admin.php" class="nav-btn admin">Admin Login</a>
                </div>
            </nav> -->
        <!-- <?php
    // } -->
    ?> -->
<!-- </header> -->
    <div class="wrapper">
        <section class="sec_img"> 

            <!-- <div class="w3-content w3-section" style="width: 800px;">
                <img class="mySlides w3-animate-left" src="images/a.jpg" alt="" style="width: 100%;">
                <img class="mySlides w3-animate-left" src="images/b.jpg" alt="" style="width: 100%;">
                <img class="mySlides  w3-animate-fading" src="images/c.jpg" alt="" style="width: 100%;">
                <img class="mySlides  w3-animate-fading" src="images/d.jpg" alt="" style="width: 100%;">
                <img class="mySlides " src="images/e.jpg" alt="" style="width: 100%;">
            </div> 
        <script type="text/JavaScript"> 
            var a =0;
            carousel();
        
            function carousel() {
                var i;
                var x = document.getElementsByClassName("mySlides");
                for(i=0;i<x.length;i++) {
                    x[i].style.display = "none";  
                }
                a++; 
                if (a> x.length) {a = 1}
                    
                  x[a-1].style.display = "block";
                  setTimeout(carousel, 5000); // Change image every 2 seconds
            } 
        </script> -->

            <br> <br> <br> 
            <div class="box">
                <br> 
                <h1 style="text-align: center; font-size: 35px;"> Welcome to the Library </h1> <br>
                <h1 style="text-align: center; font-size: 25px" > Opens at: 09:00 </h1> <br>                                            
                <h1 style="text-align: center; font-size: 25px"> Closes at: 17:00 </h1> <br>
            </div>
        </section>
        
        
    </div>

    <?php
        include "footer.php";
    ?>

    <!-- index.html -->
<script>
// 3 minute পরে session destroy
setTimeout(() => fetch('student/session_destroy.php'), 180000);
setTimeout(() => fetch('admin/session_destroy.php'), 180000);

</script>

</body>
</html>