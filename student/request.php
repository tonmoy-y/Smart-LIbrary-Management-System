<?php

     include "connection.php";
     include "navbar.php";
if(!isset($_SESSION['login_user'])) {
    echo "<script>alert('Please log in first!'); window.location='student_login';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Request</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

/* Request table layout tweaks */
.table-req { table-layout: fixed; width: 100%; }
.table-req th, .table-req td { vertical-align: middle; }
.table-req th.select-col, .table-req td.select-col { width: 60px; text-align: center; }
.table-req th.bid-col, .table-req td.bid-col { width: 100px; }
.table-req th.name-col, .table-req td.name-col { width: 35%; }
.table-req th.status-col, .table-req td.status-col { width: 160px; }
.table-req th.issue-col, .table-req td.issue-col { width: 140px; }
.table-req th.return-col, .table-req td.return-col { width: 140px; }
.table-req input[type="checkbox"] { margin: 0; vertical-align: middle; }

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
  <div class="h"> <a href="expired">Expired Books</a> </div>
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
  $q = mysqli_query($db, "SELECT ib.*, b.names FROM issue_book ib LEFT JOIN books b ON b.bid = ib.bid WHERE ib.username = '$_SESSION[login_user]' AND ib.approve='Pending' ");
  if( mysqli_num_rows($q) == 0) 
  // If search query returns results, display them
echo "<h2 style='text-align:center;'> There is no book request from you. </h2>";
else {
?>


<form method="post">

<?php
  echo "<table class='table table-bordered table-hover table-req'> ";
  echo "<tr style='background-color: #b8adad;'>";
  //table header
    
  echo "<th class='select-col'>Select</th>"; 
  echo "<th class='bid-col'>Book ID</th>"; 
  echo "<th class='name-col'>Book Name</th>"; 
  echo "<th class='status-col'>Approve Status</th>"; 
  echo "<th class='issue-col'>Issue Date</th>"; 
  echo "<th class='return-col'>Return Date</th>"; 
  echo "</tr>"; 
  
  while($row = mysqli_fetch_assoc($q)) {
    echo "<tr>";
    ?>
<td class="select-col"><input type="checkbox" name="check[]" value="<?php echo $row['bid']; ?>"></td>

<?php
    echo "<td class='bid-col'>"; echo $row['bid']; echo "</td>";
    echo "<td class='name-col'>"; echo isset($row['names']) ? $row['names'] : ''; echo "</td>";
    echo "<td class='status-col'>"; echo $row['approve']; echo "</td>";
    echo "<td class='issue-col'>"; echo $row['issue']; echo "</td>";
    echo "<td class='return-col'>"; echo $row['return']; echo "</td>";
    
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
            window.location = "request";
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
            window.location = "request";
        });
        </script>

        <?php
    }
}

?>
</div>
</div>

</body>
</html>