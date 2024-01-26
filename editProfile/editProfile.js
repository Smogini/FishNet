function editProfile() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let address = document.getElementById("address").value;
    let dateOfBirth = document.getElementById("dob").value;
    let prof_pic = document.getElementById("profileImage").files[0];

    let formData = new FormData();
    formData.append("action", "updateUser");
    formData.append("firstName", firstName);
    formData.append("lastName", lastName);
    formData.append("username", username);
    formData.append("password", password);
    formData.append("address", address);
    formData.append("dob", dateOfBirth);
    formData.append("profile_pic", prof_pic);

    $.ajax({
        type: "POST",
        url: "edit_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "edit_success") {
                window.location.href = "../profile/profile.php";
            } else {
                alert("Error during editing");
            }
        },
    });
}