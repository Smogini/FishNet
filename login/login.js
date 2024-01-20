function login() {
    let user = document.getElementById("username").value;
    let pass = document.getElementById("password").value;

    $.ajax({
        type: "POST",
        url: "process_login.php",
        data: {
            action: "login",
            username: user,
            password: pass
        },
        success: function() {
            // window.location.href = "process_login.php";
            console.log(user + " " + pass);
        },
        error: function() {
            alert("Login sbagliato");
        }
    });
}

function forgotPassword() {
    /*TODO*/
    alert("Funzione non ancora implementata")
}