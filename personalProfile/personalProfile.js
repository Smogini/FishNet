function deletePost(post_id) {
    let formData = new FormData();
    formData.append("action", "deletePost");
    formData.append("post_id", post_id);

    $.ajax({
        type: "POST",
        url: "delete_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "delete_success") {
                location.reload();
            } else {
                alert("Error deleting post");
            }
        },
    });
}