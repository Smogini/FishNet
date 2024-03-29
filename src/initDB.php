<?php

    include_once 'DatabaseHelper.php';
    define("DB_NAME", "fishnetdb");

    $dbh = new DatabaseHelper();
    
    if ($dbh->databaseExists(DB_NAME)) {
        $dbh->closeConnection();
        return;
    }

    $query = "CREATE DATABASE " . DB_NAME;
    $stmt = $dbh->prepareQuery($query);

    if (!$stmt->execute()) {
        exit("Error creating DB " . DB_NAME);   
    }

    $query = "CREATE TABLE `fishnetdb`.`users` (
        `first` VARCHAR(16) NOT NULL ,
        `last` VARCHAR(16) NOT NULL ,
        `username` VARCHAR(30) PRIMARY KEY, 
        `password` VARCHAR(128) NOT NULL,
        `salt` VARCHAR(128) NOT NULL, 
        `address` VARCHAR(50) NOT NULL, 
        `dob` DATE NOT NULL
    )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`login_attempts` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(30) NOT NULL, 
            `time` VARCHAR(10) NOT NULL, 
            PRIMARY KEY (`id`),
            FOREIGN KEY (`username`) REFERENCES `users`(`username`) ON DELETE CASCADE
        )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`users_profile_pics` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(30) NOT NULL,
            `name` VARCHAR(20) NOT NULL,
            `description` VARCHAR(50) NOT NULL,
            `image` LONGBLOB NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`username`) REFERENCES `users`(`username`) ON DELETE CASCADE
        );";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`users_posts` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(30) NOT NULL,
            `name` VARCHAR(20) NOT NULL,
            `description` VARCHAR(50) NOT NULL,
            `image` LONGBLOB NOT NULL,
            `location` VARCHAR(40) NOT NULL,
            `fish_type` VARCHAR(40) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`username`) REFERENCES `users`(`username`) ON UPDATE CASCADE
        )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`liked_posts` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `post_id` INT NOT NULL,
            `username` VARCHAR(30) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`post_id`) REFERENCES `users_posts`(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`username`) REFERENCES `users`(`username`) ON DELETE CASCADE
        )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`user_followers` (
            `follower_username` VARCHAR(30) NOT NULL,
            `followed_username` VARCHAR(30) NOT NULL,
            PRIMARY KEY (`follower_username`, `followed_username`),
            FOREIGN KEY (`follower_username`) REFERENCES `users`(`username`) ON UPDATE CASCADE,
            FOREIGN KEY (`followed_username`) REFERENCES `users`(`username`) ON UPDATE CASCADE
        )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`user_comments` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `post_id` INT NOT NULL,
            `username` VARCHAR(30) NOT NULL,
            `comment` VARCHAR(100) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`post_id`) REFERENCES `users_posts`(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`username`) REFERENCES `users`(`username`) ON DELETE CASCADE
        )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $query = "CREATE TABLE `fishnetdb`.`user_notifications` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(30) NOT NULL,
            `username_sender` VARCHAR(30) NOT NULL,
            `notification_type` VARCHAR(15) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`username`) REFERENCES `users`(`username`) ON UPDATE CASCADE
        )";
    $stmt = $dbh->prepareQuery($query);
    if (!$stmt->execute()) {
        exit("Error creating table");
    }

    $dbh->closeConnection();