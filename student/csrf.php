<?php
// Lightweight CSRF protection. Include this after navbar.php (which starts
// the session) on any page with a state-changing POST form.

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="'.htmlspecialchars($_SESSION['csrf_token']).'">';
}

function csrf_verify() {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "<script>alert('Session expired or invalid request. Please try again.'); window.location='javascript:history.back()';</script>";
        exit;
    }
}
