<?php
    // Start output buffering so header redirects work even if included files emit output
    ob_start();
     include "connection.php";
     include "navbar.php";

    // Resolve a student's picture from the student table with a safe fallback
    function get_student_pic(mysqli $db, string $username): string {
        $u = mysqli_real_escape_string($db, trim($username));
        if ($u === '') return 'user.jpg';
        $rs = mysqli_query($db, "SELECT pic FROM student WHERE username='$u' LIMIT 1");
        if ($rs && ($row = mysqli_fetch_assoc($rs))) {
            $pic = trim((string)$row['pic']);
            return $pic !== '' ? $pic : 'user.jpg';
        }
        return 'user.jpg';
    }

    // Handle send message early so it works even when ?u= is present in URL
    if (isset($_POST['submit1'])) {
        $to = trim($_POST['to'] ?? ($_SESSION['chat_with'] ?? ''));
        $msg = trim($_POST['message'] ?? '');
        if ($to !== '' && $msg !== '') {
            $to_esc  = mysqli_real_escape_string($db, $to);
            $msg_esc = mysqli_real_escape_string($db, $msg);
            // Ensure columns are specified to avoid schema mismatch
            mysqli_query($db, "INSERT INTO `message` (username, message, status, sender) VALUES ('$to_esc', '$msg_esc', 'no', 'admin')");
            // Make sure current chat is persisted
            $_SESSION['chat_with'] = $to;
        }
        // Redirect (PRG pattern) to avoid duplicate submits and keep context
        header("Location: message.php?u=" . urlencode($to));
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            margin: 0;
            background-color: #8ecdd2;
        }
        .container {
            margin: 0 -20px;
            display: flex;
            width: 100vw; /* Make container full viewport width */
        }
        .left_box {
            height: 650px;
            width: 40%; /* Responsive width */
            background-color: #8ecdd2;
            /* margin-left: -20px; */
        }
        .left_box2 {
            height: 650px;
            width: 70%;
            background-color: #537890;
            border-radius: 20px;
            float:right;
            
        }
        .left_box input {
            width:70%;
            height: 35px;
            /* background-color:transparent; */
            margin: 10px;
            padding:10px;
            border-radius: 10px;
        }

        .list {
            height:550px;
            width: 100%;
            background-color: #537890;
            float: right;
            color:white;
            padding:10px;
            overflow-y: scroll;
            overflow-x: hidden;

        }
        .right_box {
            height: 650px;
            width: 60%; /* Responsive width */
            background-color: #8ecdd2;
        }
        .right_box2 {
            height: 650px;
            width: 80%; /* Responsive width */
            background-color: #537890;
            border-radius: 20px;
            float:left;
            color:white;
            margin-left: 30px;
            padding: 10px;
        }
tr:hover {
            background-color: #1e3f54;
            cursor: pointer;
        }

form.write {
            width: 100%;
            height:47px; 
            display:flex; 
          }

form.write input.form-control { 
            max-width: none;      
            width: 100%; 
            max-height: none;
            height: 100%;  
                
          }

.msg {
    height: 470px;
    overflow-y: scroll;

}
.btn-info {
   opacity: 1; 
}
.chat {
    display:flex;
    flex-wrap: wrap;
}

.user .chatbox,
.Admin .chatbox {
    /* height: 50px; */
    /* width: 90%; */
    display: inline-block;
    max-width: 70%; /* Prevents bubble from being too wide */
    padding: 13px 10px;
    border-radius: 10px;
    word-break: break-word;
}

.user .chatbox {
    background-color: red;
    color: white;
}

.Admin .chatbox {
    background-color: white;
    color: black;
    order: -1;
}

/* Align admin chat to the right */
.chat.Admin {
    display: flex;
    justify-content: flex-end;
    align-items: flex-start;
}
    </style>
        <style>
        /* Mobile-only fixes */
        @media (max-width: 576px) {
            .container { flex-direction: column; width: 100%; margin: 0; }
            .left_box, .right_box { width: 100%; }
        .left_box2, .right_box2 { width: calc(100% - 20px); margin: 10px; height: auto; }
        .right_box2 { min-height: 60vh; display: flex; flex-direction: column; }
            .list { max-height: 40vh; }
        .msg { max-height: 50vh; overflow-y: auto; flex: 1 1 auto; }
            form.write { height: auto; gap: 8px; }
            form.write input.form-control { height: 40px; }
            .btn.btn-info.btn-lg { padding: 8px 12px; font-size: 14px; line-height: 1.2; white-space: nowrap; }
            .chat .chatbox { max-width: 90%; }
        }
        </style>
