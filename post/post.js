function initMap() {
    var map = L.map('map').setView([0, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([0, 0], { draggable: true }).addTo(map);

    marker.on('dragend', function (e) {
        var latlng = marker.getLatLng();
        document.getElementById('location').value = latlng.lat + ', ' + latlng.lng;
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initMap();
});


function confermaReset() {
    if (confirm("Are you sure?")) {
        window.location.href= "../home/home.php";
    }
}

function post() {
    let image = document.getElementById("fishImage").files[0];
    let description = document.getElementById("description").value; 
    let location = document.getElementById("location").value;

    let formData = new FormData();
    formData.append("action", "insertPost");
    formData.append("user_post", image);
    formData.append("description", description);
    formData.append("location", location);

    $.ajax({
        type: "POST",
        url: "post_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response === "post_success") {
                alert("Post saved successfully");
                window.location.href = "../home/home.php";
            } else {
                alert("Error saving the post");
            }
        },
    });
}