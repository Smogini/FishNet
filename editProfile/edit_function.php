<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";
    
    $dbh = new DatabaseHelper();
    sec_session_start();
    
    switch ($_POST['action']) {
        case 'editUser':
            $current_user = $_SESSION['username'];
            $result = $dbh->editUser(
                $_POST['firstName'], 
                $_POST['lastName'], 
                $_POST['username'], 
                $_POST['password'], 
                $_POST['address'], 
                $_POST['dob'], 
                $current_user
            );
            
            if ($result) {
                if (login($_POST['username'], $_POST['password'], $dbh)) {
                    echo "edit_success";
                }
            } else {
                echo "result not true";
            }

            $dbh->closeConnection();
            break;

        default:
            break;
    }
}