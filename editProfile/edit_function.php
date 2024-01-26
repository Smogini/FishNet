<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";

    $dbh = new DatabaseHelper();
    sec_session_start();

    switch ($_POST['action']) {
        case 'editProfile':
            $current_user = $_SESSION['username'];
            $user_info = $dbh->retrieveUser($current_user);

            $result = $dbh->editProfile();

            if ($result) {
                echo "edit_success";
            }
            $dbh->closeConnection();
            break;

        case default:
            break;
    }
}

?>