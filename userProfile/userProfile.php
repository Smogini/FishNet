<?php

include_once '../src/DatabaseHelper.php';
include_once '../lib/functions.php';

$dbh = new DatabaseHelper();

sec_session_start();
if(login_check($dbh)) { 
    $current_user = $_SESSION['username'];
    $user_visited = $_GET['user_visited'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishNet Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="userProfile.css">
</head>
<body class="custom-container">

<div class="container-fluid">
    <div class="row-name">
        <div class="col-12 d-flex align-items-center">
            <?php
                $image_info = $dbh->retrieveProfilePic($user_visited);
                echo '<img class="img-fluid" src="data:image;base64,' . $image_info['image'] . '" />';
            ?>
            <div>
                <?php
                    echo '<h2 id="nomeUtente">' . $user_visited . '</h2>';
                ?>
                <p id="dataCreazione"></p>
            </div>
            <button type="button" id="followButton" class="btn btn-primary ml-auto mr-2"></button>
        </div>
    </div>

    <div class="row-scroll">
        <div class="col-12">
            <div class="scrollable-field">
                <?php
                    $result_post = $dbh->retrievePost($user_visited);
                    foreach ($result_post as $post) {
                        echo 
                            '<div class="post">
                                <div class="d-flex align-items-center">
                                    <img class="post-img mr-3" alt="' . $post['name'] . '" src="data:image;base64,'. $post['image'] .'" />
                                    <div class="post-description">
                                        <p>' . $post['description'] . '</p>
                                        <p>' . $post['location'] . '</p>
                                    </div>
                                </div>
                            </div>';
                    }
                ?>
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
<script src="userProfile.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>