<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';
    include_once "../src/initDB.php";
    
    $dbh = new DatabaseHelper(DB_NAME);
    sec_session_start();

    switch ($_POST['action']) {
        case 'insertPost':
            $username = $_SESSION['username'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            $image = $_FILES['user_post']['tmp_name'];
            $name = $_FILES['user_post']['name'];
            $fish_type = $_POST['fish_type'];
            
            $result = $dbh->insertPost($username, $name, $description, $image, $location,$fish_type);
            
            if ($result) {
                echo "post_success";
            }
            break;

        default:
            echo "Azione non valida.";
            break;
    }
    $dbh->closeConnection();
}