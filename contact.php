<?php
// include database connection file
     include "connection.php";
     include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <title>Feedback</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <style type=text/css> 
     body {
          background-image: url("images/feedback.jpg");
     }
     .wrap {
          width: 800px;
          height: 500px;
          background-color: black;
          opacity: 0.8;
          color: white;
          margin: 20px auto;
          padding: 20px;
          border-radius: 10px;
          /* text-align: center; */

  

     }
     .form-control {
          height: 75px;
          width: 60% !important;
          /* margin: 10px auto; */

     }
     .scroll {
          width: 100%;
          height: 300px;
          overflow: scroll;
     }

form.write {
            width: 1000px; 
          }

form.write input.form-control { 
            max-width: none;      
            width: 100%;       
                
          }

     </style>

</head>
<body>

     <div class="wrap">
          <h4>If you have any suggestion or question please write here</h4>
     <form class="write" style="" action="" method="post">

          <input class="form-control" type="text" name="comment" placeholder="write something...."> <br>

          <input class="btn btn-default" type="submit" name="submit" value="Comment" style="width: 100px; height: 30px; font-weight: 1000;">
     </form>
     <br>
     <div class="scroll">


     <?php
          if(isset($_POST['submit'])) {
               if(isset($_SESSION['login_user'])){
               $sql ="INSERT INTO `comments` VALUE('','$_SESSION[login_user]','$_POST[comment]')";
               if(mysqli_query($db,$sql)) {
                    $q = "SELECT * from comments ORDER BY comments.id DESC";
                    $res = mysqli_query($db,$q);
                    echo "<table class='table table-bordered'>";
                    while ($row=mysqli_fetch_assoc($res)) {
                         echo "<tr>";
                          echo "<td>"; echo $row['username']; echo "</td>";
                         echo "<td>"; echo $row['comment']; echo "</td>";
                         echo "</tr>";  
                    }
                    echo "</table>";
               }
          } 
          else {
               ?>
               <script type="text/javascript">
        Swal.fire({
            title: "Error!",
            text: "You must login to Commnet",
            icon: "warning",
            confirmButtonText: "OK",
            confirmButtonColor: "#589cdbff"
        }).then(() => {
            window.location = "login.php";
        });
        </script>
        <?php
          }
     }

          else {
               $q = "SELECT * FROM `comments` ORDER BY id DESC;";
               $res = mysqli_query($db,$q);
               echo "<table class='table table-bordered'>";
               while ($row=mysqli_fetch_assoc($res)) {
                    echo "<tr>";
                    echo "<td>"; echo $row['username']; echo "</td>";
                    echo "<td>"; echo $row['comment']; echo "</td>";
                    echo "</tr>";  
               }
               echo "</table>";
               
          }
              
     ?>
</div>
</div>


</body>
</html>