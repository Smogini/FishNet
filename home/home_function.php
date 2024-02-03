<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";

    $dbh = new DatabaseHelper();
    sec_session_start();
    $user = $_SESSION['username'];
    
    switch ($_POST['action']) {
        case 'liking':
            $post_id = $_POST['post_id'];

            $result = $dbh->isLiking($user, $post_id);
            $count = $dbh->countLikes($post_id);
            
            if ($result) {
                echo "liking_success" . $count;
            } else {
                echo "not_liking" . $count;
            }
            break;
        case 'addLike':
            $post_id = $_POST['post_id'];

            $result = $dbh->insertLike($user, $post_id);

            if ($result) {
                echo "like_added";
            }
            break;
        case 'removeLike':
            $post_id = $_POST['post_id'];

            $result = $dbh->removeLike($user, $post_id);

            if ($result) {
                echo "like_removed";
            }
            break;
        case 'insertComment':
            $post_id = $_POST['post_id'];
            $comment = $_POST['comment'];
            
            $result = $dbh->insertComment($user, $post_id, $comment);
            if ($result) {
                echo "comment_added";
            }

            break;
        case 'controlNotifications':

            $result = $dbh->controlNotifications($user);
            echo count($result);

            break;
        default:
            break;
    }
}