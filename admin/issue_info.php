<?php

     include "connection.php";
     include "navbar.php";

// Handle return action (minimal, reuses existing logic pattern)
if(isset($_POST['return_submit'])){
  $uname = mysqli_real_escape_string($db, $_POST['username']);
  $bid = mysqli_real_escape_string($db, $_POST['bid']);
  // calculate fine based on issue_book return date
  $resx = mysqli_query($db, "SELECT * FROM issue_book WHERE username='$uname' AND bid='$bid' LIMIT 1");
  $day = 0; $fine = 0;
  if($rx = mysqli_fetch_assoc($resx)){
    $d = strtotime($rx['return']);
    $c = strtotime(date("Y-m-d"));
    $diff = $c - $d;
    if($diff > 0){
      $day = floor($diff / (60 * 60 * 24));
      $fine = $day * .10;
    }
  }
  $x = date("Y-m-d");
  // insert fine record
  mysqli_query($db, "INSERT INTO `fine` VALUES ('', '".mysqli_real_escape_string($db,$uname)."', '".mysqli_real_escape_string($db,$bid)."', '$x', '$day', '$fine', 'Not Paid')");
  // mark returned
  $var1= '<p style="color:yellow; background-color: green;"> RETURNED </p>';
  $sql1 = "UPDATE issue_book SET approve='$var1' WHERE username='".mysqli_real_escape_string($db,$uname)."' AND bid='".mysqli_real_escape_string($db,$bid)."'";
  mysqli_query($db, $sql1);
  // overwrite the stored return date with the actual return date
  mysqli_query($db, "UPDATE issue_book SET `return` = '$x' WHERE username='".mysqli_real_escape_string($db,$uname)."' AND bid='".mysqli_real_escape_string($db,$bid)."'");
  // increase book quantity
  mysqli_query($db, "UPDATE books SET quantity = quantity+ 1 WHERE bid='".mysqli_real_escape_string($db,$bid)."'");
  // redirect to avoid repost
  echo "<script>window.location='issue_info.php'</script>";
  exit;
}

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
    height: 550px;
    background-color: black;
    opacity: 0.7;
    color: white;
}
.scroll {
    width: 100%;
    height: 350px;
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
<br><br>
<!-- top-right search and send-email controls -->
<div style="overflow: hidden;">
  <div class="srch" style="float: right; margin-bottom: 8px;">
    <form action="" method="post" class="form-inline" style="display:inline-block;">
      <input type="text" name="search" class="form-control" placeholder="username or student name" value="<?php if(isset($_POST['search'])) echo htmlspecialchars($_POST['search']); ?>" required>
      <button class="btn btn-primary" type="submit" name="search_submit" style="background-color:#b8adad; border-color:#b8adad; color:#000;">Search</button>
      <button class="btn btn-default" type="submit" name="clear_search" title="Clear search">Reset</button>
    </form>

    <form action="" method="post" style="display:inline-block; margin-left:8px;">
      <button class="btn btn-default" name="submit_m" type="submit">Send Email</button>
    </form>
  </div>
</div>

<h2 style="text-align;"> Information of Borrowed Books</h2>
<?php
$c = 0;
// build base query for borrowed books
$search_term = '';
if(isset($_POST['clear_search'])){
  // clearing search - unset the POST value so later code shows all
  unset($_POST['search']);
}
if(isset($_POST['search_submit']) && !empty(trim($_POST['search']))) {
  $search_term = mysqli_real_escape_string($db, trim($_POST['search']));
}

$sql = "SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors, books.edition, issue_book.issue, issue_book.return, issue_book.approve FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid WHERE issue_book.approve='Yes'";
if($search_term !== ''){
  // match username or student name
  $sql .= " AND (student.username LIKE '%$search_term%' OR student.name LIKE '%$search_term%')";
}
$sql .= " ORDER BY `issue_book`.`return` ASC";

$res = mysqli_query($db, $sql);

  // if no rows, show message and don't render table headers
  if(mysqli_num_rows($res) == 0) {
    if($search_term !== ''){
      echo "<h3 style='text-align:center; margin-top:40px;'>No borrowed books match '".htmlspecialchars($search_term)."'</h3>";
    } else {
      echo "<h3 style='text-align:center; margin-top:40px;'>No one has borrowed books</h3>";
    }
  } else {
  // use a single table so columns align
  echo "<div class='scroll'>";
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
  echo "<th>"; echo "Action"; echo "</th>";
  echo "</tr>";
  while($row = mysqli_fetch_assoc($res)) {
          $d = date("Y-m-d");
            if($d > $row['return']) {
              $c=$c+1;
              $var= '<p style="color:yellow; background-color: red;"> EXPIRED </p>';
              $sql1 = "UPDATE issue_book SET approve='$var' WHERE `return` = '$row[return]' AND approve='Yes' limit $c";
              mysqli_query($db, $sql1);
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
            // action: show Return button if not already returned
            $approve_val = strtoupper($row['approve']);
            echo "<td>";
            if(strpos($approve_val, 'RETURNED') === false) {
                echo "<form method='post' style='margin:0'>";
                echo "<input type='hidden' name='username' value='".htmlspecialchars($row['username'])."'>";
                echo "<input type='hidden' name='bid' value='".htmlspecialchars($row['bid'])."'>";
                echo "<button type='submit' name='return_submit' class='btn btn-warning btn-sm'>Return</button>";
                echo "</form>";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
      echo "</div>";
  }


if(isset($_POST['submit_m'])) {
    $t=mysqli_query($db,"SELECT * FROM `issue_book` WHERE `approve`='Yes'");
    $date2=date_create(date("Y-m-d"));
    
    
    while($row=mysqli_fetch_assoc($t)){
      $date3=date_create($row['return']);
      $diff=date_diff($date2,$date3);
      $day= $diff->format("%a");
      if($day <= 2) {
          // Code to send email
          $name_m=$row['username'];
          $bid_m=$row['bid'];
          $sql_m=mysqli_query($db,"SELECT * FROM `student` WHERE `username`='$name_m'");
          $to=mysqli_fetch_assoc($sql_m);
          $sql_b=mysqli_query($db,"SELECT * FROM `books` WHERE `bid`='$bid_m'");
          $book=mysqli_fetch_assoc($sql_b);
          $subject = "Book Return Reminder";
          $message = "Dear ".$to['name'].",\n\nThis is a reminder to return the book '".$book['names']."' (Book ID: $bid_m) by the due date: ".$row['return'].".\n\nThank you!\n\n\n@online library management system";
          $from = "From: tonmoy4451@gmail.com";

          if(mail($to['email'], $subject, $message, $from)) {
              ?>
              <script type="text/javascript">
                  alert("Email sent Successfully");
              </script>
              <?php
          } else {
              ?>
              <script type="text/javascript">
                  alert("Failed to send email.");
              </script>
              <?php
          } 
      }
    }
}
?>

</div>


</div>
</body>
</html>