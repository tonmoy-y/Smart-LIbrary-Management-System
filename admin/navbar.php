<?php
session_start();
include "connection.php";
if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_admin']) && !isset($_SESSION['admin_reset'])) {
    header("Location: ../index");
    exit();
} elseif(isset($_SESSION['login_user'])) {
    header("Location: ../student/index"); 
    exit();
}

if (isset($_SESSION['admin_reset'])) {

    if (time() - $_SESSION['admin_reset_time'] > 600) { // 600 sec = 10 min
        unset($_SESSION['admin_reset']);
        unset($_SESSION['admin_reset_time']);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" type="text/css" href="responsive.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
    <!-- <div class="wrapper"> -->
<?php
if(isset($_SESSION['login_admin'])) {
  $r=mysqli_query($db, "SELECT COUNT(status) AS total FROM `message` WHERE sender='student' AND status='no' ;");
  $c=mysqli_fetch_assoc($r);

  $sql_app= mysqli_query($db, "SELECT COUNT(status) AS total FROM `admin` WHERE status='';");
  $a=mysqli_fetch_assoc($sql_app);

}
?>
        <header>
            <a href="index">
            <img src="images/logo.png" alt="Library Logo" class="logo">

            <p class="logofont">Online Library Management System</p>
            </a >
            <nav class="navbar">
              <button type="button" class="menu-toggle" aria-label="Open menu" aria-expanded="false" style="z-index:1101;position:relative;"><span class="bar"></span></button>
              <div class="drawer-backdrop" hidden></div>
              <div class="nav-links">


                <a href="index" class="nav-btn home"> <i class="fa fa-home"></i> Home</a>
                <a href="books" class="nav-btn books"> <i class="fa fa-book"></i> Books</a>
                <a href="contact" class="nav-btn feedback"> <i class="fa fa-comment"></i> Feedback</a>

                <?php
                      if(isset($_SESSION['login_admin'])) {
                        ?>

<a href="student" class="nav-btn admin"> <i class="fa fa-user"></i> Student-Info </a>
 <a href="fine" class="nav-btn books"> <i class="fa fa-money-bill"></i> Fines </a>

                        <?php
                      }
?>
                
                <div class="rightend">
                  <?php
                      if(isset($_SESSION['login_admin'])) {
                        ?>

                        <a href="admin_status" class="nav-btn admin"><i class="fa fa-user"></i>
                        <span class="badge bg-green">
                          <?php echo $a['total']; ?>
                         </span></a>

                        <a href="message" class="nav-btn admin"> <i class="fa fa-envelope"></i>
                         <span class="badge bg-green">
                          <?php echo $c['total']; ?>
                         </span></a>
                            <a href="profile" class="nav-btn admin">
                                       
                           <?php
               $rawPic = isset($_SESSION['pic']) ? trim($_SESSION['pic']) : '';
               $safePic = preg_replace('/[^A-Za-z0-9._-]/','_', $rawPic);
               $imgDir = __DIR__ . '/../images/';
               if ($safePic === '' || !is_file($imgDir . $safePic)) {
                 $fallback = 'no-cover.png';
                 if (!is_file($imgDir . $fallback)) {
                   $phData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAQAAAAAYLlVAAAAK0lEQVR4Ae3PMQkAMAgAsXH/n9u4BNnQAklJkiRJkiRJkiRJkiRJL4y8AL2mA+2MbNTSAAAAAElFTkSuQmCC');
                   @file_put_contents($imgDir . $fallback, $phData);
                 }
                 $safePic = $fallback;
               }
               echo "<img class='img-circle profile_img' height=25 width=25 src='../images/".htmlspecialchars($safePic, ENT_QUOTES, 'UTF-8')."'>  ";
               echo "  ". htmlspecialchars($_SESSION['login_admin'], ENT_QUOTES, 'UTF-8') . "!";
                        ?>
                    
                        </a>
                      
                       
                    <a href="logout" class="nav-btn student"><i class="fa fa-sign-out-alt"></i> Log out</a>

                    <?php
                      }
                      else {
                    ?>
                    <a href="../login" class="nav-btn admin"><i class="fa fa-sign-in-alt"></i>  Login</a>
                    
                    <?php
                      }
                    ?>
                </div>

                
              </div>
            </nav>
            <script>
              (function(){
                function initNavToggle(){
                  var btn = document.querySelector('.menu-toggle');
                  var backdrop = document.querySelector('.drawer-backdrop');
                  if (!btn) return;
                  try { btn.style.zIndex = '1101'; } catch(e){}
                  function toggle(){
                    var open = document.body.classList.toggle('nav-open');
                    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                    if (backdrop) backdrop.toggleAttribute('hidden', !open);
                  }
                  btn.addEventListener('click', toggle);
                  if (backdrop) backdrop.addEventListener('click', toggle);
                }
                if (document.readyState === 'loading') {
                  document.addEventListener('DOMContentLoaded', initNavToggle);
                } else {
                  initNavToggle();
                }
              })();
            </script>
            
        </header>
    <!-- </div> -->
     
</body>
</html>