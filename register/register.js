function register() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value;
    let dateOfBirth = document.getElementById("dob").value;
    let prof_pic = document.getElementById("profileImage").files[0];

    if (!checkDate(dateOfBirth)) {
        alert("Please insert a valid date");
        return;
    }

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
                window.location.href = "../login/login.php";
            } else {
                dropUser(username);
                alert("Error during registration");
            }
        },
    });
}

function checkDate(date) {
    var currentDate = new Date();

    var parts = date.split('-');
    var userDate = new Date(parts[0], parts[1] - 1, parts[2]);

    if (userDate > currentDate) {
        return false;
    } else {
        return true;
    }
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