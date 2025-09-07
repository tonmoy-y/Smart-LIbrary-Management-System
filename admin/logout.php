<?php
    session_start();
    if(isset($_SESSION['login_admin'])) {
        unset($_SESSION['login_admin']); // Unset the session variable
        unset($_SESSION['pic']); // Unset the profile picture session variable
        session_destroy(); // Destroy the session
    } 
    
    header("Location: ../index"); // Redirect to the index page

?>