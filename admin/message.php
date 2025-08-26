<?php
     include "connection.php";
     include "navbar.php";
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
    flex-row: row-warp;

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
                    <form method="post" enctype="multipart/form-data">
                        <input type="text" name="username" id="uname" "> 
                        <button type="submit" name="submit" class="btn btn-default">SHOW </button>

                    </form>
                </div>

                <div  class="list">
                <?php
                    echo "<table id='table' class='table'>";
                    while($res1=mysqli_fetch_assoc($sql1)) { 
                        echo "<tr>";
                            echo"<td width=65>"; echo "<img class='img-circle profile_img' 
                            height=60 width=60 src='../images/".$res1['pic']."'>"; echo"</td>"; 
                            
                            echo "<td style='vertical-align: middle;'>".$res1['username']."</td>";


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
            if(isset($_POST['submit'])) {
                $res=mysqli_query($db,"SELECT * FROM `message` WHERE username='$_POST[username]' ;");
                mysqli_query($db,"UPDATE `message` SET `status`='yes' WHERE sender='student' AND username='$_POST[username]';");
                if($_POST['username'] != '') {
                    $_SESSION['username'] = $_POST['username'];
                    // Fetch and set the user's pic
                    $pic_res = mysqli_query($db, "SELECT pic FROM student WHERE username='$_POST[username]'");
                    if ($pic_row = mysqli_fetch_assoc($pic_res)) {
                        $_SESSION['pic'] = $pic_row['pic'];
                    }
                }
                ?>
                <div style="height:70px; width: 100%; text-align: center; color:white;">
                    <h3> <?php echo $_SESSION['username'];  ?> </h3>
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
       echo "<img class='img-circle profile_img' height=40 width=40 src='../images/".$_SESSION['pic']." '>  ";
    //    echo " " . $_SESSION['login_user'] . "!";
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
       echo "<img class='img-circle profile_img' height=40 width=40 src='images/user.jpg'>  ";
    //    echo " " . $_SESSION['login_user'] . "!";
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
        <input type="text" name="message" class="form-control" placeholder="Write Message..." style="float:left;">
        &nbsp; 
        <button class="btn btn-info btn-lg" type="submit" name="submit1"><span class="glyphicon glyphicon-send"></span> &nbsp Send</button>

    </form>
</div>

                <?php
            }
// ----------------if submit is not  presssed----------------
            else {
                if(!isset($_SESSION['username']) || $_SESSION['username']=='') {
                    ?>
        <img style="margin:100px 80px;" src="images/tonor.gif" alt="animated">
                    <?php
                }
                else {
                    if(isset($_POST['submit1'])) {
                        mysqli_query($db,"INSERT INTO `message` VALUES ('','$_SESSION[username]','$_POST[message]','no', 'admin');");
                        $res=mysqli_query($db,"SELECT * FROM `message` WHERE username='$_SESSION[username]' ;");

                    }
                    else {
                $res=mysqli_query($db,"SELECT * FROM `message` WHERE username='$_SESSION[username]' ;");

                    }
                    ?>
                    <div style="height:70px; width: 100%; text-align: center; color:white;">
                    <h3> <?php echo $_SESSION['username'];  ?> </h3>
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
       echo "<img class='img-circle profile_img' height=40 width=40 src='images/".$_SESSION['pic']." '>  ";
    //    echo " " . $_SESSION['login_user'] . "!";
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
       echo "<img class='img-circle profile_img' height=40 width=40 src='images/user.jpg'>  ";
    //    echo " " . $_SESSION['login_user'] . "!";
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
        <input type="text" name="message" class="form-control" placeholder="Write Message..." style="float:left;">
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
   var table = document.getElementById('table'), rIndex;
   for (var i = 0; i < table.rows.length; i++) {
       table.rows[i].onclick = function () {
           rIndex = this.rowIndex;
           document.getElementById('uname').value = this.cells[1].innerHTML;
       }
   }
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
