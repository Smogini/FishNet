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

function post() {
    /*TODO*/
}