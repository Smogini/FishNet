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
        success: function(response) {
            if (response === "login_success") {
                window.location.href = "../home/home.html";
            } else if (response === "missing_data") {
                alert("Missing username or password");
            } else {
                alert("Incorrect username or password");
            }
        },
        error: function() {
            
        }
    });

}

function forgotPassword() {
    /*TODO*/
    alert("Funzione non ancora implementata")
}