<?php

class DatabaseHelper {
    private $conn;

    public function __construct($db_name = "") {
        $this->conn = new mysqli("localhost", "root", "", $db_name);
    
        if ($this->conn->connect_error) {
            exit("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function databaseExists($db_name) {
        $result = $this->conn->query("SHOW DATABASES LIKE '$db_name'");
        return $result->num_rows > 0;
    }
    
    private function executePreparedQuery($query, $params) {
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }

        $stmt->bind_param(...$params);
        $success = $stmt->execute();
        $stmt->close();

        if (!$success) {
            error_log("Error executing query: " . $this->conn->error);
            return false;
        }

        return true;
    }

    public function insertUser($first, $last, $username, $pass, $addr, $dob) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $pass = hash('sha512', $pass.$random_salt);
        $query = "INSERT INTO users(first, last, username, password, salt, address, dob) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = ["sssssss", $first, $last, $username, $pass, $random_salt, $addr, $dob];

        return $this->executePreparedQuery($query, $params);
    }

    public function retrieveUsers($username) {
        $query = "SELECT first, last, username, address, dob FROM users WHERE username LIKE ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }

        $searchUsername = '%' . $username . '%';
        $stmt->bind_param("s", $searchUsername);
    
        $stmt->execute();
    
        if ($stmt->error) {
            error_log("Error executing query: " . $stmt->error);
            return false;
        }
    
        $stmt->store_result();
    
        if ($stmt->num_rows === 0) {
            error_log("User not found: " . $username);
            $stmt->close();
            return null;
        }
    
        $stmt->bind_result($first, $last, $resultUsername, $addr, $dob);
    
        $result = array();
        while ($stmt->fetch()) {
            $post = array(
                'firstName' => $first,
                'lastName' => $last,
                'username' => $resultUsername,
                'address' => $addr,
                'dateOfBirth' => $dob
            );
            $result[] = $post;
        }

        $stmt->close();
        return $result;
    }
    
    public function editUser($first, $last, $username, $pass, $addr, $dob, $active_username) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $pass = hash('sha512', $pass.$random_salt);
        
        $query = "UPDATE users SET first = ?, last = ?, username = ?, password = ?, salt = ?, address = ?, dob = ? WHERE username = ?";
        $params = ["ssssssss", $first, $last, $username, $pass, $random_salt, $addr, $dob, $active_username];

