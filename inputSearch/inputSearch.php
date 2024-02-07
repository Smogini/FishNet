<?php

include_once '../src/DatabaseHelper.php';
include_once '../lib/functions.php';
include_once '../src/initDB.php';

$dbh = new DatabaseHelper(DB_NAME);

sec_session_start();
if(login_check($dbh)) { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="inputSearch.css">
    <link rel="stylesheet" href="../src/style.css">
</head>
<body class="custom-container">

<div class="container-fluid">
    <div class="row-name">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img id="logoSocial" alt="Logo Social" class="img-fluid mr-3" src="../img/logo.png">
                <div>
                    <h2 id="nomeSocial">Search</h2>
                </div>
            </div>
            <div class="d-flex align-items-center mr-3 notification">
                <span id="badge" class="badge"></span>
                <div class="dropdown">
                    <em class="bi bi-bell clickable dropbtn" onclick="apriPopupNotifiche()"></em>
                    <div id="custom_dropdown" class="dropdown-content"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row-search">
        <div class="form d-flex col-12 mt-2">
            <div class="input col-6 mt-1">
                <label for="search"></label>
                <input class="text mb-2 mt-2" type="text" name="search" id="search" placeholder="Search">
                <div class="searchButton mb-2">
                    <button type="button" class="btn btn-primary" onclick="search()">Search <em class="bi bi-search ml-2"></em></button>
                </div>
                <div class="scrollable-field" id="search_result"></div>
            </div>
            <div class="radio col-6 mt-1">
                <div class="searchRadio align-items-center">
                    <div class="pref mt-2">
                        <h3 class="h3" id="Preferences">Preferences:</h3>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="account" name="searchRadio" value="Account">
                        <label for="account">Account</label>
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

    <div class="row-bottom fixed-bottom">
        <div class="col-12">
            <div class="btn-group d-flex justify-content-between" role="group">
                <a href="../home/home.php" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
                    <em class="bi bi-house"></em>
                    <span class="ml-2">Home</span>
                </a>
                <a href="" class="btn btn-primary d-flex flex-fill justify-content-center align-items-center rounded ml-2 mr-2">
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
<script src="../src/notification.js"></script>
<script src="inputSearch.js"></script>
</body>
</html>

<?php
$dbh->closeConnection();
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>