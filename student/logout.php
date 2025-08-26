<?php
    session_start();
    if(isset($_SESSION['login_user'])) {
        unset($_SESSION['login_user']); // Unset the session variable
    } 
    
    header("Location: ../index.php"); // Redirect to the index page

?>