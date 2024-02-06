function search() {
    let search_type = getSelectedRadioButton();
    let search_value = document.getElementById("search").value;
    if (!search_type) {
        alert("No option selected");
        return;
    }

    let formData = new FormData();
    formData.append("action", "search");
    formData.append("search_type", search_type);
    formData.append("search_value", search_value);

    $.ajax({
        type: "POST",
        url: "search_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "user_not_found") {
                alert("User not found");
                return;
            } else if (response === "fish_not_found") {
                alert("Fish not found");
                return;
            }
            $("#search_result").html(response);
        },
    });
}

function getSelectedRadioButton() {
    let radioButtons = document.getElementsByName('searchRadio');

    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            return radioButtons[i].value;
        }
    }

    return null;
}