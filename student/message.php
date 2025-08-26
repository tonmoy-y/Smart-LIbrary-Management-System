<?php
     include "connection.php";
     include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
    <style type="text/css">
        body {
        background-image: url("images/message.png");
        /* background-color: red; */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
}
        .wrapper {
           height: 575px;
           width:500px;
           background-color: black;
           opacity: 0.8;
           color:white;
           margin: 0px auto;
           padding: 20px;
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
    height: 500px;
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
    order: -1;
}

.Admin .chatbox {
    background-color: white;
    color: black;
}
.chat.user {
    display: flex;
    justify-content: flex-end;
    align-items: flex-start;
}
    </style>
</head>
<body>

<?php
        if(isset($_POST['submit'])) {
            mysqli_query($db,"INSERT INTO `message` VALUES ('','$_SESSION[login_user]','$_POST[message]','no', 'student');");
            $res=mysqli_query($db, "SELECT * FROM `message` WHERE username='$_SESSION[login_user]';");

        }
        else {
            $res=mysqli_query($db, "SELECT * FROM `message` WHERE username='$_SESSION[login_user]';");
        
        }
        mysqli_query($db,"UPDATE `message` SET `status`='yes' WHERE sender='admin' AND username='$_SESSION[login_user]';");
    ?>

<div class="wrapper">
    <div style="height:70px; width:100%; background-color:#fe5d5d; color:white; text-align:center;">
        <h3 style="padding: 1px auto;">Admin</h3>

  
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
       echo "<img class='img-circle profile_img' height=40 width=40 src='../images/user.jpg'>  ";
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
        <button class="btn btn-info btn-lg" type="submit" name="submit"><span class="glyphicon glyphicon-send"></span> &nbsp Send</button>

    </form>
</div>

</div>

<script>
    // page load 
    var msgDiv = document.querySelector(".msg");
    msgDiv.scrollTop = msgDiv.scrollHeight;
</script>
    

</body>
</html>