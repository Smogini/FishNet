function apriPopupNotifiche() {
    document.getElementById("custom_dropdown").classList.toggle("show");
    let formData = new FormData();
    formData.append("action", "retrieveNotifications");

    $.ajax({
        type: "POST",
        url: "../src/notification_function.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response !== null) {
                let array_noti = response.split(" ");
                
                let dropdown = document.getElementById("custom_dropdown");
                while (dropdown.firstChild) {
                    dropdown.removeChild(dropdown.firstChild);
                }
                let badge = document.getElementById("badge");
                badge.textContent = "";

                array_noti.forEach(noti => {
                    if (noti.trim() !== "") {
                        let paragraph = document.createElement("p");
                        if (noti.includes("like")) {
                            noti = noti.replace("like", "");
                            paragraph.textContent = noti + " ha messo like";
                        } else if (noti.includes("comment")) {
                            noti = noti.replace("comment", "");
                            paragraph.textContent = noti + " ha scritto un commento";
                        }
                        dropdown.appendChild(paragraph);
                    }
                });
            } else {
                alert("failed_noti");
            }
        },
    });
    
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        let dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
