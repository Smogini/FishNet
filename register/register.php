<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';

    $dbHelper = new DatabaseHelper();

    switch ($_POST['action']) {
        case 'insertUser':
            // if (isset($_POST['username']) && isset($_POST['password'])) {
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $address = $_POST['address'];
                $dob = $_POST['dob'];
                $profile_pic = $_POST['profile_pic'];

                $result = $dbHelper->insertUser($firstName, $lastName, $username, $password, $address, $dob, $profile_pic);

                if ($result) {
                    echo "register_success";
                } else {
                    error_log("Errore query");
                }
                $dbHelper->closeConnection();
            // }
            break;

        case 'dropUser':
            $username = $_POST['username'];
            $dbHelper->dropUser($username);
            break;

        default:
            echo "Azione non valida.";
            break;
    }
}

?>