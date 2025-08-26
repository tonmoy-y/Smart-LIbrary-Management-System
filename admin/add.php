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
          .sarch {
               text-align:right;
          }



body {
    background-color:#a07fa9;
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

form.book {
            width: 400px; 
            margin: 0 auto;
          }

form.book input.form-control { 
            max-width: none;      
            width: 100%;       
                
          }
.form-control {
  background-color:rgb(10, 2, 2);
  color: white;
  height: 40px;
  border-radius: 8px;
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
  <div class="h"> <a href="#">Book Request</a> </div>
  <div class="h"> <a href="issue_info.php">Issue Information</a> </div>
  <div class="h"> <a href="expired.php">Expired List</a> </div>
</div>

<div id="main">

  <span style="font-size:30px;cursor:pointer " onclick="openNav()">&#9776; open</span>
            
  <div class="container"> 
    <h2  style="color:black; font-family: Lucidia Console; text-align:center;"> Add New Books</h2>
    <form class="book" action="" method="post" enctype="multipart/form-data">   
          <input  type="text" name="names" class="form-control" placeholder="Book Name" required> <br>
          <input  type="text" name="authors" class="form-control" placeholder="Authors Name" required> <br>
          <input  type="text" name="edition" class="form-control" placeholder="Edition" required> <br>
          <input  type="text" name="status" class="form-control" placeholder="Status" required> <br>
          <input  type="text" name="quantity" class="form-control" placeholder="Quantity" required> <br>
          <input  type="text" name="department" class="form-control" placeholder="Department" required> <br>
          <input type="file" name="image" class="form-control" required> <br>

          <div style="text-align:right;">
                 <button  class="btn btn-default" type="submit" name="submit"> Add</button>
               </div>
    </form>
</div>
<?php
    if(isset($_POST['submit'])) {
      
      if(isset($_SESSION['login_user'])) {
        
               // file upload
            $imageName = $_FILES['image']['name'];
            $target = "../images/".basename($imageName);

             if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
$name = mysqli_real_escape_string($db, $_POST['names']);
$author = mysqli_real_escape_string($db, $_POST['authors']);
$edition = mysqli_real_escape_string($db, $_POST['edition']);
$status = mysqli_real_escape_string($db, $_POST['status']);
$quantity = mysqli_real_escape_string($db, $_POST['quantity']);
$department = mysqli_real_escape_string($db, $_POST['department']);

        mysqli_query($db,"INSERT INTO `books`( `names`, `authors`, `edition`, `status`, `quantity`, `department`, `image`) VALUES ('$name','$author','$edition','$status','$quantity','$department','$imageName')") ;

      ?>
      <script type="text/javascript">
Swal.fire({
    title: "Success!",
    text: "Book Successfully Added.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "books.php";
});
</script>
      
      <?php
             }

             else {
                ?>

<script type="text/javascript">
Swal.fire({
    title: "Warning!",
    text: "Failed to upload image.",
    icon: "warning",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "add.php";
});
</script>


<?php
             }
      
      }
      else {
        ?>
              <script type="text/javascript">
Swal.fire({
    title: "Warning!",
    text: "You must be logged in to add books.",
    icon: "warning",
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

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
  document.getElementById("main").style.marginLeft = "300px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "#a07fa9";
}
</script>

</body>
</html>