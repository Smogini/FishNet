<?php

function login($email, $password, $mysqli) {
    // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")) { 
       $stmt->bind_param('s', $email); // esegue il bind del parametro '$email'.
       $stmt->execute(); // esegue la query appena creata.
       $stmt->store_result();
       $stmt->bind_result($user_id, $username, $db_password, $salt); // recupera il risultato della query e lo memorizza nelle relative variabili.
       $stmt->fetch();
       $password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.
       if($stmt->num_rows == 1) { // se l'utente esiste
          // verifichiamo che non sia disabilitato in seguito all'esecuzione di troppi tentativi di accesso errati.
          if(checkbrute($user_id, $mysqli) == true) { 
             // Account disabilitato
             // Invia un e-mail all'utente avvisandolo che il suo account è stato disabilitato.
             return false;
          } else {
          if($db_password == $password) { // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
             // Password corretta!            
                $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.
  
                $user_id = preg_replace("/[^0-9]+/", "", $user_id); // ci proteggiamo da un attacco XSS
                $_SESSION['user_id'] = $user_id; 
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // ci proteggiamo da un attacco XSS
                $_SESSION['username'] = $username;
                $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                // Login eseguito con successo.
                return true;    
          } else {
             // Password incorretta.
             // Registriamo il tentativo fallito nel database.
             $now = time();
             $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
             return false;
          }
       }
       } else {
          // L'utente inserito non esiste.
          return false;
       }
    }
 }

?>