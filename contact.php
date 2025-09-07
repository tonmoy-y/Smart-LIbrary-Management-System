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
          background: linear-gradient(135deg, rgba(10,25,47,0.86), rgba(25,50,80,0.80));
          border: 1px solid rgba(88,156,219,0.14);
          color: #eaf6ff;
          margin: 20px auto;
          padding: 22px;
          border-radius: 12px;
          box-shadow: 0 8px 30px rgba(4,18,35,0.6), inset 0 1px 0 rgba(255,255,255,0.02);
          backdrop-filter: blur(6px);
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
          table-layout: fixed;
          width: 820px;
          max-width: 100%;
          margin: 0 auto; /* center the table horizontally */
     }

     /* make borders visible on dark background and justify text in cells;
        last line of each cell will be centered (text-align-last:center) */
     .comment-table td, .comment-table th {
          vertical-align: middle !important;
          color: #fff;
          border: 1px solid rgba(255,255,255,0.12) !important;
          background: rgba(0,0,0,0.25);
          padding: 12px;
          word-break: break-word;
          text-align: justify;
          text-justify: inter-word;
          -webkit-text-size-adjust: 100%;
          text-align-last: center; /* center the last line */
     }

     /* header centered to match your request */
     .comment-table th {
          text-align: center;
          font-weight: 600;
     }

     .reply-column {
          width: 300px;
          max-width: 320px;
     }

     /* compact reply display */
     .admin-reply-box {
          background: transparent;
          border-left: 3px solid rgba(88,156,219,0.18);
          padding: 6px 8px;
          border-radius: 0;
          font-size: 13px;
          color: #eef6ff;
          max-height: 120px;
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

     /* Mobile-only adjustments */
     @media (max-width: 576px) {
          .wrap { width: calc(100% - 20px); margin: 10px; padding: 16px; }
          .input-box .form-control { width: 100%; height: 52px; display: block; }
          .input-box .btn-submit { width: 100%; height: 44px; display: block; margin-left: 0; margin-top: 8px; }
          .comment-table { width: 100%; }
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
          // Require login to comment (PHP-side)
          if(!isset($_SESSION['login_user'])) {
               ?>
               <script type="text/javascript">
               Swal.fire({
                    title: "Please log in",
                    text: "Please log in to comment.",
                    icon: "info",
                    confirmButtonText: "Go to Login",
                    confirmButtonColor: "#589cdbff"
               }).then(() => { window.location = "login"; });
               </script>
               <?php
               exit;
          }
           $comment = trim($_POST['comment']);
           if($comment !== '') {
               $user = $_SESSION['login_user'];
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
     if(isset($_SESSION['login_user'])) {
          $lu = $_SESSION['login_user'];
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
     // Header: only Comment and Reply (no username, no reply form)
     echo "<thead><tr><th>Comment</th><th class='reply-column'>Admin's Reply</th></tr></thead>";
     echo "<tbody>";
     while ($row=mysqli_fetch_assoc($res)) {
          echo "<tr>";
          // show only comment (no username)
          echo "<td>".nl2br(htmlspecialchars($row['comment']))."</td>";
          // Reply column
          echo "<td>";
          if(!isset($_SESSION['login_user'])) {
               echo "<em>Please log in to view admin's reply</em>";
          } else if(!empty($row['admin_reply'])) {
               echo "<div class='admin-reply-box'>".nl2br(htmlspecialchars($row['admin_reply']))."</div>";
          } else {
               echo "-";
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