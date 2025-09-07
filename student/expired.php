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
                display: flex;
                flex-direction: column; 
                align-items: flex-end; 

          }

.form-control {
    
    margin: 20px 0;
    width: 250px;
    
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
  padding-left: 0px;
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
  min-height: 600px;
  background-color: black;
  opacity: 0.7;
  color: white;
  margin-top:-45px;
  padding: 10px;
}
.scroll {
    width: 100%;
    height: 600px;
    overflow-y: scroll;
}

th,td { width: 10%; }

/* Mobile-only fixes */
@media (max-width: 576px) {
  #main { padding-right: 10px; }
  /* Make the open control align to the right and not overlap */
  #main > span[onclick] { display: inline-block; margin: 10px 0; }
  .container { margin-top: 10px; padding: 10px; }
  /* Top controls stack: Returned, Expired, fine info */
  .container .controls { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; justify-content: space-between; }
  .container .controls .left, .container .controls .right { width: 100%; }
  .container .controls .left button { width: 49%; min-width: 120px; }
  .container .controls .right h2 { font-size: 16px; margin: 8px 0 0; }
  /* Tables fit screen */
  table { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
  table th, table td { white-space: nowrap; }
  .scroll { height: auto; max-height: 60vh; }
  /* Side nav width smaller on phones */
  .sidenav { width: 0; }
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

  <span style="font-size:30px;cursor:pointer; float:right;" onclick="openNav()">&#9776; open</span>


<script>
function openNav() {
  var w = Math.min(window.innerWidth || 300, 280);
  document.getElementById("mySidenav").style.width = w + "px";
  document.getElementById("main").style.marginLeft = w + "px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}
</script>

<div class="container">

  <?php
  if(isset($_SESSION['login_user'])) {
    ?>
    <div class="controls">
      <div class="left">
        <form action="" method="post" name="form2" style="display:inline-block;">
          <button name="submit2" type="submit" class="btn btn-default" style="background-color:green; color:yellow;"> Returned </button>
          <button name="submit3" type="submit" class="btn btn-default" style="background-color:red; color:yellow; margin-left:8px;"> Expired </button>
        </form>
      </div>
      <div class="right">

    <?php
    $var2=0;
    $result = mysqli_query($db,"SELECT * FROM `fine` WHERE username='$_SESSION[login_user]'AND `status`= 'Not Paid' ;");
    while($r = mysqli_fetch_assoc($result)) {
      $var2  = $var2 + $r['fine'];
    }

    $var3= $var2 + $_SESSION['fine'];

    ?>
        <h2>Your fine is 
          <?php echo "$".$var3 ?>
        </h2>
      </div>
    </div>

<br><br><br>
    <?php

     if(isset($_POST['submit'])) {
      $var1= '<p style="color:yellow; background-color: green;"> RETURNED </p>';
      $sql1 = "UPDATE issue_book SET approve='$var1' WHERE username='$_POST[username]' AND bid='$_POST[bid]'";
      mysqli_query($db, $sql1);

      mysqli_query($db, "UPDATE books SET quantity = quantity+ 1 WHERE bid='$_POST[bid]'");
     }
  }
  ?>
<!-- <h2 style="text-align:center;"> Date expired list </h2> -->
<?php
$c = 0;
if(isset($_SESSION['login_user'])) { 

  $ret= '<p style="color:yellow; background-color: green;"> RETURNED </p>';
  $exp= '<p style="color:yellow; background-color: red;"> EXPIRED </p>';
   
    if(isset($_POST['submit2'])) {
    $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition,approve, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid 
      WHERE issue_book.approve ='$ret'  AND student.username='$_SESSION[login_user]' 
      ORDER BY `issue_book`.`return` DESC";
            $res=mysqli_query($db,$sql);
    }

    else if(isset($_POST['submit3'])) {
    $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition,approve, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid 
      WHERE issue_book.approve ='$exp' AND student.username='$_SESSION[login_user]'
      ORDER BY `issue_book`.`return` DESC";
            $res=mysqli_query($db,$sql);
    }

    else {
    $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition,approve, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid 
      WHERE issue_book.approve !='' AND issue_book.approve !='Yes' AND student.username='$_SESSION[login_user]' 
      ORDER BY `issue_book`.`return` DESC";
            $res=mysqli_query($db,$sql);
    }

    if(mysqli_num_rows($res) == 0) {
        echo "<h3 style='text-align:center; color: yellow;'>No expired requests</h3>";
    } else {
    
  echo "<table class='table table-bordered' style='width:100%;' > ";
    
    echo "<tr style='background-color: #b8adad;'>";
    echo "<th>"; echo "Username"; echo "</th>"; 
    echo "<th>"; echo "Roll"; echo "</th>"; 
    echo "<th>"; echo "Name"; echo "</th>"; 
    echo "<th>"; echo "Book ID"; echo "</th>"; 
    echo "<th>"; echo "Book Name"; echo "</th>"; 
    echo "<th>"; echo "Author/s Name"; echo "</th>";
    echo "<th>"; echo "Edition"; echo "</th>";
    echo "<th>"; echo "Status"; echo "</th>";
    echo "<th>"; echo "Issue Date"; echo "</th>";
    echo "<th>"; echo "Return Date"; echo "</th>";
    echo "</tr>"; 
    echo "</table>";



    echo "<div class='scroll'>";
    echo "<table class='table table-bordered ' > ";
        while($row = mysqli_fetch_assoc($res)) {
          
            echo "<tr>";
            echo "<td>"; echo $row['username']; echo "</td>";
            echo "<td>"; echo $row['roll']; echo "</td>";
            echo "<td>"; echo $row['name']; echo "</td>";
            echo "<td>"; echo $row['bid']; echo "</td>";
            echo "<td>"; echo $row['names']; echo "</td>";
            echo "<td>"; echo $row['authors']; echo "</td>";
            echo "<td>"; echo $row['edition']; echo "</td>";
            echo "<td>"; echo $row['approve']; echo "</td>";
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