</head>
<body>
<?php
$sql1= mysqli_query($db, "SELECT student.pic, message.username FROM message  JOIN student ON student.username = message.username 
WHERE message.sender='student' GROUP BY student.username
ORDER BY `message`.`status` ASC;");
?>
    <div class="container">
        <div class="left_box">
            <div class="left_box2">
                <div>
                    <form id="showForm" method="post" enctype="multipart/form-data">
                        <input type="text" name="username" id="uname">
                        <input type="hidden" name="submit" value="1">
                        <button type="submit" class="btn btn-default">SHOW</button>
                    </form>
                </div>

                <div  class="list">
                <?php
                    echo "<table id='table' class='table'>";
                    while($res1=mysqli_fetch_assoc($sql1)) { 
                        echo "<tr class='user-row' data-username=\"".htmlspecialchars($res1['username'], ENT_QUOTES, 'UTF-8')."\">";
                            echo"<td width=65>"; echo "<img class='img-circle profile_img' 
                            height=60 width=60 src='../images/".$res1['pic']."'>"; echo"</td>"; 
                            
                            echo "<td style='vertical-align: middle;'>".htmlspecialchars($res1['username'], ENT_QUOTES, 'UTF-8')."</td>";
                         echo "</tr>";
                     }
                    echo "</table>";
                ?>
                </div>
            </div>
        </div>
        <div class="right_box">
            <div class="right_box2">
          
            <?php
// ----------------if submit is presssed----------------
            if (isset($_POST['submit']) || isset($_GET['u'])) {
                $uname = trim($_POST['username'] ?? ($_GET['u'] ?? ''));
                $safeUname = mysqli_real_escape_string($db, $uname);
                $res = mysqli_query($db, "SELECT * FROM `message` WHERE username='$safeUname';");
                mysqli_query($db, "UPDATE `message` SET `status`='yes' WHERE sender='student' AND username='$safeUname';");
                if ($uname !== '') {
                    // Do NOT override logged-in admin's session username
                    $_SESSION['chat_with'] = $uname;
                }
                // Resolve student picture locally (no session writes)
                $student_pic = get_student_pic($db, $_SESSION['chat_with'] ?? $uname);
                ?>
                <div style="height:70px; width: 100%; text-align: center; color:white;">
                    <h3><?php echo htmlspecialchars($_SESSION['chat_with'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                </div>
<!-- --------------------show message----------------------------  -->
<div class="msg">

<?php
while($row=mysqli_fetch_assoc($res)) {
    if($row['sender']=='student')
    {

?>


<!-- ---------------student -------------- -->
 <br>   <div class="chat user">
        <div style="float:left; padding-top:5px;">
&nbsp;
<?php  
       echo "<img class='img-circle profile_img' height=40 width=40 src=\"../images/{$student_pic}\">";
    //    echo " " . $_SESSION['login_admin'] . "!";
    ?>
    &nbsp;
        </div>
        <div style="float:left;" class="chatbox">
     
            <?php
            echo $row['message'];

            ?>
        </div>
    </div>
<?php
    }
    else {

    
?>

<!-- ----------------------admin---------------- -->
  <br> <div class="chat Admin">
        <div style="float:left; padding-top:5px;">
&nbsp;
<?php  
       echo "<img class='img-circle profile_img' height=40 width=40 src='../images/user.jpg'>";
    //    echo " " . $_SESSION['login_admin'] . "!";
    ?>
    <!-- hr -->
    &nbsp;
        </div>
        <div style="float:left;" class="chatbox">
           
            <?php
            echo $row['message'];

            ?>

        </div>
    </div>

    <?php } } ?>

</div>
<!-- ----------------------------------------  -->
                <div style="height:100px; padding-top:10px;">
    <form action="" method="post" class="write">
        <input type="hidden" name="to" value="<?php echo htmlspecialchars($_SESSION['chat_with'] ?? $uname ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <input type="text" name="message" class="form-control" placeholder="Write Message..." style="float:left;" required>
        &nbsp; 
        <button class="btn btn-info btn-lg" type="submit" name="submit1"><span class="glyphicon glyphicon-send"></span> &nbsp Send</button>

    </form>
</div>

                <?php
            }
// ----------------if submit is not  presssed----------------
            else {
                if (!isset($_SESSION['chat_with']) || $_SESSION['chat_with'] == '') {
                    ?>
        <img style="margin:100px 80px;" src="images/tonor.gif" alt="animated">
                    <?php
                }
                else {
                    // Fetch conversation messages (sending handled earlier)
                    $res = mysqli_query($db, "SELECT * FROM `message` WHERE username='" . mysqli_real_escape_string($db, $_SESSION['chat_with']) . "';");
                    // Resolve student picture for current chat (no session writes)
                    $student_pic = get_student_pic($db, $_SESSION['chat_with']);
?>
                    <div style="height:70px; width: 100%; text-align: center; color:white;">
                    <h3><?php echo htmlspecialchars($_SESSION['chat_with'], ENT_QUOTES, 'UTF-8'); ?></h3>
                </div>

<div class="msg">


<?php
while($row=mysqli_fetch_assoc($res)) {
    if($row['sender']=='student')
    {

?>


<!-- ---------------student -------------- -->
 <br>   <div class="chat user">
        <div style="float:left; padding-top:5px;">
&nbsp;
<?php  
       echo "<img class='img-circle profile_img' height=40 width=40 src=\"../images/{$student_pic}\">";
    //    echo " " . $_SESSION['login_admin'] . "!";
    ?>
    &nbsp;
        </div>
        <div style="float:left;" class="chatbox">
     
            <?php
            echo $row['message'];

            ?>
        </div>
    </div>
<?php
    }
    else {

    
?>

<!-- ----------------------admin---------------- -->
  <br> <div class="chat Admin">
        <div style="float:left; padding-top:5px;">
&nbsp;
<?php  
       echo "<img class='img-circle profile_img' height=40 width=40 src='../images/user.jpg'>";
    //    echo " " . $_SESSION['login_admin'] . "!";
    ?>
    &nbsp;
        </div>
        <div style="float:left;" class="chatbox">
           
            <?php
            echo $row['message'];

            ?>

        </div>
    </div>

    <?php } } ?>

</div>
    <div style="height:100px; padding-top:10px;">
    <form action="" method="post" class="write">
        <input type="hidden" name="to" value="<?php echo htmlspecialchars($_SESSION['chat_with'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <input type="text" name="message" class="form-control" placeholder="Write Message..." style="float:left;" required>
        &nbsp; 
        <button class="btn btn-info btn-lg" type="submit" name="submit1"><span class="glyphicon glyphicon-send"></span> &nbsp Send</button>

    </form>
</div>
<!-- ----------------------------------------  -->
<?php
                }
            }
            ?>
            </div>
        </div>
    </div>
<script>
  (function () {
    document.querySelectorAll('.user-row').forEach(function (row) {
      row.addEventListener('click', function () {
        var uname = (row.dataset.username || '').trim();
        if (!uname) return;
        // Navigate via GET so PHP can open chat without relying on form submit
        window.location.href = 'message.php?u=' + encodeURIComponent(uname);
      });
    });
  })();
</script>


<script>
(function () {
  function scrollBottom() {
    const box = document.querySelector('.msg');
    if (!box) return;
    // Force in two ways 
    box.scrollTop = box.scrollHeight;
    const last = box.lastElementChild;
    if (last) last.scrollIntoView({block: 'end'});
  }

  // if load then go down
  if (document.readyState === 'complete') {
    requestAnimationFrame(scrollBottom);
  } else {
    window.addEventListener('load', () => requestAnimationFrame(scrollBottom));
  }
})();
</script>



</body>
</html>
<?php
    // End buffering and send output
    ob_end_flush();
?>
