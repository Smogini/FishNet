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

    public function insertUser($first, $last, $username, $pass, $addr, $dob, $profile_pic) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $pass = hash('sha512', $pass.$random_salt);
        $profilePicData = file_get_contents($profile_pic['tmp_name']);
        $query = "INSERT INTO users(first, last, username, password, salt, address, dob, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssb", $first, $last, $username, $pass, $random_salt, $addr, $dob, $profilePicData);
        $stmt->execute();
        $stmt->close();
    }

    public function dropUser($username) {
        $query = "DELETE FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
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