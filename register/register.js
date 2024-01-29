function register() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value;
    let dateOfBirth = document.getElementById("dob").value;
    let prof_pic = document.getElementById("profileImage").files[0];

    let formData = new FormData();
    formData.append("action", "insertUser");
    formData.append("firstName", firstName);
    formData.append("lastName", lastName);
    formData.append("username", username);
    formData.append("password", password);
    formData.append("address", address);
    formData.append("dob", dateOfBirth);
    formData.append("profile_pic", prof_pic);

    $.ajax({
        type: "POST",
        url: "register.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "register_success") {
                window.location.href = "../login/login.html";
            } else {
                dropUser(username);
                alert("Error during registration");
            }
        },
    });
}

function dropUser(username) {
    $.ajax({
        type: "POST",
        url: "register.php",
        data: {
            action: "dropUser",
            username: username,
        }
    });
}