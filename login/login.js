function login() {
    /*TODO*/
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    if (username === "utente" && password === "password") {
        alert("Login riuscito!");
    } else {
        alert("Credenziali non valide. Riprova.");
    }
}

function forgotPassword() {
    /*TODO*/
    alert("Funzione non ancora implementata")
}