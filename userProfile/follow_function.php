<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";

    $dbh = new DatabaseHelper();
    sec_session_start();

    switch ($_POST['action']) {
        case 'insertFollower':
            $current_user = $_SESSION['username'];
            $followed_username = $_POST['followed_username'];

            $result = $dbh->insertFollower($current_user, $followed_username);
            
            if ($result) {
                echo "follow_success";
            }
            break;
        case 'removeFollower':
            $current_user = $_SESSION['username'];
            $followed_username = $_POST['followed_username'];

            $result = $dbh->removeFollower($current_user, $followed_username);
                
            if ($result) {
                echo "remove_success";
            }
            break;
        case 'isFollowing':
            $current_user = $_SESSION['username'];
            $followed_username = $_POST['followed_username'];

            $result = $dbh->isFollowing($current_user, $followed_username);
            if($result) {
                echo "isFollowing_success";
            } else {
                echo "unfollowed";
            }
            break;
        default:
            break;
    }

}