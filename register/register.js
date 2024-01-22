function register() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value;
    let dateOfBirth = document.getElementById("dob").value;
    let prof_pic = document.getElementById("profileImage").value;

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
            dob: dateOfBirth,
            profile_pic: prof_pic
        },
        success: function(response) {
            if (response === "register_success") {
                window.location.href = "../login/login.html";
            } else {
                // dropUser(username);
                alert("Error during registration");
            }
        },
        error: function() {
            
        }
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