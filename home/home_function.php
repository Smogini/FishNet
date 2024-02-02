<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";

    $dbh = new DatabaseHelper();
    sec_session_start();
    $user = $_SESSION['username'];
    $post_id = $_POST['post_id'];

    switch ($_POST['action']) {
        case 'liking':

            $result = $dbh->isLiking($user, $post_id);
            
            if ($result) {
                echo "liking_success";
            } else {
                echo "not_liking";
            }
            break;
        case 'addLike':

            $result = $dbh->insertLike($user, $post_id);

            if ($result) {
                echo "like_added";
            }
            break;
        case 'removeLike':

            $result = $dbh->removeLike($user, $post_id);

            if ($result) {
                echo "like_removed";
            }
            break;
        case 'insertComment':
            $comment = $_POST['comment'];

            $result = $dbh->insertComment($user, $post_id, $comment);

            if ($result) {
                echo "comment_added";
            }
            break;
        case 'showComments':

            $result = $dbh->retrieveComments($post_id);

            if ($result) {
                echo "comments_retrieved";
            }
            break;
        default:
            break;
    }
}