<?php
      include "connection.php";
      include "navbar.php";
$re = null;
      // Handle student deletion
      if(isset($_POST['delete_user']) && isset($_POST['username_to_delete'])){
           $uname = mysqli_real_escape_string($db, $_POST['username_to_delete']);
           // delete the student record
           mysqli_query($db, "DELETE FROM student WHERE username='$uname'");
           echo "<script>window.location='student.php?deleted=1'</script>";
           exit;
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Student Information</title>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if(isset($_GET['deleted'])): ?>
<script type="text/javascript">
Swal.fire({
     title: "Success!",
     text: "Student was deleted.",
     icon: "success",
     confirmButtonText: "OK",
     confirmButtonColor: "#589cdbff"
}).then(() => {
     window.location = "student";
});
</script>
<?php endif; ?>

<!-- ____________________________side __________________________________ -->


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


<!--____________________________search bar___________________________-->
<div class="container">
     <div class="sarch">
          <form class="navbar-form" action="" method="post" name="form1">

                    <input class="form-control" type="text" class="form-control" name="search" placeholder="Search for Students..." required>
                    <button type="submit" name="submit" class="btn btn-default" style="background: #b8adad";> <span class="glyphicon glyphicon-search"></span> Search</button>

          </form>


     </div>
     <h2> List of Students </h2>
     <?php
// SELECT `name`, `roll`, `dept`, `phone`, `email`, `username` FROM `student`
          // --------------- search query------------
     if(isset($_POST['submit'])) {
          // $q = $_POST['search'];
          $q = mysqli_query($db, "SELECT * FROM student WHERE `name` LIKE '%$_POST[search]%' OR roll LIKE '%$_POST[search]%' OR username LIKE '%$_POST[search]%' OR email LIKE '%$_POST[search]%'");
               if( mysqli_num_rows($q) == 0) 
                    // If search query returns results, display them
                    echo "Sorry, no results found for your search.";
               else {
                     echo "<table class='table table-bordered table-hover' > ";
     echo "<tr style='background-color: #b8adad;'>";
     echo "<th>"; echo "Name"; echo "</th>"; 
     echo "<th>"; echo "Roll"; echo "</th>"; 
     echo "<th>"; echo "Department"; echo "</th>"; 
     echo "<th>"; echo "Phone"; echo "</th>"; 
     echo "<th>"; echo "Email"; echo "</th>"; 
     echo "<th>"; echo "Username"; echo "</th>"; 
     echo "<th>"; echo "Action"; echo "</th>"; 
    //  echo "<th>"; echo "Department"; echo "</th>";
     echo "</tr>"; 

     while($row = mysqli_fetch_assoc($q)) {
          echo "<tr>";
          echo "<td>"; echo $row['name']; echo "</td>";
          echo "<td>"; echo $row['roll']; echo "</td>";
          echo "<td>"; echo $row['dept']; echo "</td>";
          echo "<td>"; echo $row['phone']; echo "</td>";
          echo "<td>"; echo $row['email']; echo "</td>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "<td>";
          echo "<form method='post' style='margin:0' class='student-delete-form' data-uname='".htmlspecialchars($row['username'], ENT_QUOTES)."'>";
          echo "<input type='hidden' name='username_to_delete' value='".htmlspecialchars($row['username'], ENT_QUOTES)."'>";
          echo "<button type='submit' name='delete_user' class='btn btn-danger btn-xs'>Delete</button>";
          echo "</form>";
          echo "</td>";
          echo "</tr>";
     }
     echo "</table>";
               }
      }

else {


     $res=mysqli_query($db,"SELECT `name`, `roll`, `dept`, `phone`, `email`, `username` FROM `student`");
     //table header
     echo "<table class='table table-bordered table-hover' > ";
     echo "<tr style='background-color: #b8adad;'>";
     echo "<th>"; echo "Name"; echo "</th>"; 
     echo "<th>"; echo "Roll"; echo "</th>"; 
     echo "<th>"; echo "Department"; echo "</th>"; 
     echo "<th>"; echo "Phone"; echo "</th>"; 
     echo "<th>"; echo "Email"; echo "</th>"; 
     echo "<th>"; echo "Username"; echo "</th>"; 
     echo "<th>"; echo "Action"; echo "</th>"; 
    //  echo "<th>"; echo "Department"; echo "</th>";
     echo "</tr>";  

     while($row = mysqli_fetch_assoc($res)) {
           echo "<tr>";
          echo "<td>"; echo $row['name']; echo "</td>";
          echo "<td>"; echo $row['roll']; echo "</td>";
          echo "<td>"; echo $row['dept']; echo "</td>";
          echo "<td>"; echo $row['phone']; echo "</td>";
          echo "<td>"; echo $row['email']; echo "</td>";
          echo "<td>"; echo $row['username']; echo "</td>";
          echo "<td>";
          echo "<form method='post' style='margin:0' class='student-delete-form' data-uname='".htmlspecialchars($row['username'], ENT_QUOTES)."'>";
          echo "<input type='hidden' name='username_to_delete' value='".htmlspecialchars($row['username'], ENT_QUOTES)."'>";
          echo "<button type='submit' name='delete_user' class='btn btn-danger btn-xs'>Delete</button>";
          echo "</form>";
          echo "</td>";
          echo "</tr>";
     }
     echo "</table>";
}
     ?>
</div>
</div>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
     document.querySelectorAll('.student-delete-form').forEach(function(form){
          const btn = form.querySelector("button[name='delete_user']");
          if(!btn) return;
          btn.addEventListener('click', function(e){
               e.preventDefault();
               const uname = form.getAttribute('data-uname') || '';
               Swal.fire({
                    title: "Warning!",
                    text: "Are you sure today?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    confirmButtonColor: "#589cdbff"
               }).then((result) => {
                    if(result.isConfirmed){
                         // ensure delete_user is present when submitting programmatically
                         if(!form.querySelector("input[name='delete_user']")){
                              const hidden = document.createElement('input');
                              hidden.type = 'hidden';
                              hidden.name = 'delete_user';
                              hidden.value = '1';
                              form.appendChild(hidden);
                         }
                         HTMLFormElement.prototype.submit.call(form);
                    }
               });
          });
     });
});
</script>
</body>
</html>