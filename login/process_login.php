<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';
    
    $dbh = new DatabaseHelper();
    $dbh->sec_session_start();
    
    switch($_POST['action']) {
        case 'login':
            if(isset($_POST['username'], $_POST['password']) && ($_POST['username'] !== "" && $_POST['password'] !== "")) {
                $username = $_POST['username'];
                $password = $_POST['password']; // Recupero la password criptata.
                if(login($username, $password, $dbh)) {
                    echo "login_success";
                }
            } else {
                echo "missing_data";
            }
            break;
        
            default:
                echo "Azione non valida.";
                break;
    }
    $dbh->closeConnection();

}

?>