        return $this->executePreparedQuery($query, $params);
    }

    public function dropUser($username) {
        $query = "DELETE FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    }

    public function retrieveFish($fish_type) {
        $query = "  SELECT P.username, P.image, P.description, P.location, PI.image
                    FROM users_posts as P, users as U, users_profile_pics as PI
                    WHERE U.username = PI.username
                    AND P.username = U.username
                    AND P.fish_type = ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }

        $stmt->bind_param("s", $fish_type);
        $stmt->execute();
    
        if ($stmt->error) {
            error_log("Error executing query: " . $stmt->error);
            return false;
        }
    
        $stmt->store_result();
    
        if ($stmt->num_rows === 0) {
            error_log("Fish not found: " . $fish_type);
            $stmt->close();
            return null;
        }
    
        $stmt->bind_result($username, $image, $description, $location, $profile_pic);
        $result = array();
        while ($stmt->fetch()) {
            $post = array(
                'username' => $username,
                'description' => $description,
                'image' => $image,
                'location' => $location,
                'profile_pic' => $profile_pic
            );
            $result[] = $post;
        }

        $stmt->close();
        return $result;
    }

    public function insertProfilePic($username, $name, $description, $image) {
        $image = base64_encode(file_get_contents(addslashes($image)));
        $query = "INSERT INTO users_profile_pics(username, name, description, image) VALUES (?, ?, ?, ?)";
        $params = ["ssss", $username, $name, $description, $image];

        return $this->executePreparedQuery($query, $params);
    }

    public function editProfilePic($username, $name, $description, $image) {
        $image = base64_encode(file_get_contents(addslashes($image)));
        $query = "UPDATE users_profile_pics SET name = ?, description = ?, image = ? WHERE username = ?";
        $params = ["ssss", $name, $description, $image, $username];

        return $this->executePreparedQuery($query, $params);
    }

    public function retrieveProfilePic($username) {
        $query = "SELECT name, description, image FROM users_profile_pics WHERE username = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log("Error preparing the query");
            return null;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $description, $image);
        
        if ($stmt->fetch()) {
            $post = array(
                'name' => $name,
                'description' => $description,
                'image' => $image
            );
            $stmt->close();
            return $post;
        }
        $stmt->close();
        return null;
    }

    public function insertPost($username, $name, $description, $image, $location, $fish_type) {
        $image = base64_encode(file_get_contents(addslashes($image)));
        $query = "INSERT INTO users_posts(username, name, description, image, location, fish_type) VALUES (?, ?, ?, ?, ?, ?)";
        $params = ["ssssss", $username, $name, $description, $image, $location, $fish_type];

        return $this->executePreparedQuery($query, $params);
    }

    public function retrievePost($username) {
        $result = array();
        $query = "SELECT id, name, description, image, location, fish_type FROM users_posts WHERE username = ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            error_log("Error preparing the query");
            return null;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($post_id, $name, $description, $image, $location, $fish_type);

        while ($stmt->fetch()) {
            $post = array(
                'post_id' => $post_id,
                'name' => $name,
                'description' => $description,
                'image' => $image,
                'location' => $location,
                'fish_type' => $fish_type
            );
            $result[] = $post;
        }
        $stmt->close();
        return $result;
    }

    public function deletePost($post_id) {
        $query = "DELETE FROM users_posts WHERE id = ?";
        $params = ["i", $post_id];

        return $this->executePreparedQuery($query, $params);
    }

    public function retrieveHomeFeed($username) {
        $result = array();
        $query = "  SELECT P.name, P.description, P.image, P.location, P.fish_type, PF.image, PF.username, P.id
                    FROM users_posts AS P, user_followers AS F, users_profile_pics AS PF
                    WHERE P.username = F.followed_username
                    AND PF.username = F.followed_username
                    AND F.follower_username = ?
                    ORDER BY P.id DESC";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            error_log("Error preparing the query");
            return null;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($name, $description, $image, $location, $fish_type, $profile_pic, $username, $post_id);

        while ($stmt->fetch()) {
            $post = array(
                'name' => $name,
                'description' => $description,
                'image' => $image,
                'location' => $location,
                'fish_type' => $fish_type,
                'profile_pic' => $profile_pic,
                'username' => $username,
                'post_id' => $post_id
            );
            $result[] = $post;
        }
        
        $stmt->close();
        return $result;
    }

    public function insertFollower($current_user, $followed_username) {
        $query1 = "INSERT INTO user_followers VALUES (?, ?)";
        $params1 = ["ss", $current_user, $followed_username];

        $query2 = "INSERT INTO user_notifications(username, username_sender, notification_type) VALUES (?, ?, ?)";
        $type = "follow";
        $params2 = ["sss", $followed_username, $current_user, $type];

        return $this->executePreparedQuery($query1, $params1) && $this->executePreparedQuery($query2, $params2);
    }

    public function removeFollower($current_user, $followed_username) {
        $query = "DELETE FROM user_followers WHERE follower_username = ? AND followed_username = ?";
        $params = ["ss", $current_user, $followed_username];

        return $this->executePreparedQuery($query, $params);
    }

    public function retrieveFollowings($current_user) {
        $query = "SELECT followed_username FROM user_followers WHERE follower_username = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }
        $stmt->bind_param("s", $current_user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username);
        $result = array();
        while ($stmt->fetch()) {
            $result[] = $username;
        }
        $stmt->close();

        return $result;
    }

    public function retrieveFollowers($current_user) {
        $query = "SELECT follower_username FROM user_followers WHERE followed_username = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }
        $stmt->bind_param("s", $current_user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username);
        $result = array();
        while ($stmt->fetch()) {
            $result[] = $username;
        }
        $stmt->close();

        return $result;
    }

    public function isFollowing($current_user, $followed_username) {
        $query = "SELECT * FROM user_followers WHERE follower_username = ? AND followed_username = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }

        $stmt->bind_param("ss", $current_user, $followed_username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function isLiking($current_user, $post_id) {
        $query = "SELECT * FROM liked_posts WHERE post_id = ? AND username = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }

        $stmt->bind_param("ss", $post_id, $current_user);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function insertLike($current_user, $post_id) {
        $query1 = "INSERT INTO liked_posts(post_id, username) VALUES (?, ?)";
        $params1 = ["ss", $post_id, $current_user];

        $query2 = "INSERT INTO user_notifications(username, username_sender, notification_type) VALUES ((SELECT username FROM users_posts WHERE id = ?), ?, ?)";
        $type = "like";
        $params2 = ["iss", $post_id, $current_user, $type];

        return $this->executePreparedQuery($query1, $params1) && $this->executePreparedQuery($query2, $params2);
    }

    public function removeLike($current_user, $post_id) {
        $query = "DELETE FROM liked_posts WHERE post_id = ? AND username = ?";
        $params = ["is", $post_id, $current_user];

        return $this->executePreparedQuery($query, $params);
    }

    public function countLikes($post_id) {
        $query = "SELECT COUNT(*) FROM liked_posts WHERE post_id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }

        $stmt->bind_param("i", $post_id);
        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            return $count;
        }
        $stmt->close();
        return 0;
    }

    public function insertComment($username, $post_id, $comment) {
        $query1 = "INSERT INTO user_comments(post_id, username, comment) VALUES (?, ?, ?)";
        $query2 = "INSERT INTO user_notifications(username, username_sender, notification_type) VALUES ((SELECT username FROM users_posts WHERE id = ?), ?, ?)";
    
        $stmt1 = $this->conn->prepare($query1);
        $stmt2 = $this->conn->prepare($query2);
    
        if (!$stmt1 || !$stmt2) {
            error_log("Error preparing the query");
            return false;
        }
    
        $type = "comment";
        $stmt1->bind_param("iss", $post_id, $username, $comment);
        $stmt2->bind_param("iss", $post_id, $username, $type);
        $result1 = $stmt1->execute();
        $result2 = $stmt2->execute();
        $stmt1->close();
        $stmt2->close();
    
        if ($result1 && $result2) {
            return true;
        } else {
            return false;
        }
    }

    public function retrieveComments($post_id) {
        $query = "SELECT id, username, comment FROM user_comments WHERE post_id = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $comment);
        $result = array();
        while ($stmt->fetch()) {
            $post = array(
                'username' => $username,
                'comment' => $comment
            );
            $result[] = $post;
        }
        $stmt->close();

        return $result;
    }

    public function controlNotifications($username) {
        $query = "SELECT username, notification_type FROM user_notifications WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error preparing the query");
            return false;
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $notification_type);
        $result = array();
        while ($stmt->fetch()) {
            $notification = array(
                'username' => $username,
                'notification_type' => $notification_type
            );
            $result[] = $notification;
        }
        $stmt->close();
        return $result;
    }

    public function retrieveNotifications($user) {
        $query1 = "SELECT notification_type, username_sender FROM user_notifications WHERE username = ? ORDER BY id DESC";
        $query2 = "DELETE FROM user_notifications WHERE username = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt2 = $this->conn->prepare($query2);
        if (!$stmt1 || !$stmt2) {
            error_log("Error preparing the query");
            return false;
        }
        $stmt1->bind_param("s", $user);
        $stmt2->bind_param("s", $user);
        $stmt1->execute();

        $stmt1->store_result();
        $stmt1->bind_result($type, $username_sender);
        $result = array();
        while ($stmt1->fetch()) {
            $post = array(
                'notification_type' => $type,
                'username_sender' => $username_sender
            );
            $result[] = $post;
        }
        $stmt1->close();
        $stmt2->execute();
        $stmt2->close();
        return $result;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function prepareQuery($query) {
        return $this->conn->prepare($query);
    }

}