<?php

     include "connection.php";
     include "navbar.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Books</title>
     <style type="text/css">



.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.book-card {
  position: relative;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.3s;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.book-card:hover {
  transform: scale(1.03);
}

.book-img img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.book-info {
  padding: 10px;
  font-size: 14px;
}

.overlay {
  position: absolute;
  top: 0; left: 100%;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.4s;
}

.book-card:hover .overlay {
  left: 0;
}

.overlay button {
  background: #ff9800;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  color: white;
  font-weight: bold;
  cursor: pointer;
}
.overlay button:hover {
  background: #e68900;
}



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

<!-- ___________________________Side Nav___________________________ -->

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

  <div class="h"> <a href="add.php">Add Books </a> </div>
  <!-- <div class="h"> <a href="delete.php">Delete Books</a> </div> -->
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

     <div class="sarch">
          <form class="navbar-form" action="" method="post" name="form1">

                    <input class="form-control" type="text" class="form-control" name="search" placeholder="Search for books..." required>
                    <button type="submit" name="submit" class="btn btn-default" style="background: #b8adad";> <span class="glyphicon glyphicon-search"></span> Search</button>

          </form>

           <form class="navbar-form" action="" method="post" name="form1">

                    <!-- <input class="form-control" type="text" class="form-control" name="bid" placeholder="Enter Book ID" required>
                    <button type="submit" name="submit1" class="btn btn-default" style="background: #b8adad";> <span class="glyphicon glyphicon-trash"></span> Delete </button> -->

          </form>


     </div>
     <h2> List of Books </h2>
     <?php

          // --------------- search query------------
if(isset($_POST['submit'])) {
    $q = mysqli_query($db, "SELECT * FROM books 
        WHERE names LIKE '%$_POST[search]%' 
        OR authors LIKE '%$_POST[search]%' 
        OR department LIKE '%$_POST[search]%'");

    if(mysqli_num_rows($q) == 0) {
        echo "Sorry, no results found for your search.";
    } else {
        echo "<div class='book-grid'>";
        while($row = mysqli_fetch_assoc($q)) {
            echo "
            <div class='book-card'>
                <div class='book-img'>
                    <img src='../images/".$row['image']."' alt='".$row['names']."'>
                </div>
                <div class='book-info'>
                    <h4>".$row['names']."</h4>
                    <p><b>Author:</b> ".$row['authors']."</p>
                    <p><b>Edition:</b> ".$row['edition']."</p>
                    <p><b>Dept:</b> ".$row['department']."</p>
                    <p><b>Status:</b> ".$row['status']." | <b>Qty:</b> ".$row['quantity']."</p>
                </div>
                <div class='overlay'>
                    <form method='post' action=''>
                        <input type='hidden' name='bid' value='".$row['bid']."'>
                        <button type='submit' name='submit1' class='btn btn-danger'>Delete</button>
                    </form>
                </div>
            </div>
            ";
        }
        echo "</div>";
    }
} else {
    $res = mysqli_query($db,"SELECT * FROM books");
    echo "<div class='book-grid'>";
    while($row = mysqli_fetch_assoc($res)) {
        echo "
        <div class='book-card'>
            <div class='book-img'>
                <img src='../images/".$row['image']."' alt='".$row['names']."'>
            </div>
            <div class='book-info'>
                <h4>".$row['names']."</h4>
                <p><b>Author:</b> ".$row['authors']."</p>
                <p><b>Edition:</b> ".$row['edition']."</p>
                <p><b>Dept:</b> ".$row['department']."</p>
                <p><b>Status:</b> ".$row['status']." | <b>Qty:</b> ".$row['quantity']."</p>
            </div>
            <div class='overlay'>
                <form method='post' action=''>
                    <input type='hidden' name='bid' value='".$row['bid']."'>
                    <button type='submit' name='submit1' class='btn btn-danger'>Delete</button>
                </form>
            </div>
        </div>
        ";
    }
    echo "</div>";
}

// ----------------- delete query -------------------
if(isset($_POST['submit1'])) {
     if(isset($_SESSION['login_user'])) {
   
          $delete_query = "DELETE FROM books WHERE bid='$_POST[bid]'";
          mysqli_query($db, $delete_query);
          ?>
             <script type="text/javascript">
Swal.fire({
    title: "Success!",
    text: "Book Deleted Successfully.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "request.php";
});
</script>
          <?php

               }
               else {
                    ?>
                    <script type="text/javascript">
Swal.fire({
    title: "Error!",
    text: "Please login to request a book.",
    icon: "error",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "../login.php";
});
</script>
                    <?php
               }
     } 

     ?>
     </div>
</body>
</html>