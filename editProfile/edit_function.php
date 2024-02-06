<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";
    include_once "../src/initDB.php";
    
    $dbh = new DatabaseHelper(DB_NAME);
    sec_session_start();
    $current_user = $_SESSION['username'];
    
    switch ($_POST['action']) {
        case 'editUser':
            $result = $dbh->editUser(
                $_POST['firstName'], 
                $_POST['lastName'], 
                $_POST['username'], 
                $_POST['password'], 
                $_POST['address'], 
                $_POST['dob'],
                $current_user
            );

            $image = $_FILES['profile_pic']['tmp_name'];
            $name = $_FILES['profile_pic']['name'];
            
            if ($result) {
                $result = $dbh->editProfilePic($_POST['username'], $name, $_POST['username'] . "_profile_pic", $image);
                if ($result && login($_POST['username'], $_POST['password'], $dbh)) {
                    echo "edit_success";
                }
            }
            break;

        case 'loadInfo':
            
            $result = $dbh->retrieveUsers($current_user);
            if ($result) {
                $user = $result[0];
                echo $user['firstName'] . "," . $user['lastName'] . "," . $user['username'] . "," . $user['address'] . "," . $user['dateOfBirth'];;
            }
            break;
        default:
            break;
    }
    $dbh->closeConnection();
}