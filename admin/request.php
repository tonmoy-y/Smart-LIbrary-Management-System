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
    background-image: url("images/br.png");
    background-size: cover;
    background-repeat: no-repeat;
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
    height: 600px;
    background-color: black;
    opacity: 0.7;
    color: white;
}

     </style>
</head>
<body>
    
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
<div class="container">
    
    <div class="srch">
        <form class="navbar-form" action="" method="post" name="form1">
            
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="text" name="bid" class="form-control" placeholder="by Book ID" required>
            <button type="submit" name="submit" class="btn btn-default">Submit</button>
            
        </form>
        
    </div>
    
    <br>
   
    <h3 style="text-align:center;" > Request of Books</h3>
    <br>
   <?php
if(isset($_SESSION['login_user'])) { 
    $sql ="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition, books.status FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid WHERE issue_book.approve=''";
    $res=mysqli_query($db,$sql);
    
    if( mysqli_num_rows($res) == 0) {                    
        echo "<h2 style='text-align:center;'> <b>";
        echo "Threre is no pending request";
        echo "</h2> </b>";
    }
    
    else {
        echo "<table class='table table-bordered ' > ";
        echo "<tr style='background-color: #b8adad;'>";
        echo "<th>"; echo "Username"; echo "</th>"; 
        echo "<th>"; echo "Roll"; echo "</th>"; 
        echo "<th>"; echo "Name"; echo "</th>"; 
        echo "<th>"; echo "Book ID"; echo "</th>"; 
        echo "<th>"; echo "Book Name"; echo "</th>"; 
        echo "<th>"; echo "Author/s Name"; echo "</th>";
        echo "<th>"; echo "Edition"; echo "</th>";
        echo "<th>"; echo "Status"; echo "</th>";
        echo "</tr>"; 
        
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>"; echo $row['username']; echo "</td>";
            echo "<td>"; echo $row['roll']; echo "</td>";
            echo "<td>"; echo $row['name']; echo "</td>";
            echo "<td>"; echo $row['bid']; echo "</td>";
            echo "<td>"; echo $row['names']; echo "</td>";
            echo "<td>"; echo $row['authors']; echo "</td>";
            echo "<td>"; echo $row['edition']; echo "</td>";
            echo "<td>"; echo $row['status']; echo "</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }
}
else {
    ?>
    <script type="text/javascript">
        alert("Please log in to view your book requests.");
        window.location.href = "admin_login.php"; // Redirect to login page
        
        </script>

<?php
}

/*
if(isset($_SESSION['login_user'])) {
    
$q = mysqli_query($db, "SELECT * FROM issue_book WHERE username LIKE '$_SESSION[login_user]';");
if( mysqli_num_rows($q) == 0) {                    
    echo "<h2> <b>";
    echo "Threre is no pending request";
    echo "</h2> </b>";
    }
    else {
        echo "<table class='table table-bordered table-hover' > ";
    echo "<tr style='background-color: #b8adad;'>";
    echo "<th>"; echo "Book ID"; echo "</th>"; 
    echo "<th>"; echo "Approve Stuatus"; echo "</th>"; 
    echo "<th>"; echo "Issue  Date"; echo "</th>"; 
    echo "<th>"; echo "Return date"; echo "</th>"; 
    echo "</tr>"; 
    
    while($row = mysqli_fetch_assoc($q)) {
        echo "<tr>";
        echo "<td>"; echo $row['bid']; echo "</td>";
        echo "<td>"; echo $row['approve']; echo "</td>";
        echo "<td>"; echo $row['issue']; echo "</td>";
        echo "<td>"; echo $row['return']; echo "</td>";
        
        echo "</tr>";
        }
        echo "</table>";
        }
        }
        else {
            echo "<h2>Please log in to view your book requests.</h2>";
    }
    */
    
    if(isset($_POST['submit'])) {
        $_SESSION['st_name'] = $_POST['username'];
        $_SESSION['bid'] = $_POST['bid'];
        ?>

<script type="text/javascript">
    window.location = "approve.php"; 
    </script>
    <?php
}



?>
</div>
</div>

</body>
</html>l