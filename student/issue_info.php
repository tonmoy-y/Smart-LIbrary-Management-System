<?php

     include "connection.php";
     include "navbar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Request</title>
     <style type="text/css">
          .srch {
               text-align:right;

          }
.form-control {

    display: inline-block;
    margin-right: 10px;
    height:30px;
    /* background-color:#000000; */
    
}


body {
    background-image: url("images/issue.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    
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

.h:hover { 
     width:100%;
     height:50px;
     background-color:#48968f;
     
}

.container {
    height: 700px;
    background-color: black;
    opacity: 0.7;
    color: white;
}
.scroll {
    width: 100%;
    height: 550px;
    overflow-y: scroll;
}

th,td {
  width: 10%;
}
     </style>
</head>
<body>
    
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
     <div style="text-align: center; font-size:20px;">

          <?php
          
               if(isset($_SESSION['login_user'])) {
                     
                    echo "<img class='img-circle profile_img' height=100 width=100 src='../images/".$_SESSION['pic']." '>  ";
                    echo "<br> <br>";
                    echo "Welcome,  ". $_SESSION['login_user'] . "!";
               }
               ?>
     </div>

  <div class="h"> <a href="books"> Books </a> </div>
  <div class="h"> <a href="request">Book Request</a> </div>
  <div class="h"> <a href="issue_info">Issue Information</a> </div>
  <div class="h"> <a href="expired">Expired List</a> </div>
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



<div class="container">

<h2 style="text-align;"> Information of Borrowed Books</h2>
<?php
$c = 0;
if(isset($_SESSION['login_user'])) { 
    $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid WHERE issue_book.approve='Yes'  
           AND issue_book.username= '$_SESSION[login_user]' ORDER BY `issue_book`.`return` ASC";

    $res=mysqli_query($db,$sql);
if(mysqli_num_rows($res) == 0) {
    echo "<h3 style='text-align:center; color:white; margin-top:20px;'>You haven't borrowed any books.</h3>";
} else {
    echo "<table class='table table-bordered' style='width:98.5%;' > ";
    
    echo "<tr style='background-color: #b8adad;'>";
    echo "<th>"; echo "Username"; echo "</th>"; 
    echo "<th>"; echo "Roll"; echo "</th>"; 
    echo "<th>"; echo "Name"; echo "</th>"; 
    echo "<th>"; echo "Book ID"; echo "</th>"; 
    echo "<th>"; echo "Book Name"; echo "</th>"; 
    echo "<th>"; echo "Author/s Name"; echo "</th>";
    echo "<th>"; echo "Edition"; echo "</th>";
    echo "<th>"; echo "Issue Date"; echo "</th>";
    echo "<th>"; echo "Return Date"; echo "</th>";
    echo "</tr>"; 
    echo "</table>";

    echo "<div class='scroll'>";
    echo "<table class='table table-bordered ' > ";
        while($row = mysqli_fetch_assoc($res)) {
          $d = date("Y-m-d");
          if($d > $row['return']) {
              $c=$c+1;
              $var= '<p style="color:yellow; background-color: red;"> EXPIRED </p>';
              $sql1 = "UPDATE issue_book SET approve='$var' WHERE `return` = '$row[return]' AND approve='Yes' limit $c";
              mysqli_query($db, $sql1);
              
              echo $d."<br>";
            }
            echo "<tr>";
            echo "<td>"; echo $row['username']; echo "</td>";
            echo "<td>"; echo $row['roll']; echo "</td>";
            echo "<td>"; echo $row['name']; echo "</td>";
            echo "<td>"; echo $row['bid']; echo "</td>";
            echo "<td>"; echo $row['names']; echo "</td>";
            echo "<td>"; echo $row['authors']; echo "</td>";
            echo "<td>"; echo $row['edition']; echo "</td>";
            echo "<td>"; echo $row['issue']; echo "</td>";
            echo "<td>"; echo $row['return']; echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
      echo "</div>";
      }
}
else {
    echo "<h3 style='text-align:center;'> <b>";
    echo "Please Login First";
    echo "</h3> </b>";
}
?>

</div>


</div>
</body>
</html>