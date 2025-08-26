<?php
    include "navbar.php";
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Status</title>
<style type="text/css">
.sarch {
     text-align:right;
}

.h:hover { 
     width:100%;
     height:50px;
     background-color:#48968f;
     
}

body {
  font-family: "Lato", sans-serif;
  transition: background-color .5s;
}

.sidenav {
  height: 100%;
  margin-top: 100px; /* Adjusted to avoid overlap with navbar */
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #c19f9f;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color:#000000;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
     </style>

     
</head>
<body> 

<!-- ____________________________side __________________________________ -->


<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
     <div style="text-align: center; font-size:20px;">

          <?php
           if(isset($_SESSION['login_user'])) {
               echo "<img class='img-circle profile_img' height=100 width=100 src='images/".$_SESSION['pic']." '>  ";
               echo "<br> <br>";
               echo "Welcome,  ". $_SESSION['login_user'] . "!";
           }
               ?>
     </div>

<div class="h"> <a href="books.php"> Books </a> </div>
  <div class="h"> <a href="request.php">Book Request</a> </div>
  <div class="h"> <a href="issue_info.php">Issue Information</a> </div>
  <div class="h"> <a href="expired.php">Expired List</a> </div>
</div>

<div id="main">

  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
  document.getElementById("main").style.marginLeft = "300px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}
</script>


<!--____________________________search bar___________________________-->
<div class="container">
    <h2 style="float: left; ">Search one username at a time to approve the request </h2>
     <div style="float: right;" class="sarch">
          <form class="navbar-form" action="" method="post" name="form1">
<!-- <?php
// $firstUser = '';
// $pending = mysqli_query($db,"SELECT username FROM admin WHERE status='' LIMIT 1;");
// if(mysqli_num_rows($pending) > 0){
//     $row = mysqli_fetch_assoc($pending);
//     $firstUser = $row['username'];
// }

?> -->
<!-- <input type="hidden" name="search" value="<?php //echo $firstUser; ?>">
<input type="hidden" name="submit" value="1"> -->


                    <input class="form-control" type="text" class="form-control" name="search" placeholder="Search for Students..." required>
                    <button type="submit" name="submit" class="btn btn-default" style="background: #b8adad";> <span class="glyphicon glyphicon-search"></span> Search</button>

          </form>


     </div> <br><br><br>
     <h2> New Requests </h2>
     <?php
// SELECT `name`, `roll`, `dept`, `phone`, `email`, `username` FROM `student`
          // --------------- search query------------
     if(isset($_POST['submit'])) {
          // $q = $_POST['search'];
          $q = mysqli_query($db, "SELECT * FROM `admin` WHERE (username LIKE '%$_POST[search]%') and status='';");
               if( mysqli_num_rows($q) == 0) 
                    // If search query returns results, display them
                    echo "Sorry, no results found for your search.";
               else {
                     echo "<table class='table table-bordered table-hover' > ";
     echo "<tr style='background-color: #b8adad;'>";
     echo "<th>"; echo "Name"; echo "</th>"; 
     echo "<th>"; echo "Department"; echo "</th>"; 
     echo "<th>"; echo "Phone"; echo "</th>"; 
     echo "<th>"; echo "Email"; echo "</th>"; 
     echo "<th>"; echo "Username"; echo "</th>"; 
    //  echo "<th>"; echo "Department"; echo "</th>";
     echo "</tr>"; 

     while($row = mysqli_fetch_assoc($q)) {
          echo "<tr>";
          $_SESSION['test_name'] = $row['username'];
          echo "<td>"; echo $row['Name']; echo "</td>";
                  echo "<td>"; echo $row['dept']; echo "</td>";
          echo "<td>"; echo $row['phone']; echo "</td>";
          echo "<td>"; echo $row['email']; echo "</td>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "</tr>";
     }
     echo "</table>";
     ?>
<form action="" method="post">
     <button type="submit" name="submit1" class="btn btn-default" style="font-size: 16px; font-weight: 700;"> <span style="color: red;" class="glyphicon glyphicon-remove-sign"> Remove</span></button>

     <button type="submit" name="submit2" class="btn btn-default" style="font-size: 16px; font-weight: 700;"><span style="color: green;" class="glyphicon glyphicon-ok-sign"> Approve</span></button>

</form>
     <?php

      }
    }
else {


     $res=mysqli_query($db,"SELECT `Name`,  `dept`, `phone`, `email`, `username` FROM `admin` WHERE status='';");
     //table header
     echo "<table class='table table-bordered table-hover' > ";
     echo "<tr style='background-color: #b8adad;'>";
     echo "<th>"; echo "Name"; echo "</th>"; 
     echo "<th>"; echo "Department"; echo "</th>"; 
     echo "<th>"; echo "Phone"; echo "</th>"; 
     echo "<th>"; echo "Email"; echo "</th>"; 
     echo "<th>"; echo "Username"; echo "</th>"; 
    //  echo "<th>"; echo "Department"; echo "</th>";
     echo "</tr>";  

     while($row = mysqli_fetch_assoc($res)) {
           echo "<tr>";
          echo "<td>"; echo $row['Name']; echo "</td>";
          echo "<td>"; echo $row['dept']; echo "</td>";
          echo "<td>"; echo $row['phone']; echo "</td>";
          echo "<td>"; echo $row['email']; echo "</td>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "</tr>";
     }
     echo "</table>";
}
if(isset($_POST['submit1'])) {
          mysqli_query($db, "DELETE FROM `admin` WHERE username='$_SESSION[test_name]';");

     }
     if(isset($_POST['submit2'])) {
          // Handle approve action
        mysqli_query($db, "UPDATE `admin` SET status='Yes' WHERE username='$_SESSION[test_name]';");
        unset($_SESSION['test_name']);
     }
     ?>


</div>
</div>


<!-- <script type="text/javascript">

document.addEventListener("DOMContentLoaded", function() {
    var form = document.forms['form1'];

    // check if form already submitted
    // if (!sessionStorage.getItem('form1_submitted')) {
        HTMLFormElement.prototype.submit.call(form);
        // sessionStorage.setItem('form1_submitted', 'yes');
    // }
});


</script> -->


</body>
</html>