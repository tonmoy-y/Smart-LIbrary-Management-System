<?php

     include "connection.php";
     include "navbar.php";
        if (isset($_SESSION['student_reset'])) {
         unset($_SESSION['student_reset']);
        unset($_SESSION['student_reset_time']);
        echo "<script>window.location = '../books';</script>";
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Books</title>
     <style type="text/css">

/* book cart */


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
  height: 300px; /* increased from 200px */
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





/* end of book cart */

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
                     
                    echo "<img class='img-circle profile_img' height=100 width=100 src='../images/".htmlspecialchars($_SESSION['pic'])." '>  ";
                    echo "<br> <br>";
                    echo "Welcome,  ". htmlspecialchars($_SESSION['login_user']) . "!";
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



<!--____________________________search bar___________________________-->

     <div class="sarch">
          <form class="navbar-form" action="" method="post" name="form1">

                    <input class="form-control" type="text" class="form-control" name="search" placeholder="Search for books..." required>
                    <button type="submit" name="submit" class="btn btn-default" style="background: #b8adad";> <span class="glyphicon glyphicon-search"></span> Search</button>

          </form>
     </div>

     <!-- _______________________________request boook _________________________________ -->
    
     <div class="sarch">
          <form class="navbar-form" action="" method="post" name="form1">

               <!-- 
          <input class="form-control" type="text" class="form-control" name="bid" placeholder="Enter Book ID to Request book" required>
               <button type="submit" name="submit1" class="btn btn-default" style="background: #b8adad";>  Request </button>
                -->

          </form>
     </div>
     <h2> List of Books </h2>
     <?php

          // --------------- search query------------
    if(isset($_POST['submit'])) {
    $searchTerm = "%".$_POST['search']."%";
    $stmt = mysqli_prepare($db, "SELECT * FROM books
        WHERE names LIKE ?
        OR authors LIKE ?
        OR department LIKE ?");
    mysqli_stmt_bind_param($stmt, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $q = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($q) == 0) {
        echo "Sorry, no results found for your search.";
    }
    else {
        echo "<div class='book-grid'>";
        while($row = mysqli_fetch_assoc($q)) {
            echo "
            <div class='book-card'>
                <div class='book-img'>
                    <img src='../images/".$row['image']."' alt='".$row['names']."'>
                </div>
                <div class='book-info'>
                    <h4>".$row['names']."</h4>
                    <p><b>Edition:</b> ".$row['edition']."</p>
                    <p><b>Author:</b> ".$row['authors']."</p>
                    <p><b>Dept:</b> ".$row['department']."</p>
                    <p><b>Status:</b> ".$row['status']." | <b>Qty:</b> ".$row['quantity']."</p>
                </div>
                <div class='overlay'>
                    <form method='post' action=''>
                        <input type='hidden' name='bid' value='".$row['bid']."'>
                        <button type='submit' name='submit1' class='btn btn-primary'>Request</button>
                    </form>
                </div>
            </div>
            ";
        }
        echo "</div>";
    }
}
// --------------- end of search query------------

else {


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
            <p><b>Edition:</b> ".$row['edition']."</p>
            <p><b>Author:</b> ".$row['authors']."</p>
            <p><b>Dept:</b> ".$row['department']."</p>
            <p><b>Status:</b> ".$row['status']." | <b>Qty:</b> ".$row['quantity']."</p>
        </div>
        <div class='overlay'>
            <form method='post' action=''>
                <input type='hidden' name='bid' value='".$row['bid']."'>
                <button type='submit' name='submit1' class='btn btn-primary'>Request</button>
            </form>
        </div>
    </div>
    ";
}
echo "</div>";
}

if(isset($_POST['submit1'])) {
     if(isset($_SESSION['login_user'])) {
          $stmt1 = mysqli_prepare($db, "SELECT * FROM books WHERE bid = ?");
          mysqli_stmt_bind_param($stmt1, "s", $_POST['bid']);
          mysqli_stmt_execute($stmt1);
          $sql1 = mysqli_stmt_get_result($stmt1);
          $row1=mysqli_fetch_assoc($sql1);
          $count1= mysqli_num_rows($sql1);
          if  ($count1!=0) {


             // check if book available or not
    if($row1['quantity'] <= 0 || strtolower($row1['status']) == 'not available') {
        ?>
        <script type="text/javascript">
        Swal.fire({
            title: "Unavailable!",
            text: "This book is not available right now.",
            icon: "error",
            confirmButtonText: "OK",
            confirmButtonColor: "#589cdbff"
        }).then(() => {
            window.location = "books";
        });
        </script>
        <?php
        exit();
    }



$checkStmt = mysqli_prepare($db, "SELECT * FROM issue_book WHERE username=? AND bid=? AND (approve ='Pending' OR approve='Yes')");
mysqli_stmt_bind_param($checkStmt, "ss", $_SESSION['login_user'], $_POST['bid']);
mysqli_stmt_execute($checkStmt);
$check = mysqli_stmt_get_result($checkStmt);
if(mysqli_num_rows($check) > 0) {
//     $rowCheck = mysqli_fetch_assoc($check);
//     if($rowCheck['approve'] == '') {
        ?>
        
        <script type="text/javascript">
Swal.fire({
    title: "Warning!",
    text: "You  already  have or requested this book.",
    icon: "warning",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "books";
});
</script>
        <?php
        exit();
//     }
}


          $insStmt = mysqli_prepare($db, "INSERT INTO issue_book VALUES (?,?,?,?,?)");
          $emptyStr = '';
          $pendingStatus = 'Pending';
          mysqli_stmt_bind_param($insStmt, "sssss", $_SESSION['login_user'], $_POST['bid'], $emptyStr, $emptyStr, $pendingStatus);
          mysqli_stmt_execute($insStmt);
         ?>
          <script type="text/javascript">
Swal.fire({
    title: "Success!",
    text: "Book request has been sent successfully.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "request";
});
</script>

<?php
          }
          else {
                     ?>
          <script type="text/javascript">
Swal.fire({
    title: "Error!",
    text: "The book is not listed in library.",
    icon: "error",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "books";
});
</script>
<?php
          }
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
    window.location = "../login";
});
</script>

<?php

     }
}
     ?>
     </div>
</body>
</html>