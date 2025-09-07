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
    
    margin: 15px 0;
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
    height: 610px;
    background-color: black;
    opacity: 0.7;
    color: white;
    margin-top:-5px
}
.scroll {
    width: 100%;
    height: 400px;
    overflow-y: scroll;
}

/* center the section heading and the table inside the scroll area */
.container h2 {
    text-align: center;
    margin: 8px 0 18px;
}

.scroll table {
    width: 95% !important;    /*container keep table reasonably wide but not full width */
    margin: 0 auto !important; /* center the table horizontally */
}

th,td {
  width: 10%;
}
     </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php if(isset($_GET['returned'])): ?>
<script>
Swal.fire({
  title: "Success!",
  text: "Book has been returned successfully.",
  icon: "success",
  confirmButtonText: "OK",
  confirmButtonColor: "#589cdbff"
});
</script>
<?php endif; ?>
    
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
     <div style="text-align: center; font-size:20px;">

          <?php
          
               if(isset($_SESSION['login_admin'])) {
                     
                    $rawPic = isset($_SESSION['pic']) ? trim($_SESSION['pic']) : '';
                    $safePic = preg_replace('/[^A-Za-z0-9._-]/','_', $rawPic);
                    if ($safePic === '' || !is_file(__DIR__.'/../images/'.$safePic)) { $safePic='no-cover.png'; }
                    echo "<img class='img-circle profile_img' height=100 width=100 src='../images/".$safePic."'>  ";
                    echo "<br> <br>";
                    echo "Welcome,  ". $_SESSION['login_admin'] . "!";
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

  <?php
  if(isset($_SESSION['login_admin'])) {
    ?>
    <div style="float:left; margin: 15px 0px;">
      <form action="" method="post" name="form2">

        <button name="submit2" type="submit" class="btn btn-default" style="background-color:green; color:yellow;"> Returned </button> &nbsp;
        <button name="submit3" type="submit" class="btn btn-default" style="background-color:red; color:yellow;"> Expired </button>
      </div>
    </form>
    <div class="srch">
        <form action="" method="post" class="form-inline" style="display:inline-block;">
            <input type="text" name="search" class="form-control" placeholder="username or student name" value="<?php if(isset($_POST['search'])) echo htmlspecialchars($_POST['search']); ?>" required>
            <div>
              <button class="btn btn-primary" type="submit" name="search_submit" style="background-color:#b8adad; border-color:#b8adad; color:#000;">Search</button>
              <button class="btn btn-default" type="submit" name="clear_search" title="Clear search">Reset</button>
            </div>
        </form>
    </div>

    <?php

     if(isset($_POST['submit'])) {
      $res=mysqli_query($db, "SELECT * FROM issue_book WHERE username='$_POST[username]' AND bid='$_POST[bid]'") ;
      $day = 0;
$fine = 0;
      while($row = mysqli_fetch_assoc($res)) {
          $d = strtotime($row['return']);
          $c = strtotime(date("Y-m-d"));
          $diff = $c - $d;
          if($diff > 0) {
              $day = floor($diff / (60 * 60 * 24));
              $fine = $day * .10;
            }
       }

  $x= date("Y-m-d");
      
  mysqli_query($db, "INSERT INTO `fine`VALUES ('','$_POST[username]','$_POST[bid]','$x','$day','$fine','Not Paid');");


  $var1= '<p style="color:yellow; background-color: green;"> RETURNED </p>';
  $sql1 = "UPDATE issue_book SET approve='$var1' WHERE username='$_POST[username]' AND bid='$_POST[bid]'";
  mysqli_query($db, $sql1);

  // overwrite the stored return date with the actual return date
  mysqli_query($db, "UPDATE issue_book SET `return` = '$x' WHERE username='$_POST[username]' AND bid='$_POST[bid]'");

  mysqli_query($db, "UPDATE books SET quantity = quantity+ 1 WHERE bid='$_POST[bid]'");
  echo "<script>window.location='expired.php?returned=1'</script>";
  exit;
     }
  }
  ?>
  <br>
<h2 style="text-align:center;"> Date expired list </h2>
<?php
$c = 0;
if(isset($_SESSION['login_admin'])) { 

  $ret= '<p style="color:yellow; background-color: green;"> RETURNED </p>';
  $exp= '<p style="color:yellow; background-color: red;"> EXPIRED </p>';

  // search filter handling
  if(isset($_POST['clear_search'])){
    unset($_POST['search']);
  }
  $search_term = '';
  if(isset($_POST['search_submit']) && !empty(trim($_POST['search']))){
    $search_term = mysqli_real_escape_string($db, trim($_POST['search']));
  }
   
   if(isset($_POST['submit2'])) {
     $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition,approve, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid 
    WHERE issue_book.approve ='$ret'";
     if($search_term !== '') { $sql .= " AND (student.username LIKE '%$search_term%' OR student.name LIKE '%$search_term%')"; }
     $sql .= " ORDER BY (CASE WHEN issue_book.approve LIKE '%RETURNED%' THEN 1 ELSE 0 END) ASC, issue_book.return ASC";
     $res=mysqli_query($db,$sql);
   }

   else if(isset($_POST['submit3'])) {
     $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition,approve, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid 
    WHERE issue_book.approve ='$exp'";
     if($search_term !== '') { $sql .= " AND (student.username LIKE '%$search_term%' OR student.name LIKE '%$search_term%')"; }
     $sql .= " ORDER BY (CASE WHEN issue_book.approve LIKE '%RETURNED%' THEN 1 ELSE 0 END) ASC, issue_book.return ASC";
     $res=mysqli_query($db,$sql);
   }

   else {
     $sql="SELECT student.username, student.roll, student.name, books.bid, books.names, books.authors,books.edition,approve, issue_book.issue, issue_book.return  FROM student JOIN issue_book ON student.username = issue_book.username JOIN books ON books.bid = issue_book.bid 
    WHERE issue_book.approve !='' AND issue_book.approve !='Yes'";
     if($search_term !== '') { $sql .= " AND (student.username LIKE '%$search_term%' OR student.name LIKE '%$search_term%')"; }
     $sql .= " ORDER BY (CASE WHEN issue_book.approve LIKE '%RETURNED%' THEN 1 ELSE 0 END) ASC, issue_book.return ASC";
     $res=mysqli_query($db,$sql);
   }

    // if no rows, show message and don't render table
    if(!isset($res) || mysqli_num_rows($res) === 0){
      if(isset($search_term) && $search_term !== ''){
        echo "<h3 style='text-align:center; margin-top:20px;'>No records match '".htmlspecialchars($search_term)."'</h3>";
      } else {
        echo "<h3 style='text-align:center; margin-top:20px;'>No records to show</h3>";
      }
    } else {
  // single table (header + body) inside scroll so columns align
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
  echo "<th>"; echo "Status"; echo "</th>";
  echo "<th>"; echo "Action"; echo "</th>";
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
      echo "<td>"; echo $row['issue']; echo "</td>";
      echo "<td>"; echo $row['return']; echo "</td>";
      echo "<td>"; echo $row['approve']; echo "</td>";
      // Action column: show Return button only if not already returned
      echo "<td>";
      $approve_val = strtoupper($row['approve']);
      if(strpos($approve_val, 'RETURNED') === false) {
  // show small form and trigger SweetAlert2 confirmation like issue_info
  echo "<form method='post' style='margin:0' class='return-form'>";
  echo "<input type='hidden' name='username' value='".htmlspecialchars($row['username'])."'>";
  echo "<input type='hidden' name='bid' value='".htmlspecialchars($row['bid'])."'>";
  echo "<button type='button' class='btn btn-warning btn-sm return-btn' data-username='".htmlspecialchars($row['username'])."' data-bid='".htmlspecialchars($row['bid'])."' data-book='".htmlspecialchars($row['names'])."'>Return</button>";
  echo "</form>";
      }
      echo "</td>";

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
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.return-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      const form = btn.closest('form');
      const username = btn.getAttribute('data-username');
      const book = btn.getAttribute('data-book');
      Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to return '" + book + "' for user '" + username + "'?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          const submit = document.createElement('input');
          submit.type = 'hidden';
          submit.name = 'submit';
          submit.value = '1';
          form.appendChild(submit);
          // call native submit to avoid name='submit' shadowing
          HTMLFormElement.prototype.submit.call(form);
        }
      });
    });
  });
});
</script>
</body>
</html>