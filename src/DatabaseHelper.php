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

    public function dropUser($username) {
        $query = "DELETE FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
    }

    public function insertImage($username, $description) {
        $image = $_FILES['profile_pic']['tmp_name'];
        $name = $_FILES['profile_pic']['name'];
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

    public function retrieveImage($username) {
        $result = array();
        $query = "SELECT name, description, image FROM users_profile_pics WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name, $description, $image);
            $stmt->fetch();
            $stmt->close();

            array_push($result, $name, $description, $image);
        }
        return $result;
    }

    public function insertPost($username, $description, $location) {
        $image = $_FILES['user_post']['tmp_name'];
        $name = $_FILES['user_post']['name'];
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

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function prepareQuery($query) {
        return $this->conn->prepare($query);
    }

}
?>