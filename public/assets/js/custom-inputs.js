function toggleOptions(event) {
    let dropdown = event.currentTarget;
    let options = dropdown.querySelector(".options");


    if (!dropdown.classList.contains("active")) {
        dropdown.classList.add("active");
        setTimeout(function () {
            options.style.height = "100px";
        }, 0);
    } else {
        options.style.height = '0px';
        options.addEventListener('transitionend', function () {
            dropdown.classList.remove('active');
        }, {
            once: true
        });
    }
}

function selectOption(event) {
    let selectedOption = event.currentTarget;
    let dropdown = selectedOption.parentNode.parentNode;

    let selectedHtml = dropdown.querySelector(".selected");
    selectedHtml.querySelector("span").innerHTML = selectedOption.innerHTML;
    dropdown.setAttribute("data-value", selectedOption.getAttribute("data-value"));
    dropdown.querySelector(".dropdown-value").value = selectedOption.getAttribute("data-value");

    dropdown.classList.add("is-selected");
}

function toggleCheckbox(event) {
    let checkbox = event.currentTarget;
    let selected = checkbox.getAttribute("data-selected") == "false";

    checkbox.setAttribute("data-selected", String(selected));
    checkbox.parentNode.querySelector("input[type='checkbox']").checked = selected;
}

loadDropdownListeners();
loadCheckboxListeners();
function loadDropdownListeners() {
    Array.from(document.getElementsByClassName("dropdown")).forEach(function(element) {
        element.removeEventListener("click", toggleOptions);
        element.addEventListener("click", toggleOptions);
    });

    Array.from(document.querySelectorAll(".dropdown .options span")).forEach(function(element) {
        element.removeEventListener("click", selectOption);
        element.addEventListener("click", selectOption);
    });
}

function loadCheckboxListeners() {
    Array.from(document.querySelectorAll(".checkbox")).forEach(function(element) {
        element.removeEventListener("click", toggleCheckbox);
        element.addEventListener("click", toggleCheckbox);
    });
}
