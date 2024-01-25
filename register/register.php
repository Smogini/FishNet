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

                $user_result = $dbHelper->insertUser($firstName, $lastName, $username, $password, $address, $dob);
                $image_result = $dbHelper->insertImage($username, $username . "_profile_pic");
                
                if ($user_result && $image_result) {
                    echo "register_success";
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