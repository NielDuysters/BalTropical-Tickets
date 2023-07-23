
function displayScreen(id) {
    [...document.getElementsByClassName("screen")].forEach(function(screen) {
        screen.classList.remove("visible");
        document.body.offsetHeight;
        screen.style.display = "none";
    });

    document.getElementById(id).style.display = "block";
    document.body.offsetHeight;
    document.getElementById(id).classList.add("visible");

    let screens = [
        "start-support",
        "is-paid",
        "mail-received",
        "contact",
        "thank-you"
    ];

    let progress = screens.indexOf(id) / (screens.length -1) * 100;

    if (id == "solved") {
        progress = 100;
    }

    document.getElementById("progress-bar").style.width = progress + "%";
}

loadScreenButtonsListeners();
function loadScreenButtonsListeners() {
    [...document.getElementsByClassName("button")].forEach(function(button) {
        button.removeEventListener("click", screenButtonAction);
        button.addEventListener("click", screenButtonAction);
    });
}

function screenButtonAction(event) {
    let button = event.currentTarget;
    if (button.classList.contains("goto")) {
        displayScreen(button.getAttribute("data-next"));
    }

    if (button.classList.contains("show-explanation")) {
        let explanation = button.parentNode.parentNode.parentNode.querySelector(".explanation");
        explanation.style.display = "block";
        document.body.offsetHeight;
        explanation.classList.add("visible");

        button.parentNode.innerHTML = `<a href="/" class="button ok">Ok</a>`;
    }
}

document.getElementById("submit-button").addEventListener("click", function() {
    let form = document.getElementById("contact-form");

    if (!validateTicketSupportForm()) {
        form.querySelector(".error").style.display = "block";
        return;
    }


    const formData = new FormData();
    formData.append("name", form.querySelector("input[name='firstname']").value + " " +  form.querySelector("input[name='lastname']").value);
    formData.append("email", form.querySelector("input[name='email']").value);
    formData.append("description", form.querySelector("textarea[name='description']").value);
    formData.append("file", form.querySelector("input[name='file']").files[0]);

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                displayScreen("thank-you");
            } else {
                console.log("Error: " + xhr.responseText);
            }
        }
    }
    xhr.open("POST", "/ticket-help/contact", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send(formData);
});

document.getElementById("resend-mail-button").addEventListener("click", function() {
    let email = document.querySelector(".screen#resend-mail input[name='email']");
    let form = email.parentNode.parentNode;

    if (email.value.trim().length == 0) {
        email.classList.add("invalid");
        form.querySelector(".error").style.display = "block";
        return;
    }


    const formData = new FormData();
    formData.append("email", form.querySelector("input[name='email']").value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/ticket-help/resend-mail", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send(formData);

    displayScreen("resend-mail-received");
});

function validateTicketSupportForm() {
    let form = document.getElementById("contact-form");

    form.querySelectorAll(".invalid").forEach(function(element) { element.classList.remove("invalid") });

    let firstname = form.querySelector("input[name='firstname']");
    let lastname = form.querySelector("input[name='lastname']");
    let email = form.querySelector("input[name='email']");
    let description = form.querySelector("textarea[name='description']");
    let file = form.querySelector("input[name='file']");

    let valid = true;
    if (firstname.value.trim().length == 0) {
        firstname.classList.add("invalid");
        valid = false;
    }
    if (lastname.value.trim().length == 0) {
        lastname.classList.add("invalid");
        valid = false;
    }
    if (email.value.trim().length == 0 || validateEmail(email.value) == null) {
        email.classList.add("invalid");
        valid = false;
    }
    if (description.value.trim().length == 0) {
        description.classList.add("invalid");
        valid = false;
    }
    if (file.files.length == 0) {
        file.classList.add("invalid");
        valid = false;
    }

    return valid;
}
