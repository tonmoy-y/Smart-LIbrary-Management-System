<?php

     include "connection.php";
     include "navbar.php";
if(!isset($_SESSION['login_user'])) {
    echo "<script>alert('Please log in first!'); window.location='student_login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Request</title>
     <style type="text/css">
          .sarch {
               text-align:right;
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

.h:hover { 
     width:100%;
     height:50px;
     background-color:#48968f;
     
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
  <div class="h"> <a href="expired.php">Expired Books</a> </div>
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
  <br>
  <?php

  // $q = $_POST['search'];
  $q = mysqli_query($db, "SELECT * FROM issue_book WHERE username = '$_SESSION[login_user]' AND approve='' ");
  if( mysqli_num_rows($q) == 0) 
  // If search query returns results, display them
echo "<h2 style='text-align:center;'> Threre is no book request from you. </h3>";
else {
?>


<form method="post">

<?php
  echo "<table class='table table-bordered table-hover' > ";
  echo "<tr style='background-color: #b8adad;'>";
  //table header
    
  echo "<th>"; echo "Select"; echo "</th>"; 
  echo "<th>"; echo "Book ID"; echo "</th>"; 
  echo "<th>"; echo "Approve Status"; echo "</th>"; 
  echo "<th>"; echo "Issue  Date"; echo "</th>"; 
  echo "<th>"; echo "Return date"; echo "</th>"; 
  echo "</tr>"; 
  
  while($row = mysqli_fetch_assoc($q)) {
    echo "<tr>";
    ?>
<td> <input type="checkbox" name="check[]" value="<?php echo $row['bid']; ?>" > </td>

<?php
    echo "<td>"; echo $row['bid']; echo "</td>";
    echo "<td>"; echo $row['approve']; echo "</td>";
    echo "<td>"; echo $row['issue']; echo "</td>";
    echo "<td>"; echo $row['return']; echo "</td>";
    
    echo "</tr>";
  }
  echo "</table>";
  ?>
  <p><button type="submit" name="delete" class="btn btn-success">Delete Request  </button></p>
<?php
}
?>
<?php
if(isset($_POST['delete'])) {
    if(!empty($_POST['check'])) {
        foreach($_POST['check'] as $value) {
            $query = "DELETE FROM issue_book WHERE bid='$value' AND username='$_SESSION[login_user]' ORDER BY bid ASC LIMIT 1;";
            mysqli_query($db, $query);
        }
        ?>
        
       <script type="text/javascript">
           Swal.fire({
  title: "Deleted!",
  text: "Your request has been deleted successfully.",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#589cdbff"
}).then(() => {
            window.location = "request.php";
        });
        </script>

        <?php
    } else {
      ?>
       
       <script type="text/javascript">
           Swal.fire({
  title: "Error!",
  text: "Please select at least one request to delete.",
  icon: "error",
  confirmButtonText: "OK",
  confirmButtonColor: "#589cdbff"
}).then(() => {
            window.location = "request.php";
        });
        </script>

        <?php
    }
}

?>
</div>
</div>

</body>
</html>l