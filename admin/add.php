<?php

     include "connection.php";
     include "navbar.php";
     include "csrf.php";

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
    background-color:var(--primary-light);
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
  background-color: var(--primary);
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
     background-color:var(--accent);
     
}

form.book {
            max-width: 400px;
            width: calc(100% - 24px);
            box-sizing: border-box;
            margin: 0 auto;
          }

form.book input.form-control { 
            max-width: none;      
            width: 100%;       
                
          }
.form-control {
  background-color: #fff;
  color: #222;
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

  <div class="h"> <a href="add">Add Books </a> </div>
  <!-- <div class="h"> <a href="delete">Delete Books</a> </div> -->
  <div class="h"> <a href="request">Book Request</a> </div>
  <div class="h"> <a href="issue_info">Issue Information</a> </div>
  <div class="h"> <a href="expired">Expired List</a> </div>
</div>

<div id="main">

  <button type="button" class="sidenav-toggle" onclick="openNav()" aria-label="Open section menu"><span>&#9776;</span> Menu</button>
            
  <div class="container"> 
    <h2  style="color:black; font-family: Lucidia Console; text-align:center;"> Add New Books</h2>
    <form class="book" action="" method="post" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
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
      csrf_verify();

      if(isset($_SESSION['login_admin'])) {
        
               // file upload
            $allowed_ext = array('jpg','jpeg','png','gif','webp');
            $original = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $base = pathinfo($original, PATHINFO_FILENAME);
            $base = preg_replace('/[^A-Za-z0-9_-]+/', '_', $base);
            $base = trim($base, '_');
            if ($base === '') { $base = 'book'; }
            $imageName = $base.'_'.time().'.'.$ext;
            $target = "../images/".$imageName;

             $uploaded = in_array($ext, $allowed_ext) && move_uploaded_file($_FILES['image']['tmp_name'], $target);
             if($uploaded && !(filesize($target) > 0 && @getimagesize($target))) {
                 @unlink($target);
                 $uploaded = false;
             }

             if($uploaded) {
$name = $_POST['names'];
$author = $_POST['authors'];
$edition = $_POST['edition'];
$status = $_POST['status'];
$quantity = $_POST['quantity'];
$department = $_POST['department'];

        $stmt = mysqli_prepare($db, "INSERT INTO `books`( `names`, `authors`, `edition`, `status`, `quantity`, `department`, `image`) VALUES (?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $author, $edition, $status, $quantity, $department, $imageName);
        mysqli_stmt_execute($stmt);

      ?>
      <script type="text/javascript">
Swal.fire({
    title: "Success!",
    text: "Book Successfully Added.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "books";
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
    window.location = "add";
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
    window.location = "../login";
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
  document.body.style.backgroundColor = "var(--primary-light)";
}
</script>

</body>
</html>