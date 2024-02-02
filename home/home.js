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
                    button.setAttribute("onclick", "removeLike('" + post_id + "')");
                } else if (response === "not_liking") {
                    button.innerHTML = '<em class="bi bi-heart"></em>';
                    button.setAttribute("onclick", "addLike('" + post_id + "')");
                }
            },
        });
    });
});

function addLike(post_id) {
    let button = $(this);
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
            if (response === "like_added") {
                onbeforeunload();

                button.html('<em class="bi bi-heart-fill"></em>');
                button.attr("onclick", "removeLike('" + post_id + "')");
                
                location.reload();
                onload();
            } else {
                alert("Couldn't add the like!");
            }
        },
    });
}

function removeLike(post_id) {
    let button = $(this);
    let formData = new FormData();
    formData.append("action", "removeLike");
    formData.append("post_id", post_id);

    $.ajax({
        type: "POST",
        url: "home_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "like_removed") {
                onbeforeunload();

                button.html('<em class="bi bi-heart"></em>');
                button.attr("onclick", "addLike('" + post_id + "')");
                
                location.reload();
                onload();
            } else {
                alert("Couldn't remove the like!");
            }
        },
    });
}

window.onbeforeunload = function () {
    var scrollPos;
    let scroll = document.getElementById("scrollable");
    scrollPos = scroll.scrollTop;
    document.cookie = "scrollTop=" + scrollPos + "URL=" + window.location.href;
}

window.onload = function () {
    let scroll = document.getElementById("scrollable");
    if (document.cookie.includes(window.location.href)) {
        if (document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {
            var arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/);
            scroll.scrollTop = parseInt(arr[1]);
        }
    }
}