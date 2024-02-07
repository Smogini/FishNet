<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";
    include_once "../src/initDB.php";

    $dbh = new DatabaseHelper(DB_NAME);
    sec_session_start();

    switch ($_POST['action']) {
        case 'search':
            $search_type = $_POST['search_type'];
            $search_value = $_POST['search_value'];

            if ($search_type === "account") {
                $result = $dbh->retrieveUsers($search_value);
            } elseif ($search_type === "fish") {
                $result = $dbh->retrieveFish($search_value);
            } elseif ($search_type === "location") {
                $result = $dbh->retrieveLocation($search_value);
            } else {
                echo "invalid_search_type";
                break;
            }

            if ($result) {
                foreach ($result as $item) {
                    generateSearchResult($item, $search_type);
                }
            } else {
                echo "{$search_type}_not_found";
            }
            break;
    }

    $dbh->closeConnection();
}

function generateSearchResult($data, $search_type) {
    $formId = $search_type . 'Form';
    $profilePic = isset($data['profile_pic']) ? $data['profile_pic'] : '';
    $image = isset($data['image']) ? $data['image'] : '';

    if ($search_type === "account" && $data['username'] === $_SESSION['username']) {
        return;
    }

    if ($data['username'] === $_SESSION['username']) {
        echo '<form id="' . $formId . '" method="get" action="../personalProfile/personalProfile.php">';            
    } else {
        echo '<form id="' . $formId . '" method="get" action="../userProfile/userProfile.php">';
    }
    echo
        '<div class="custom-result d-flex flex-wrap align-items-center mb-2 mr-2">
            <img id="profile_pic" alt="Profilo" class="profile-img square mr-3" src="data:image;base64,' . $profilePic . '">
            <div class="flex-grow-1">
                <h4>' . $data['username'] . '</h4>
            </div>
            <input type="hidden" name="user_visited" value="' . $data['username'] . '">
            <button type="submit" class="btn btn-primary mr-2">Visita <em class="bi bi-arrow-right ml-2"></em></button>';

            if ($search_type === "fish" || $search_type === "location") {
                echo
                '<img src="data:image;base64,' . $image . '" alt="Post Image" class="custom-post-img mr-3">';
            }

            if ($search_type === "fish" || $search_type === "location") {
                echo
                '<div class="custom-description">
                    <p>' . $data['description'] . '</p>
                    <p>' . $data['location'] .'</p>
                </div>';
            }

    echo 
        '</div>
    </form>';
}