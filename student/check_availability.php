<?php
    include "connection.php";
    header('Content-Type: application/json');

    $field = isset($_GET['field']) ? $_GET['field'] : '';
    $value = isset($_GET['value']) ? trim($_GET['value']) : '';

    $allowed = ['username' => 'username', 'email' => 'email', 'roll' => 'roll'];

    if (!isset($allowed[$field]) || $value === '') {
        echo json_encode(['available' => null]);
        exit;
    }

    $column = $allowed[$field];
    $stmt = mysqli_prepare($db, "SELECT 1 FROM `student` WHERE `$column`=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $taken = mysqli_stmt_num_rows($stmt) > 0;
    echo json_encode(['available' => !$taken]);
