<?php

include_once '../src/DatabaseHelper.php';
include_once '../lib/functions.php';

$dbh = new DatabaseHelper();

sec_session_start();
if(login_check($dbh)) { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FishNet Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="container-fluid custom-container">
    <div class="row">
        <div class="col-12 d-flex align-items-center">
            <img id="immagineProfilo" alt="Profilo" class="img-fluid mr-3" src="#">
            <div>
                <h2 id="nomeUtente">Nome Utente</h2>
                <p id="dataCreazione"></p>
            </div>
            <a href="../editProfile/editProfile.html" class="btn btn-primary ml-auto mr-2">Edit <em class="bi bi-arrow-right ml-2"></em></a>
            <a href="../lib/logout.php" class="btn btn-primary" onclick="return confirm('Are you sure?');">Logout <em class="bi bi-x-circle-fill ml-2"></em></a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="scrollable-field">
                <div class="post">
                    <div class="d-flex align-items-center">
                        <img src="path-to-post-image.jpg" alt="Post Image" class="post-img mr-3">
                        <div>
                            <p>Descrizione del post con testo</p>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="d-flex align-items-center">
                        <img src="path-to-post-image.jpg" alt="Post Image" class="post-img mr-3">
                        <div>
                            <p>Descrizione del post con testo e dettagli...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row fixed-bottom">
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

<script src="profile.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>