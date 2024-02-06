function login() {
    let user = document.getElementById("username").value;
    let pass = document.getElementById("password").value;

    let formData = new FormData();
    formData.append("action", "login");
    formData.append("username", user);
    formData.append("password", pass);

    $.ajax({
        type: "POST",
        url: "process_login.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "login_success") {
                window.location.href = "../home/home.php";
            } else if (response === "missing_data") {
                alert("Missing username or password");
            } else {
                alert("Incorrect username or password");
            }
        },
    });
}