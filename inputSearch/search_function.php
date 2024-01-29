<?php

if (isset($_POST['action'])) {
    include_once "../src/DatabaseHelper.php";

    $dbh = new DatabaseHelper();

    switch ($_POST['action']) {
        case 'search':
            $search_type = $_POST['search_type'];
            $search_value = $_POST['search_value'];

            if ($search_type === "Account") {
                $result = $dbh->retrieveUsers($search_value);
                if ($result) {
                    foreach ($result as $user) {
                        $prof_pic = $dbh->retrieveProfilePic($user['username']);
                        echo 
                        '<div class="d-flex align-items-center mb-3">
                        <img id="immagineProfilo" alt="Profilo" class="profile-img square mr-3" src="data:image;base64,' . $prof_pic['image'] . '">
                        <div>
                                <h2 id="nomeUtente">' . $user['username'] . '</h2>
                            </div>
                            <a href="#" class="btn btn-primary ml-auto mr-3">Visita <em class="bi bi-arrow-right ml-2"></em></a>
                        </div>';
                    } 
                }
            } else if ($search_type === "Fish") {

            } else if ($search_type === "Location") {

            }

            break;
    }

}

?>