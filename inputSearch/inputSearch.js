function search() {
    let search_type = getSelectedRadioButton();
    search_type = search_type.toLowerCase();
    let search_value = document.getElementById("search").value;

    if (!search_type) {
        alert("No option selected");
        return;
    }

    let formData = new FormData();
    formData.append("action", "search");
    formData.append("search_type", search_type);
    formData.append("search_value", search_value);

    if (search_value.length == 0) {
        alert("Search field is empty");
        return;
    }

    $.ajax({
        type: "POST",
        url: "search_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.includes("_not_found")) {
                response = response.replace("_not_found", "");
                alert(response + " not found");
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

function changePlaceholder() {
    $("#search").attr("placeholder", "Latitude, Longitude:");
}

function resetPlaceholder() {
    $("#search").attr("placeholder", "Search:");
}