<?php
 include "connection.php";
 session_start();
 $re = ['tm' => '']; // minimal init to avoid undefined variable/offset

if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_admin']) && !isset($_SESSION['student_reset'])) {
    header("Location: ../index");
    exit();
} elseif(isset($_SESSION['login_admin'])) {
    header("Location: ../admin/index"); 
    exit();
}
if (isset($_SESSION['student_reset'])) {

    if (time() - $_SESSION['student_reset_time'] > 600) { // 600 sec = 10 min
        unset($_SESSION['student_reset']);
        unset($_SESSION['student_reset_time']);
    }
}

mysqli_query($db, "DELETE FROM verify WHERE created_at < DATE_SUB(NOW(), INTERVAL 3 MINUTE)");


  //timer---------------------------
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Online Library Management</title>
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="responsive.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

<style>
.timer-box {
    display: inline-block;
    background: linear-gradient(90deg, #ffecd2 0%, #fcb69f 100%);
    color: #333;
    font-weight: bold;
    font-size: 15px;
    border-radius: 25px;
    padding: 10px 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    margin-right: 15px;
    letter-spacing: 2px;
    border: 2px solid #fcb69f;
    transition: background 0.3s, color 0.3s;
}
.timer-box.expired {
    background: #ff4e50;
    color: #fff;
    border-color: #ff4e50;
}
</style>

</head>
<body>
    <!-- <div class="wrapper"> -->
<?php
if(isset($_SESSION['login_user'])) {
  $r=mysqli_query($db, "SELECT COUNT(status) AS total FROM `message` WHERE sender='admin' AND status='no' AND username='$_SESSION[login_user]';");
  $c=mysqli_fetch_assoc($r);

  //timer---------------------------
  $b= mysqli_query($db, "SELECT * FROM `issue_book` WHERE username='$_SESSION[login_user]' AND approve='Yes' ORDER BY `return` ASC limit 0,1;");
  $bid = mysqli_fetch_assoc($b);
  $re = null;
  if ($bid && isset($bid['bid'])) {
    $t = mysqli_query($db, "SELECT * FROM timer WHERE `name`= '$_SESSION[login_user]' AND bid = '{$bid['bid']}';");
    $re = mysqli_fetch_assoc($t);
  }
  $hasTimer = is_array($re) && !empty($re['tm']);
  
}

?>
        <header>
            <a href="index">
            <img src="images/logo.png" alt="Library Logo" class="logo">

            <p class="logofont">Online Library Management System</p>
            </a>
            <nav class="navbar">
              <button type="button" class="menu-toggle" aria-label="Open menu" aria-expanded="false" style="z-index:1101;position:relative;"><span class="bar"></span></button>
              <div class="drawer-backdrop" hidden></div>
              <div class="nav-links">
              
<!-- -------------------------------------Timer ------------------------------->
                          
 <!-- -----------------------------------------------------------------------------  -->
              
           <a href="index" class="nav-btn home"><i class="fa fa-home"></i> Home</a>
             <a href="books" class="nav-btn books"><i class="fa fa-book"></i> Books</a>
            <a href="contact" class="nav-btn feedback"><i class="fa fa-comment"></i> Feedback</a>
                <?php
                if(isset($_SESSION['login_user'])) {
                        ?>
                <a href="fine" class="nav-btn books"><i class="fa fa-money-bill"></i> Fines </a>

                <?php
                      }
                      ?>

<div class="rightend ">
  <?php if (isset($_SESSION['login_user'])) { ?>
    <?php if ($hasTimer) { ?>
      <a><span id="demo" class="timer-box"></span></a>
      <script>
        (function () {
          var target = document.getElementById("demo");
          if (!target) return;
          var countDownDate = new Date("<?php echo addslashes($re['tm']); ?>").getTime();

          function tick() {
            var now = Date.now();
            var distance = countDownDate - now;

            if (distance <= 0) {
              target.textContent = "EXPIRED";
              target.classList.add("expired");
              clearInterval(timer);
              return;
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            target.textContent = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
            target.classList.remove("expired");
          }

          tick();
          var timer = setInterval(tick, 1000);
        })();
      </script>
    <?php } ?>
    <a href="message" class="nav-btn admin"><i class="fa fa-envelope"></i>
      <span class="badge bg-green">
        <?php echo $c['total']; ?>
      </span></a>
    <a href="profile" class="nav-btn admin">
      <?php
        $rawPic = isset($_SESSION['pic']) ? trim($_SESSION['pic']) : '';
        // Normalize dangerous path chars & collapse spaces
    $safePic = preg_replace('/[^A-Za-z0-9._-]/','_', $rawPic);
    $rootImgDir = __DIR__ . '/../images/'; // actual stored location
    if ($safePic === '' || !is_file($rootImgDir . $safePic)) {
            // fallback placeholder if missing
            $fallback = 'no-cover.png';
      if (!is_file($rootImgDir . $fallback)) {
                // tiny base64 placeholder (only once)
                $phData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAQAAAAAYLlVAAAAK0lEQVR4Ae3PMQkAMAgAsXH/n9u4BNnQAklJkiRJkiRJkiRJkiRJL4y8AL2mA+2MbNTSAAAAAElFTkSuQmCC');
        @file_put_contents($rootImgDir . $fallback, $phData);
            }
            $safePic = $fallback;
        }
    echo "<img class='img-circle profile_img' height=25 width=25 src='../images/".htmlspecialchars($safePic, ENT_QUOTES, 'UTF-8')."'> ";
        echo htmlspecialchars($_SESSION['login_user'] . '!', ENT_QUOTES, 'UTF-8');
      ?>
    </a>
    
    <a href="logout" class="nav-btn student"><i class="fa fa-sign-out-alt"></i> Log out</a>
  <?php } else { ?>
    <a href="../login" class="nav-btn student"><i class="fa fa-sign-in-alt"></i> Login</a>
  <?php } ?>
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
            
    <?php
    if(isset($_SESSION['login_user'])) {
      $day=0;
        $exp= '<p style="color:yellow; background-color: red;"> EXPIRED </p>';

        $res = mysqli_query($db, "SELECT `return` from issue_book WHERE username='$_SESSION[login_user]' AND approve = '$exp';");
        while($row = mysqli_fetch_assoc($res)) {
            $d = strtotime($row['return']);
            $c = strtotime(date("Y-m-d"));
            $diff = $c - $d;
            if($diff > 0) {
              $day = $day + floor($diff / (60 * 60 * 24)); // Convert seconds to days
             
            }
          }
           $_SESSION['fine'] = $day*.10;
           // echo $day."<br>";

    } else {
        
    }
    ?>
        </header>
    <!-- <?php 
    // if ($re && !empty($re['tm'])) { 
      ?>
   
    <?php 
    // }
     ?> -->
<!-- -------------------------------------Timer ------------------------------->


</body>
</html>