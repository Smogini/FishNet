function register() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value;
    let dateOfBirth = document.getElementById("dob").value;
    
    $.ajax({
        type: "POST",
        url: "register.php",
        data: {
            action: "insertUser",
            firstName: firstName,
            lastName: lastName,
            username: username,
            password: password,
            address: address,
            dob: dateOfBirth
        },
        success: function() {
            window.location.href = "../login/login.html";
        },
        error: function() {
            alert("Errore nell caricamento dei dati nel DB");
        }
    });
}