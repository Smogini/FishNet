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

            if ($search_type === "Account") {
                $result = $dbh->retrieveUsers($search_value);
                if ($result) {
                    foreach ($result as $user) {
                        if ($user['username'] != $_SESSION['username']) {
                            $prof_pic = $dbh->retrieveProfilePic($user['username']);
                            echo
                            '<label for="accountForm"></label>
                            <form id="accountForm" method="get" action="../userProfile/userProfile.php">
                                <div class="custom-result d-flex align-items-center mb-3">
                                    <img id="profile_pic" alt="Profilo" class="profile-img square mr-3" src="data:image;base64,' . $prof_pic['image'] . '">
                                    <div>
                                        <h3>' . $user['username'] . '</h3>
                                    </div>
                                    <input type="hidden" name="user_visited" value="' . $user['username'] . '">
                                    <button type="submit" class="btn btn-primary ml-auto mr-3">Visita <em class="bi bi-arrow-right ml-2"></em></button>
                                </div>
                            </form>';
                        }
                    }
                } else {
                    echo "user_not_found";
                }
            } else if ($search_type === "Fish") {
                $result = $dbh->retrieveFish($search_value);
                if ($result) {
                    foreach ($result as $post) {
                        echo
                        '<label for="fishForm"></label>
                        <form id="fishForm" method="get" action="../userProfile/userProfile.php">
                            <div class="custom-result d-flex align-items-center mb-3">
                                <img id="profile_pic" alt="Profilo" class="profile-img square mr-3" src="data:image;base64,' . $post['profile_pic'] . '">
                                <div>
                                    <h3>' . $post['username'] . '</h3>
                                </div>
                                <input type="hidden" name="user_visited" value="' . $post['username'] . '">
                                <button type="submit" class="btn btn-primary ml-auto mr-3">Visita <em class="bi bi-arrow-right ml-2"></em></button>
                            </div>
                            <div class="custom-result d-flex align-items-center mb-3">
                                <img src="data:image;base64,' . $post['image'] . '" alt="Post Image" class="post-img mr-3 w-10">
                                <div class="w-50">
                                    <p>' . $post['description'] . '</p>
                                    <p>' . $post['location'] . '</p>
                                </div>
                            </div>
                        </form>';
                    }
                } else {
                    echo "fish_not_found";
                }
            } else if ($search_type === "Location") {

            }
            break;
    }
    $dbh->closeConnection();
}