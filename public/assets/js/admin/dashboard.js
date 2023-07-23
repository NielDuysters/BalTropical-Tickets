let url = window.location.pathname;

document.querySelectorAll("nav#dashboard-nav a").forEach(function(element) {
    if (url.includes(element.getAttribute("href"))) {
        element.classList.add("active");
    }
});

document.querySelectorAll("nav#top-nav a").forEach(function(element) {
    if (url == element.getAttribute("href")) {
        element.classList.add("active");
    }
});
