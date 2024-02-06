<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';
    include_once '../src/initDB.php';

    $dbh = new DatabaseHelper(DB_NAME);
    sec_session_start();
    
    switch($_POST['action']) {
        case 'deletePost':
            
            $result = $dbh->deletePost($_POST['post_id']);

            if ($result) {
                echo "delete_success";
            }

            break;
        
        default:
            break;
    }
    $dbh->closeConnection();
}