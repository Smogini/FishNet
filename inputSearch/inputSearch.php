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
    <title>FishNet inputSearch</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="inputSearch.css">
</head>
<body>

<div class="container-fluid custom-container">
    <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img id="logoSocial" alt="Logo Social" class="img-fluid mr-3" src="../img/logo.png">
                <div>
                    <h2 id="nomeSocial">Search</h2>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <em class="bi bi-bell clickable" onclick="apriPopupNotifiche()"></em>
            </div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="form d-flex col-12">
            <div class="input col-6">
                <label for="search">Search</label>
                <input class="text mb-2" type="text" name="search" id="search" placeholder="Search">
                <div class="searchButton mb-2">
                    <a href="../outputSearch/outputSearch.html" class="btn btn-primary">Search <em class="bi bi-search ml-2"></em></a>
                </div>
            </div>
            <div class="radio col-6">
                <div class="searchRadio col-6 align-items-center">
                    <div class="pref">
                        <h3 class="h3" id="Preferences">Preferences:</h3>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="person" name="searchRadio" value="Person">
                        <label for="person">Person</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="fish" name="searchRadio" value="Fish">
                        <label for="fish">Fish</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="location" name="searchRadio" value="Location">
                        <label for="location">Location</label>
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
                <a href="../search/search.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
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

<script src="inputSearch.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>