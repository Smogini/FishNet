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
    <title>Post</title>
    <link rel="stylesheet" href="post.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../src/style.css">
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
            <div class="d-flex align-items-center mr-3 notification">
                <span id="badge" class="badge"></span>
                <div class="dropdown">
                    <em class="bi bi-bell clickable dropbtn" onclick="apriPopupNotifiche()"></em>
                    <div id="custom_dropdown" class="dropdown-content"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form">
        <form enctype="multipart/form-data">
            <label class="m-1" for="fishImage">Upload Photo:</label>
            <input class="m-1" type="file" name="fishImage" id="fishImage" accept="image/*" required>

            <label class="m-1 mt-1" for="fish_type">Fish Type:</label>
            <input class="m-1" name="fish_type" id="fish_type" required>

            <label class="m-1" for="description">Description:</label>
            <textarea class="m-1" name="description" id="description" rows="3" required></textarea>

            <label class="m-1" for="location">Location:</label>
            <input class="m-1" type="text" name="location" id="location" required>

            <div class="m-1" id="map"></div>
        </form>
    </div>
    <div class="row-bottom fixed-bottom d-flex">
        <button class="custom-button btn btn-primary" type="button" onclick="post()">Post</button>
        <a class="custom-button btn btn-danger ml-auto" onclick="confermaReset()">Cancel</a> 
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../src/notification.js"></script>
<script src="post.js"></script>
</body>
</html>

<?php 
$dbh->closeConnection();
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>
