<?php
    session_start();
    if(isset($_SESSION['login_user'])) {
        unset($_SESSION['login_user']); // Unset the session variable
        unset($_SESSION['pic']); // Unset the profile picture session variable
        session_destroy(); // Destroy the session
    } 
    
    header("Location: ../index.php"); // Redirect to the index page

?>