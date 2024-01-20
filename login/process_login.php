<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';
    
    $dbh = new DatabaseHelper();
    $dbh->sec_session_start();
    
    switch($_POST['action']) {
        case 'login':
            if(isset($_POST['username'], $_POST['password'])) { 
                $username = $_POST['username'];
                $password = $_POST['password']; // Recupero la password criptata.
                error_log("Prima di controllare il login: " . $username . " " . $password);
                if(login($username, $password, $dbh)) {
                    error_log('Success: You have been logged in!');
                } else {
                    error_log("Credenziali non corrette");
                    header('Location: ./login.php?error=1');
                }
            } else { 
                // Le variabili corrette non sono state inviate a questa pagina dal metodo POST.
                error_log("Username e password non sono impostati");
                echo 'Invalid Request';
            }
            break;
        
            default:
                echo "Azione non valida.";
                break;
    }
    $dbh->closeConnection();

} else {
    error_log("Errore");
}

?>