[...document.getElementsByClassName("install-pwa")].forEach(function(element) {
    element.addEventListener("click", function(event) {
        document.getElementById("popup-background").style.display = "block";
        document.body.offsetHeight;
        document.getElementById("popup-background").classList.add("visible");

        let installPwa = document.getElementById("install-pwa-" + event.currentTarget.getAttribute("id"));
        installPwa.style.display = "block";
        document.body.offsetHeight;
        installPwa.classList.add("visible");
    });
});


[...document.getElementsByClassName("close-install-popup")].forEach(function(element) {
    element.addEventListener("click", function(event) {
        document.getElementById("popup-background").classList.remove("visible");
        document.body.offsetHeight;
        document.getElementById("popup-background").style.display = "none";

        event.currentTarget.parentNode.classList.remove("visible");
        document.body.offsetHeight;
        event.currentTarget.parentNode.style.display = "none";
    });
});
