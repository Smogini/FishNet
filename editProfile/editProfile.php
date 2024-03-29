<?php

include_once '../src/DatabaseHelper.php';
include_once '../lib/functions.php';
include_once "../src/initDB.php";

$dbh = new DatabaseHelper(DB_NAME);

sec_session_start();
if(login_check($dbh)) { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Edit your Profile</h3>
                </div>
                <div class="card-body">
                    <form id="registerForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" id="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" id="lastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="profileImage">Select your profile image:</label><br>
                            <input type="file" name="profileImage" id="profileImage" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary btn-block mr-5" onclick="editProfile()">Confirm</button>
                            <button type="button" class="btn btn-danger btn-block m-0" onclick="cancel()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="editProfile.js"></script>
</body>
</html>

<?php
$dbh->closeConnection();
} else {
    echo 'You are not authorized to access this page, please login. <br/>';
}?>
