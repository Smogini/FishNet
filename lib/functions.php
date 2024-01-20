<?php

function login($username, $password, $dbh) {
    // Tramite prepared query si evita un attacco di tipo SQL injection.
    $stmt = $dbh->prepareQuery("SELECT username, password, salt FROM users WHERE username = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $db_password, $salt);
        $stmt->fetch();
        $password = hash('sha512', $password);
        if($stmt->num_rows == 1) {
            if(checkbrute($username, $dbh)) {
                // Account disabilitato a causa dei troppi tentativi d'accesso
                error_log("Account disabilitato");
                return false;
            } else {
                error_log("DB: " . $db_password . " Pass: " . $password);
                if($db_password == $password) {
                    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.
  
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // ci proteggiamo da un attacco XSS
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                    $stmt->close();
                    // Login eseguito con successo.
                    error_log("Login con successo");
                    return true;    
                } else {
                    // Password incorretta, registra il tentativo fallito nel DB
                    $now = time();
                    error_log("Password incorretta -> " . $now);
                    $stmt = $dbh->prepareQuery("INSERT INTO login_attempts (username, time) VALUES (?, ?)");
                    $stmt->bind_param("ss", $username, $now);
                    $stmt->execute();
                    $stmt->close();
                    return false;
                }
            }
        } else {
            error_log("L'utente non esiste");
            // L'utente inserito non esiste.
            return false;
        }
    }
}

function checkbrute($username, $dbh) {
    $now = time();
    // Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
    $valid_attempts = $now - (2 * 60 * 60);
    $stmt = $dbh->prepareQuery("SELECT time FROM login_attempts WHERE username = ? AND time > '$valid_attempts'");
    if ($stmt) { 
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($dbh) {
    // Verifica che tutte le variabili di sessione siano impostate correttamente
    if(isset($_SESSION['username'], $_SESSION['login_string'])) {
      $username = $_SESSION['username'];
      $login_string = $_SESSION['login_string'];  
      $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.
      if ($stmt = $dbh->prepare("SELECT password FROM users WHERE username = ? LIMIT 1")) { 
         $stmt->bind_param('s', $username); // esegue il bind del parametro '$user_id'.
         $stmt->execute(); // Esegue la query creata.
         $stmt->store_result();
  
         if($stmt->num_rows == 1) { // se l'utente esiste
            $stmt->bind_result($password); // recupera le variabili dal risultato ottenuto.
            $stmt->fetch();
            $login_check = hash('sha512', $password.$user_browser);
            if($login_check == $login_string) {
               // Login eseguito!!!!
               return true;
            } else {
               //  Login non eseguito
               return false;
            }
         } else {
             // Login non eseguito
             return false;
         }
      } else {
         // Login non eseguito
         return false;
      }
    } else {
      // Login non eseguito
      return false;
    }
}  

?>