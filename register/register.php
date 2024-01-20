<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';

    $dbHelper = new DatabaseHelper();
    // $dbHelper->sec_connection_start();

    switch ($_POST['action']) {
        case 'insertUser':
            // if (isset($_POST['username']) && isset($_POST['password'])) {
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $address = $_POST['address'];
                $dob = $_POST['dob'];

                $result = $dbHelper->insertUser($firstName, $lastName, $username, $password, $address, $dob);

                if ($result) {
                    echo "Utente inserito con successo!";
                } else {
                    echo "Errore durante l'inserimento dell'utente.";
                }
                $dbHelper->closeConnection();
            // }
            break;

        default:
            echo "Azione non valida.";
            break;
    }
}

?>