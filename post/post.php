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
    <title>FishNet Post</title>
    <link rel="stylesheet" href="post.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>

<div class="container-fluid custom-container">
    <div class="rows">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <img id="logoSocial" alt="Logo Social" class="img-fluid mr-3" src="../img/logo.png">
            <div class="name">
                <h2 id="nomeSocial">New Post</h2>
            </div>
            <iem class="bi bi-bell clickable ml-auto" onclick="apriPopupNotifiche()"></em>
        </div>
    </div>
    <div class="rows">
        <div class="form">
            <form action="post.php" method="post" enctype="multipart/form-data">
                <label for="fishImage">New Photo:</label>
                <input type="file" name="fishImage" id="fishImage" accept="image/*" required>
                
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="4" required></textarea>
        
                <label for="location">Location:</label>
                <input type="text" name="location" id="location" required readonly>
                
                <div id="map"></div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit" onclick="post()">Post</button>
                    <a class="btn btn-danger" onclick="confermaReset()">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="post.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>