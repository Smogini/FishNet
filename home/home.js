function apriPopupNotifiche() {
    alert("Funzione non ancora implementata")
}

document.addEventListener('DOMContentLoaded', function () {
    let likeButtons = document.querySelectorAll('.custom-like');

    likeButtons.forEach(function(button) {
        let post_id = button.dataset.postId;
        let formData = new FormData();
        formData.append("action", "liking");
        formData.append("post_id", post_id);

        $.ajax({
            type: "POST",
            url: "home_function.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response === "liking_success") {
                    button.innerHTML = '<em class="bi bi-heart-fill"></em>';
                    button.setAttribute("onclick", "removeLike()");
                } else if (response === "not_liking") {
                    button.innerHTML = '<em class="bi bi-heart"></em>';
                    button.setAttribute("onclick", "addLike()");
                }
            },
        });
    });
});

// TODO
function addLike() {
    let formData = new FormData();
    formData.append("action", "addLike");
    formData.append("post_id", post_id);

    $.ajax({
        type: "POST",
        url: "home_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "isLiking_success") {
                $("#followButton").attr("onclick", "removeFollow()");
            } else if (response === "unfollowed") {
                $("#followButton").attr("onclick", "follow()");
            }
        },
    });
}

// TODO
function removeLike() {
    let formData = new FormData();
    formData.append("action", "removeLike");

    $.ajax({
        type: "POST",
        url: "home_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "isLiking_success") {
                $("#followButton").text("Remove Follow");
                $("#followButton").attr("onclick", "removeFollow()");
            } else if (response === "unfollowed") {
                $("#followButton").text("Follow");
                $("#followButton").attr("onclick", "follow()");
            }
        },
    });
}