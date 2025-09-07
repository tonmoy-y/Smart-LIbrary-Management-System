<?php
// include database connection file
     include "connection.php";
     include "navbar.php";
     if (isset($_SESSION['admin_reset'])) {
         unset($_SESSION['admin_reset']);
        unset($_SESSION['admin_reset_time']);
        echo "<script>window.location = '../index';</script>";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Feedback</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <style type=text/css>
     body {
          background-image: url("images/feedback.jpg");
     }
     .wrap {
          width: 900px;
          background-color: rgba(0,0,0,0.8);
          color: white;
          margin: 20px auto;
          padding: 20px;
          border-radius: 10px;
     }

     /* Input area box */
     .input-box {
          background: #ffffff11;
          border: 1px solid #ffffff33;
          padding: 15px;
          border-radius: 8px;
          margin-bottom: 15px;
     }

     .input-box .form-control {
          height: 60px;
          width: calc(100% - 130px);
          display: inline-block;
          vertical-align: top;
          background: #fff;
          color: #000;
     }

     .input-box .btn-submit {
          width: 110px;
          height: 60px;
          display: inline-block;
          vertical-align: top;
          margin-left: 10px;
     }

     /* Comment listing area - visually distinct */
     .comment-box {
          width: 100%;
          max-height: 360px;
          overflow: auto;
          background: #ffffff0f;
          border: 1px solid #ffffff22;
          padding: 10px;
          border-radius: 8px;
     }

     .comment-table {
          border-collapse: collapse;
     }

     /* make borders visible on dark background */
     .comment-table td, .comment-table th {
          vertical-align: middle !important;
          color: #fff;
          border: 1px solid rgba(255,255,255,0.12) !important;
          background: rgba(0,0,0,0.25);
     }

     .reply-column {
          width: 280px;
          max-width: 320px;
     }

     /* compact reply display */
     .admin-reply-box {
          background: #ffffff11;
          padding: 6px;
          border-radius: 6px;
          font-size: 13px;
          max-height: 140px;
          overflow: auto;
     }

     .reply-form-textarea {
          height: 40px !important;
          resize: vertical;
     }

     form.write {
            width: 100%;
          }

form.write input.form-control {
            max-width: none;
            width: 100%;
}

     /* Mobile-only adjustments to match root contact */
     @media (max-width: 576px) {
          .wrap { width: calc(100% - 20px); margin: 10px; padding: 16px; }
          .input-box .form-control { width: 100%; height: 52px; display: block; }
          .input-box .btn-submit { width: 100%; height: 44px; display: block; margin-left: 0; margin-top: 8px; }
          .comment-table { width: 100%; table-layout: fixed; }
          .reply-column { max-width: 50%; width: auto; }
     }

     </style>

</head>
<body>

     <div class="wrap">
          <h4>If you have any suggestion or question please write here</h4>
     <div class="input-box">
     <form class="write" action="" method="post">

          <textarea class="form-control" name="comment" placeholder="write something...." required style="resize:vertical; height:60px;"></textarea>

          <button class="btn btn-default btn-submit" type="submit" name="submit">Comment</button>
     </form>
     </div>
     <br>
     <div class="scroll">


     <?php

     // Ensure comments table has an admin_reply column. If not present, this will fail silently.
     // (Note: ALTER TABLE requires appropriate DB privilege; if not available, run manually.)
     $ensure_reply_col = "ALTER TABLE `comments` ADD COLUMN IF NOT EXISTS admin_reply TEXT NULL";
     @mysqli_query($db, $ensure_reply_col);

     // Handle posting a new comment
     if(isset($_POST['submit'])) {
          $comment = trim($_POST['comment']);
          if($comment !== '') {
               $user = isset($_SESSION['login_admin']) ? $_SESSION['login_admin'] : 'Guest';
               $stmt = mysqli_prepare($db, "INSERT INTO `comments` (`username`, `comment`) VALUES (?, ?)");
               if($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ss', $user, $comment);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
               } else {
                    mysqli_query($db, "INSERT INTO `comments` (`username`, `comment`) VALUES ('".mysqli_real_escape_string($db,$user)."','".mysqli_real_escape_string($db,$comment)."')");
               }
               // reload to show the comment list (PRG pattern)
               echo "<script>window.location='contact'</script>";
               exit;
          } else {
               ?>
               <script type="text/javascript">
               Swal.fire({
                    title: "Error!",
                    text: "Please write something before comment.",
                    icon: "warning",
                    confirmButtonText: "I Understand",
                    confirmButtonColor: "#589cdbff"
               }).then(() => { window.location = "contact"; });
               </script>
               <?php
          }
     }

     // Determine if current user is admin by checking the admin table
     $is_admin = false;
     if(isset($_SESSION['login_admin'])) {
          $lu = $_SESSION['login_admin'];
          $s = mysqli_prepare($db, "SELECT `username` FROM `admin` WHERE `username` = ? LIMIT 1");
          if($s) {
               mysqli_stmt_bind_param($s, 's', $lu);
               mysqli_stmt_execute($s);
               mysqli_stmt_store_result($s);
               if(mysqli_stmt_num_rows($s) > 0) $is_admin = true;
               mysqli_stmt_close($s);
          } else {
               // fallback: simple query
               $r = mysqli_query($db, "SELECT `username` FROM `admin` WHERE `username`='".mysqli_real_escape_string($db,$lu)."' LIMIT 1");
               if($r && mysqli_num_rows($r) > 0) $is_admin = true;
          }
     }

     // Handle admin reply submission (only proceed if user is admin)
     if(isset($_POST['reply_submit']) && $is_admin) {
          $reply = trim($_POST['reply_text'] ?? '');
          $comment_id = intval($_POST['comment_id'] ?? 0);
          if($comment_id > 0 && $reply !== '') {
               // Only allow a reply if none exists yet (one reply per message)
               $check = mysqli_query($db, "SELECT admin_reply FROM `comments` WHERE id=".$comment_id." LIMIT 1");
               $allow = true;
               if($check && $rrow = mysqli_fetch_assoc($check)) {
                    if(!empty($rrow['admin_reply'])) $allow = false;
               }
               if($allow) {
                    $stmt = mysqli_prepare($db, "UPDATE `comments` SET `admin_reply` = ? WHERE `id` = ?");
                    if($stmt) {
                         mysqli_stmt_bind_param($stmt, 'si', $reply, $comment_id);
                         mysqli_stmt_execute($stmt);
                         mysqli_stmt_close($stmt);
                    } else {
                         mysqli_query($db, "UPDATE `comments` SET `admin_reply`='".mysqli_real_escape_string($db,$reply)."' WHERE `id`=".$comment_id);
                    }
               }
          }
          echo "<script>window.location='contact'</script>";
          exit;
     }

     // Display comments
     $q = "SELECT * FROM `comments` ORDER BY id DESC;";
     $res = mysqli_query($db,$q);
     echo "<div class='comment-box'>";
     echo "<table class='table table-bordered comment-table'>";
     // Header: show Reply column (label changes for admin)
     echo "<thead><tr><th>User</th><th>Comment</th>";
     if($is_admin) {
          echo "<th class='reply-column'>Admin Reply</th>";
     } else {
          echo "<th class='reply-column'>Reply</th>";
     }
     echo "</tr></thead>";
     echo "<tbody>";
     while ($row=mysqli_fetch_assoc($res)) {
          echo "<tr>";
          echo "<td>".htmlspecialchars($row['username'])."</td>";
          echo "<td>".nl2br(htmlspecialchars($row['comment']))."</td>";
          // Reply column: if admin logged in, show a form to submit reply and show existing reply
          echo "<td>";
          if($is_admin) {
               // show existing reply (compact)
               if(!empty($row['admin_reply'])) {
                    echo "<div class='admin-reply-box' style='margin-bottom:8px;'>".nl2br(htmlspecialchars($row['admin_reply']))."</div>";
               } else {
                    // show reply form only when no reply exists
                    echo "<form method='post' style='margin:0'>";
                    echo "<input type='hidden' name='comment_id' value='".intval($row['id'])."'>";
                    echo "<textarea name='reply_text' class='form-control reply-form-textarea' placeholder='Write reply...' style='margin-bottom:6px;'></textarea>";
                    echo "<button type='submit' name='reply_submit' class='btn btn-primary' style='width:100%'>Reply</button>";
                    echo "</form>";
               }
          } else {
               // If not admin, display reply if exists, otherwise a dash
               if(!empty($row['admin_reply'])) {
                    echo "<div class='admin-reply-box'>".nl2br(htmlspecialchars($row['admin_reply']))."</div>";
               } else {
                    echo "-";
               }
          }
          echo "</td>";
          echo "</tr>";
     }
     echo "</tbody></table>";
     echo "</div>";

     ?>
</div>
</div>


</body>
</html>