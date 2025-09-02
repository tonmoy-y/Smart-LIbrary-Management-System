<?php
     include "connection.php";
     include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Fine Calculation</title>
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
    
     <h2> List of Fines </h2>

     <?php
// SELECT `name`, `roll`, `dept`, `phone`, `email`, `username` FROM `student`
          // --------------- search query------------
     


  $res=mysqli_query($db,"SELECT * FROM `fine` WHERE username = '$_SESSION[login_user]' AND fine > 0 ORDER BY `returned` DESC;");
     //table header
     if(mysqli_num_rows($res)==0) {
          echo "<h2 style='text-align: center;'> There's no fine. </h2>";
     }
     else {
     echo "<table class='table table-bordered table-hover' > ";
     echo "<tr style='background-color: #b8adad;'>";
     echo "<th>"; echo "Username"; echo "</th>"; 
     echo "<th>"; echo "Book ID"; echo "</th>"; 
     echo "<th>"; echo "Return Date"; echo "</th>"; 
     echo "<th>"; echo "Days"; echo "</th>"; 
     echo "<th>"; echo "Fine"; echo "</th>"; 
     echo "<th>"; echo "Status"; echo "</th>"; 
    //  echo "<th>"; echo "Department"; echo "</th>";
     echo "</tr>";  

  while($row = mysqli_fetch_assoc($res)) {
    // Safety check: skip any rows where fine is 0 or less
    if ((float)$row['fine'] <= 0) { continue; }
           echo "<tr>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "<td>"; echo $row['bid']; echo "</td>";
          echo "<td>"; echo $row['returned']; echo "</td>";
          echo "<td>"; echo $row['days']; echo "</td>";
          echo "<td>"; echo $row['fine']; echo "</td>";
          echo "<td>"; echo $row['status']; echo "</td>";
          echo "</tr>";
     }
     echo "</table>";
    }
     ?>
</div>
</div>
</body>
</html>