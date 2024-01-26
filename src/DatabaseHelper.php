<?php

class DatabaseHelper {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "fishnetdb");

        if (!$this->conn) {
            echo "Errore con la connessione al DB";
            return;
        }
    }

    public function insertUser($first, $last, $username, $pass, $addr, $dob) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $pass = hash('sha512', $pass.$random_salt);
        $query = "INSERT INTO users(first, last, username, password, salt, address, dob) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssssss", $first, $last, $username, $pass, $random_salt, $addr, $dob);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function retrieveUser($username) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($first, $last, $username, $pass, $salt, $addr, $dob);
            $result = array(
                'firstName' => $first,
                'lastName' => $last,
                'username' => $username,
                'password' => $pass,
                'salt' => $salt,
                'address' => $addr,
                'dateOfBirth' => $dob
            );
            return $result;
        }
    }
    
    public function editUser($first, $last, $username, $pass, $addr, $dob, $active_username) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $pass = hash('sha512', $pass.$random_salt);
        $query = "UPDATE users SET(first, last, username, password, salt, address, dob) VALUES (?, ?, ?, ?, ?, ?, ?) WHERE username ='?'";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssssss", $first, $last, $username, $pass, $random_salt, $addr, $dob, $active_username);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function dropUser($username) {
        $query = "DELETE FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    }

    public function insertImage($username, $name, $description, $image) {
        $image = base64_encode(file_get_contents(addslashes($image)));
        $query = "INSERT INTO users_profile_pics(`username`, `name`, `description`, `image`) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssss", $username, $name, $description, $image);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function retrieveProfilePic($username) {
        $query = "SELECT name, description, image FROM users_profile_pics WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name, $description, $image);
            $stmt->fetch();
            $post = array(
                'name' => $name,
                'description' => $description,
                'image' => $image
            );
            $stmt->close();
            return $post;
        }
        return array();
    }

    public function insertPost($username, $name, $description, $image, $location) {
        $image = base64_encode(file_get_contents(addslashes($image)));
        $query = "INSERT INTO users_posts(username, name, description, image, location) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sssss", $username, $name, $description, $image, $location);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function retrievePost($username) {
        $result = array();
        $query = "SELECT name, description, image, location FROM users_posts WHERE username = ?";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name, $description, $image, $location);
    
            while ($stmt->fetch()) {
                $post = array(
                    'name' => $name,
                    'description' => $description,
                    'image' => $image,
                    'location' => $location
                );
                $result[] = $post;
            }
            $stmt->close();
            return $result;
        }
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