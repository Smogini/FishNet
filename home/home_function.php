<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";

    $dbh = new DatabaseHelper();
    sec_session_start();

    switch ($_POST['action']) {
        case 'liking':

            $result = $dbh->isLiking($_SESSION['username'], $_POST['post_id']);
            
            if ($result) {
                echo "liking_success";
            } else {
                echo "not_liking";
            }
            break;
        case 'addLike':

            $result = $dbh->insertLike($_SESSION['username'], $_POST['post_id']);

            if ($result) {
                echo "like_added";
            }
            break;
        case 'removeLike':

            $result = $dbh->removeLike($_SESSION['username'], $_POST['post_id']);

            if ($result) {
                echo "like_removed";
            }
            break;
        default:
            break;
    }
}