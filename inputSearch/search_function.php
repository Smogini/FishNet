<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";
    include_once "../lib/functions.php";

    $dbh = new DatabaseHelper();
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
                            '<form method="get" action="../userProfile/userProfile.php">
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

            } else if ($search_type === "Location") {

            }

            break;
    }

}

?>