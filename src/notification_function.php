<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";
    include_once "../src/initDB.php";

    $dbh = new DatabaseHelper(DB_NAME);
    sec_session_start();
    $user = $_SESSION['username'];
    
    switch ($_POST['action']) {
        case 'retrieveNotifications':
            
            $result = $dbh->retrieveNotifications($user);

            if (count($result) != 0) {
                foreach($result as $noti) {
                    $type_array = $noti['notification_type'];
                    $sender_array = $noti['username_sender'];
                    echo $type_array . $sender_array . " ";
                }
            } else {
                echo "failed_noti";
            }
            break;
        
        default:
            break;
    }
    $dbh->closeConnection();
}