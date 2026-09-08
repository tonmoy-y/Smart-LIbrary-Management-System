<?php
    // PHP 8.1+ makes mysqli throw exceptions on error by default; this app is written
    // in the classic style (checking mysqli_query()'s return value), so restore the
    // pre-8.1 behavior of returning false instead of throwing.
    mysqli_report(MYSQLI_REPORT_OFF);
    $db = mysqli_connect("localhost","root","","library");
    /* server name, username (root),password, database name */

?>