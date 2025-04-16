<?php

if (isset($_GET['id'])) {
    $action = $_GET['act'];
    $user_id = $_GET['id'];

    if ($action == 'lock') {
        lock_user($user_id);
        header("Location: index.php?ac=account");
        
    } else if ($action == 'unlock') {
        unlock_user($user_id);
        header("Location: index.php?ac=account");
    }
}