<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';
    
    $dbh = new DatabaseHelper();
    sec_session_start();

    switch ($_POST['action']) {
        case 'insertPost':
            $username = $_SESSION['username'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            
            $result = $dbh->insertPost($username, $description, $location);

            if ($result) {
                echo "post_success";
            }
            $dbh->closeConnection();
            break;

        default:
            echo "Azione non valida.";
            break;
        }
}

?>