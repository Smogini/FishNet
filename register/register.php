<?php

if (isset($_POST['action'])) {
    include_once '../src/DatabaseHelper.php';
    include_once '../lib/functions.php';

    $dbHelper = new DatabaseHelper();

    switch ($_POST['action']) {
        case 'insertUser':
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $address = $_POST['address'];
            $dob = $_POST['dob'];
            $image = $_FILES['profile_pic']['tmp_name'];
            $name = $_FILES['profile_pic']['name'];

            $user_result = $dbHelper->insertUser($firstName, $lastName, $username, $password, $address, $dob);
            $image_result = $dbHelper->insertImage($username, $name, $username . "_profile_pic", $image);
            
            if ($user_result && $image_result) {
                echo "register_success";
            }
            $dbHelper->closeConnection();
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