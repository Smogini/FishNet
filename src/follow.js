function follow() {
    let user_visited = document.getElementById("nomeUtente").textContent;
    
    let formData = new FormData();
    formData.append("action", "insertFollower");
    formData.append("followed_username", user_visited);

    $.ajax({
        type: "POST",
        url: "../src/follow_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "follow_success") {
                window.location.href = "../userProfile/userProfile.php?user_visited="  + user_visited;
            } else {
                alert("Error following new person");
            }
        },
    });
}

function removeFollow() {
    let user_visited = document.getElementById("nomeUtente").textContent;
    
    let formData = new FormData();
    formData.append("action", "removeFollower");
    formData.append("followed_username", user_visited);

    $.ajax({
        type: "POST",
        url: "../src/follow_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "remove_success") {
                window.location.href = "../userProfile/userProfile.php?user_visited="  + user_visited;
            } else {
                alert("Error removing the follow");
            }
        },
    });
}

document.addEventListener('DOMContentLoaded', function () {
    let user_visited = document.getElementById("nomeUtente").textContent;

    let formData = new FormData();
    formData.append("action", "isFollowing");
    formData.append("followed_username", user_visited);
    
    $.ajax({
        type: "POST",
        url: "../src/follow_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "isFollowing_success") {
                $("#followButton").text("Remove Follow");
                $("#followButton").attr("onclick", "removeFollow()");
            } else if (response === "unfollowed") {
                $("#followButton").text("Follow");
                $("#followButton").attr("onclick", "follow()");
            }
        },
    });
});