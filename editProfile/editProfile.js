function editProfile() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value;
    let dateOfBirth = document.getElementById("dob").value;
    let profile_pic = document.getElementById("profileImage").files[0];

    let formData = new FormData();
    formData.append("action", "editUser");
    formData.append("firstName", firstName);
    formData.append("lastName", lastName);
    formData.append("username", username);
    formData.append("password", password);
    formData.append("address", address);
    formData.append("dob", dateOfBirth);
    formData.append("profile_pic", profile_pic);

    $.ajax({
        type: "POST",
        url: "edit_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "edit_success") {
                window.location.href = "../personalProfile/personalProfile.php";
            } else {
                alert("Error during editing");
            }
        },
    });
}

function cancel() {
    if (confirm("Are you sure?")) {
        window.location.href = "../personalProfile/personalProfile.php";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let formData = new FormData();
    formData.append("action", "loadInfo");

    $.ajax({
        type: "POST",
        url: "edit_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.length > 0) {
                let userInfo = response.split(",");
                
                document.getElementById("firstName").value = userInfo[0];
                document.getElementById("lastName").value = userInfo[1];
                document.getElementById("username").value = userInfo[2];
                document.getElementById("address").value = userInfo[3];
                document.getElementById("dob").value = userInfo[4];
            }
        },
    });
});