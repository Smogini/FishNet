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
    <title>FishNet Home</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>

<div class="container-fluid custom-container">
    <div class="row">
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
    
    
    <div class="row">
        <div class="col-12">
            <div class="scrollable-field">
                <div class="post">
                    <div class="d-flex align-items-center mb-3">
                        <img id="immagineProfilo" alt="Profilo" class="profile-img square mr-3" src="#">
                        <div>
                            <h2 id="nomeUtente">Nome Utente</h2>
                            <p id="dataCreazione"></p>
                        </div>
                        <a href="../profile/profile.html" class="btn btn-primary ml-auto mr-3">Visita <em class="bi bi-arrow-right ml-2"></em></a>
                    </div>
            
                    <div class="d-flex align-items-center">
                        <img src="path-to-post-image.jpg" alt="Post Image" class="post-img mr-3">
                        <div>
                            <p>Descrizione del post con testo</p>
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
                <a href="../profile/profile.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-person-circle"></em>                    
                    <span class="ml-2">Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="home.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>