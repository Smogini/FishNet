<?php

include_once '../src/DatabaseHelper.php';
include_once '../lib/functions.php';

$dbh = new DatabaseHelper();

sec_session_start();
if(login_check($dbh)) { 
    $current_user = $_SESSION['username'];
    $following = $dbh->retrieveFollowings($current_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishNet Following</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="following.css">
</head>
<body class="custom-container">

<div class="container-fluid">
    <div class="row-name">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img id="logoSocial" alt="Logo Social" class="img-fluid mr-3" src="../img/logo.png">
                <div>
                    <h2 id="nomeSocial">Following</h2>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <em class="bi bi-bell clickable" onclick="apriPopupNotifiche()"></em>
            </div>
        </div>
    </div>
    
    
    <div class="row-scroll">
        <div class="col-12">
            <div class="scrollable-field">
                <div class="follower">
                    <?php
                    
                    foreach ($following as $user) {
                        $profile_pic = $dbh->retrieveProfilePic($user);
                        echo 
                        '<form method="get" action="../userProfile/userProfile.php">
                            <div class="d-flex align-items-center mb-3">
                                <img id="immagineProfilo" alt="Profilo" class="profile-img square mr-3" src="data:image;base64,' . $profile_pic['image'] . '">
                                <div>
                                    <h2>' . $user . '</h2>
                                    <p id="dataCreazione"></p>
                                </div>
                                <input type="hidden" name="user_visited" value="' . $user . '">
                                <button type="submit" class="btn btn-primary ml-auto mr-3">Visita <em class="bi bi-arrow-right ml-2"></em></button>
                            </div>
                        </form>';
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
                <a href="../follower/follower.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-person"></em>
                    <span class="ml-2">Follower</span>
                </a>
                <a href="../following/following.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-people"></em>
                    <span class="ml-2">Following</span>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>