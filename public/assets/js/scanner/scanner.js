import QrScanner from './qr-scanner.min.js';


let lastScan = "";
let initResponseHtml = document.getElementById("response").innerHTML;

let camera = document.getElementById("camera");
const qrScanner = new QrScanner(
    camera,
    result => {
        if (lastScan != result.data) {
            lastScan = result.data;
            checkCode(result.data);
        }
    },
    {},
);

if (!window.matchMedia('(display-mode: standalone)').matches && !(new URLSearchParams(window.location.search).has("download"))) {
    window.location.href = "/scanner/download";
} else {
    qrScanner.start();
}

function checkCode(code) {
    let showResponse = document.getElementById("response");

    showResponse.innerHTML = initResponseHtml;
    showResponse.classList.remove("visible");

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {

            if (xhr.status == 200) {
                let res = JSON.parse(xhr.responseText);
                let ticket = JSON.parse(res.ticket);

                if (res.status == "OK") {
                    document.getElementById("status").setAttribute("src", "assets/media/images/scanner/valid.png");
                    showResponse.querySelector("#name").textContent = ticket.firstname + " " + ticket.lastname;
                    showResponse.querySelector("#age").textContent = "(" + getAge(ticket.birthdate) + " jaar)"
                    showResponse.querySelector("#ticket-id").textContent = "#" + ticket.id;
                } else {
                    document.getElementById("status").setAttribute("src", "assets/media/images/scanner/invalid.png");
                    if (ticket == null) {
                        showResponse.querySelector("#ticket-id").textContent = "Ticket niet gevonden.";
                    } else {
                        showResponse.querySelector("#age").textContent = "(" + getAge(ticket.birthdate) + " jaar)"
                        showResponse.querySelector("#name").textContent = ticket.firstname + " " + ticket.lastname;
                        showResponse.querySelector("#age").textContent = "(" + getAge(ticket.birthdate) + " jaar)"
                        showResponse.querySelector("#ticket-id").textContent = "#" + ticket.id;

                        if (ticket.used) {
                            showResponse.querySelector("#error").innerHTML = "<strong>Fout:</strong> Reeds gebruikt.";
                        }
                        if (!ticket.paid) {
                            showResponse.querySelector("#error").innerHTML = "<strong>Fout:</strong> Niet betaald.";
                        }
                    }
                }

                showResponse.classList.add("visible");
            }
        }
    }

    xhr.open("POST", "/scanner/check", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("code=" + code);
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

document.getElementById("reload").addEventListener("click", function() {
    window.location.reload();
});
