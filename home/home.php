<?php

include_once '../src/DatabaseHelper.php';
include_once '../lib/functions.php';

$dbh = new DatabaseHelper();

sec_session_start();
if(login_check($dbh)) { 
    $current_user = $_SESSION['username'];
    $following = $dbh->retrieveFollowings($current_user);
    $home_feed = $dbh->retrieveHomeFeed($current_user);
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishNet Home</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../src/style.css">
    <link rel="stylesheet" href="home.css">
</head>
<body class="custom-container">

<div class="container-fluid">
    <div class="row-name">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img id="logoSocial" alt="Logo Social" class="img-fluid mr-3" src="../img/logo.png">
                <div>
                    <h2 id="nomeSocial">FishNet</h2>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <em class="bi bi-bell clickable" onclick="apriPopupNotifiche()"></em>
            </div>
        </div>
    </div>
    
    
    <div class="row-scroll">
        <div class="col-12">
            <div id="scrollable" class="custom-scrollable-field">
                <div>
                    <?php
                    if (count($home_feed) > 0) {
                        foreach ($home_feed as $post) {
                            echo
                            '<form method="get" action="../userProfile/userProfile.php">
                                <div class="custom-post">
                                    <div class="d-flex align-items-center mb-3">
                                        <img id="immagineProfilo" alt="Profilo" class="profile-img square mr-3" src="data:image;base64,' . $post['profile_pic'] . '">
                                        <div>
                                            <h2>' . $post['username'] . '</h2>
                                            <p id="dataCreazione"></p>
                                        </div>
                                        <input type="hidden" name="user_visited" value="' . $post['username'] . '">
                                        <button type="submit" class="btn btn-primary ml-auto mr-3">Visita <em class="bi bi-arrow-right ml-2"></em></button>
                                    </div>
                                    <div class="d-flex">
                                        <img src="data:image;base64,' . $post['image'] . '" alt="Post Image" class="post-img mr-3 w-50">
                                        <div class="w-50">
                                            <p>' . $post['description'] . '</p>
                                            <p>' . $post['location'] . '</p>
                                            <button type="button" name="likeButton" data-post-id="' . $post['post_id'] . '" class="custom-like btn btn-primary ml-auto mr-2"></button>
                                            <button type="button" name="commentButton" data-post-id="' . $post['post_id'] . '" class="custom-comment btn btn-primary ml-auto mr-2" onclick="addComment(' . $post['post_id'] . ')"><em class="bi bi-chat-dots-fill"></em></button>';
                                            $comment_feed = $dbh->retrieveComments($post['post_id']);
                                            echo '<div class="scrollable-field mt-2 h-90">
                                                <textarea class="custom-textarea mt-2 w-100" readonly>';
                                                    foreach($comment_feed as $comment) {
                                                        echo $comment['username'] . ": " . $comment['comment'] . "&#13;&#10;";
                                                    }
                                                echo '</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>';
                        }
                    } else {

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row-bottom fixed-bottom">
        <div class="col-12">
            <div class="btn-group d-flex justify-content-between" role="group">
                <a href="../home/home.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-house"></em>
                    <span class="ml-2">Home</span>
                </a>
                <a href="../inputSearch/inputSearch.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-search"></em>
                    <span class="ml-2">Search</span>
                </a>
                <a href="../post/post.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-pencil"></em>
                    <span class="ml-2">Post</span>
                </a>
                <a href="../personalProfile/personalProfile.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-person-circle"></em>                    
                    <span class="ml-2">Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="home.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>