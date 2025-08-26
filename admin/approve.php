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
    <title>Approve Request</title>
     <style type="text/css">
          .srch {
               text-align:right;

          }
.form-control {

    /* display: inline-block; */
    margin-right: 10px;
    height:30px;
    /* background-color:#000000; */
    
}


body {
    background-image: url("images/br.png");
    background-size: cover;
    background-repeat: no-repeat;
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
    height: 700px;
    background-color: black;
    opacity: 0.7;
    color: white;
}

.Approve {
    /* margin: 0px auto !important; */
    /* margin-top: 0px auto; */
    text-align: center;
    margin: 50px  425px ;
   
}
form.Approve {
            width: 300px; 
          }

form.Approve input.form-control { 
            max-width: none;      
            width: 100%;       
                
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
  <!-- <div class="h"> <a href="delete.php">Delete Books</a> </div> -->
  <div class="h"> <a href="request.php">Book Request</a> </div>
  <div class="h"> <a href="issue_info.php">Issue Information</a> </div>
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
    <h3 style="text-align:center;"> Approve Request</h3>
    
    <form class="Approve" action="" method="post">
    
    <!-- Approve Dropdown -->
    <select name="approve" class="form-control" required>
        <option value="" disabled selected>Approve - Yes or No</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
    <br>
    
    <!-- Issue Date -->
    <input type="date" name="issue" class="form-control" placeholder="Issue Date yyyy-mm-dd" required pattern="\d{4}-\d{2}-\d{2}"> 
    <br>
    
    <!-- Return Date -->
    <input type="date" name="return" class="form-control" placeholder="Return Date yyyy-mm-dd" required pattern="\d{4}-\d{2}-\d{2}"> 
    <br>

    <button type="submit" name="submit" class="btn btn-default">Approve</button>
</form>

</div>


<?php


if(isset($_POST['submit']))  {
    $tm = date("M d, Y H:i:s", strtotime($_POST['return'] . ' 20:00:00'));
    mysqli_query($db, "INSERT INTO `timer` VALUES ('$_SESSION[st_name]','$_SESSION[bid]','$tm');");
    mysqli_query($db,"UPDATE issue_book SET approve='$_POST[approve]', issue='$_POST[issue]', `return`='$_POST[return]' WHERE username='$_SESSION[st_name]' AND bid='$_SESSION[bid]';");
    mysqli_query($db,"UPDATE books SET quantity=quantity-1 WHERE bid='$_SESSION[bid]';");
    
    $res = mysqli_query($db,"SELECT quantity FROM books WHERE bid='$_SESSION[bid]';");   
    
    while($row = mysqli_fetch_assoc($res)) {
        if($row['quantity'] == 0) {
            mysqli_query($db,"UPDATE books SET status='Not Available' WHERE bid='$_SESSION[bid]';");
        }
    }
    ?>
    <script type="text/javascript">
Swal.fire({
    title: "Success!",
    text: "Request Approved Successfully.",
    icon: "success",
    confirmButtonText: "OK",
    confirmButtonColor: "#589cdbff"
}).then(() => {
    window.location = "request.php";
});
</script>
<?php

}
?>
</div>
</body>
</html>