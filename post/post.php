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
    <link rel="stylesheet" href="../src/style.css">
</head>
<body class="custom-container">

<div>
    <div class="row-name">
        <div class="col-12 align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img id="logoSocial" alt="Logo Social" class="img-fluid mr-3" src="../img/logo.png">
                <div>
                    <h2 id="nomeSocial">FishNet</h2>
                </div>
                <em class="bi bi-bell clickable ml-auto" onclick="apriPopupNotifiche()"></em>
            </div>
        </div>
    </div>

    <div class="row-form">
        <div class="form">
            <form enctype="multipart/form-data">
                <label class="m-2" for="fishImage">Upload Photo:</label>
                <input class="m-2" type="file" name="fishImage" id="fishImage" accept="image/*" required>
                
                <label class="m-2" for="description">Description:</label>
                <textarea class="m-2" name="description" id="description" rows="4" required></textarea>
        
                <label class="m-2" for="location">Location:</label>
                <input class="m-2" type="text" name="location" id="location" required>
                
                <div class="m-2" id="map"></div>
            </form>
        </div>
    </div>
    <div class="row-bottom fixed-bottom d-flex">
        <button class="custom-button btn btn-primary" type="button" onclick="post()">Post</button>
        <a class="custom-button btn btn-danger ml-auto" onclick="confermaReset()">Cancel</a> 
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="post.js"></script>
</body>
</html>

<?php 
} else { 
    echo 'You are not authorized to access this page, please login. <br/>';
}?>
