new QRCode(
    "qr-code",
    {
        text: location.href.split("/").pop(),
        correctLevel: QRCode.CorrectLevel.L,
        width: 200,
        height: 200,
    }
);

document.getElementById("print-button").addEventListener("click", function() {
    if (!confirm("We raden je aan een screenshot te nemen van je ticket om papierverspilling tegen te gaan. Toch afdrukken?")) {
        return;
    }

    window.print();
});

let hellofoodPopup = document.getElementById("hellofood-popup");
let popupBackground = document.getElementById("popup-background");

setTimeout(function() {
    popupBackground.style.display = "block";
    document.body.offsetHeight;
    popupBackground.classList.add("visible");

    hellofoodPopup.style.display = "inline-flex";
    document.body.offsetHeight;
    hellofoodPopup.classList.add("visible");
}, 500);

[...document.getElementsByClassName("close-hellofood-popup")].forEach(function(element) {
    element.addEventListener("click", function() {
        popupBackground.classList.remove("visible");
        document.body.offsetHeight;
        popupBackground.style.display = "none";

        hellofoodPopup.classList.remove("visible");
        document.body.offsetHeight;
        hellofoodPopup.style.display = "none";

    })
});
