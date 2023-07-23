tickets = [];

if (localStorage.getItem("tickets") != null) {
    tickets = JSON.parse(localStorage.getItem("tickets"));
}

initial_form = document.querySelector(".screen#buy-tickets .form").innerHTML;

displayScreen("buy-tickets");

if (tickets.length > 0) {
    showTicket(tickets[0].ticketlist_index, true);
}

reloadTicketList();

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

    if (button.classList.contains("add-ticket")) {
        addTicket();
    }
}


function displayScreen(id) {
    [...document.getElementsByClassName("screen")].forEach(function(screen) {
        screen.classList.remove("visible");
        document.body.offsetHeight;
        screen.style.display = "none";
    });

    document.getElementById(id).style.display = "block";
    document.body.offsetHeight;
    document.getElementById(id).classList.add("visible");

    if (id == "buy-tickets" && tickets.length > 0) {
        toggleTicketList(true);
    } else {
        toggleTicketList(false);
    }

    if (id == "confirm") {
        document.getElementById("screen-container").classList.add("confirm-screen-is-active");
        showTicketsInConfirmScreen();
    } else {
        document.getElementById("screen-container").classList.remove("confirm-screen-is-active");
    }

    if (id == "payment") {
        loadPaymentScreen();
    }

    let screens = [
        "buy-tickets",
        "confirm",
        "payment",
        "accept-agreements",
        "view_ticket",
    ];

    let progress = screens.indexOf(id) / (screens.length - 1) * 100;
    document.getElementById("progress-bar").style.width = progress + "%";
}

function toggleTicketList(visibility) {
    let ticketsContainer = document.getElementById("all-tickets-container");

    if (ticketsContainer == undefined) {
        return;
    }

    if (visibility) {
        ticketsContainer.style.display = "block";
        document.body.offsetHeight;
        ticketsContainer.classList.add("visible");

    } else {
        ticketsContainer.classList.remove("visible");
        document.body.offsetHeight;
        ticketsContainer.style.display = "none";
    }
}

function addTicket() {
    if (!validateBuyTicketForm()) {
        document.getElementById("buy-tickets-error").style.display = "block";
        return;
    }

    if (tickets.length == 0) {
        toggleTicketList(true);
    }

    let ticket = new Ticket(
        capitalize(document.getElementsByName("firstname")[0].value),
        capitalize(document.getElementsByName("lastname")[0].value),
        document.getElementsByName("email")[0].value.toLowerCase(),
        document.getElementsByName("birthdate-year")[0].value + "-" + document.getElementById("birthdate-month").getAttribute("data-value") + "-" + document.getElementsByName("birthdate-day")[0].value,
        false,
        tickets.length == 0,
        generateTicketListIndex()
    );

    tickets.push(ticket);
    localStorage.setItem("tickets", JSON.stringify(tickets));
    appendToTicketList(ticket);

    clearBuyTicketScreen();
    document.getElementById("ticket-amount-value").innerHTML = tickets.length;
}

function deleteTicket(event) {
    let ticketListItem = event.currentTarget.parentNode.parentNode;
    let index = ticketListItem.getAttribute("data-index");
    tickets.splice(tickets.findIndex(e => e.ticketlist_index == index), 1);
    localStorage.setItem("tickets", JSON.stringify(tickets));
    ticketListItem.remove();

    if (tickets.length == 1) {
        showTicket(tickets[0].ticketlist_index);
    }

    document.querySelector(".screen#buy-tickets .price-value").innerHTML = (tickets.length * parseFloat(document.querySelector("meta[name='ticket-price']").getAttribute("content"))).toFixed(2).replace(".", ",");
    document.getElementById("ticket-amount-value").innerHTML = tickets.length;
}

function appendToTicketList(ticket) {
    let ticketsList = document.getElementById("all-tickets-list");

    let html = `
        <div class="ticket-list-item" data-index="` + ticket.ticketlist_index + `">
            <span>Ticket van <strong>` + ticket.firstname + ` ` + ticket.lastname + `</strong></span>
            <div class="ticket-list-item-buttons">
                <img class="ticket-icon" src="/assets/media/images/edit.png" alt="Wijzigen">
                <img class="ticket-icon delete-ticket-button" src="/assets/media/images/delete.png" alt="Verwijderen">
            </div>
        </div>
    `;

    if (ticket.from_current_user) {
        html = `
            <div class="ticket-list-item" data-index="` + ticket.ticketlist_index + `">
                <span>Ticket van <strong>` + ticket.firstname + ` ` + ticket.lastname + `</strong> (Uw ticket)</span>
                <div class="ticket-list-item-buttons">
                    <img class="ticket-icon" src="/assets/media/images/edit.png" alt="Wijzigen">
                    <img class="ticket-icon" src="/assets/media/images/view.png" alt="Bekijken">
                </div>
            </div>
        `;
    }

    ticketsList.insertAdjacentHTML("beforeend", html);
    [...document.getElementsByClassName("delete-ticket-button")].forEach(function(btn) {
        btn.removeEventListener("click", deleteTicket);
        btn.addEventListener("click", deleteTicket);
    });

    [...document.getElementsByClassName("ticket-list-item")].forEach(function(btn) {
        btn.removeEventListener("click", showTicketEvent);
        btn.addEventListener("click", showTicketEvent);
    });
}

function reloadTicketList() {
    document.getElementById("all-tickets-list").innerHTML = "";

    tickets.forEach(function(ticket) {
        appendToTicketList(ticket);
    });
}

function showTicketEvent(event) {
    if (event.target.classList.contains("delete-ticket-button")) {
        return;
    }

    let ticketListItem = event.currentTarget;
    let index = ticketListItem.getAttribute("data-index");

    showTicket(index);
}

function showTicket(index, save_required = true) {
    let ticket = tickets.find(e => e.ticketlist_index == index);

    document.getElementsByName("firstname")[0].value = ticket.firstname;
    document.getElementsByName("lastname")[0].value = ticket.lastname;
    document.getElementsByName("email")[0].value = ticket.email;

    let birthdate = ticket.birthdate.split("-");
    document.getElementsByName("birthdate-day")[0].value = birthdate[2];
    document.getElementsByName("birthdate-year")[0].value = birthdate[0];
    document.getElementById("birthdate-month").setAttribute("data-value", birthdate[1]);
    document.querySelector("#birthdate-month .selected span").innerHTML = document.querySelector("#birthdate-month .options span[data-value='" + birthdate[1] + "']").innerHTML;
    document.getElementById("birthdate-month").classList.add("is-selected");

    loadDropdownListeners();

    if (save_required) {
        clearBuyTicketScreen(true);

        let save_changes_button =  document.querySelector(".screen#buy-tickets .button.save-changes");
        save_changes_button.removeEventListener("click", saveChangesToTicket);
        save_changes_button.index = index;
        save_changes_button.addEventListener("click", saveChangesToTicket);

    }
}

function saveChangesToTicket(event) {
    if (!validateBuyTicketForm()) {
        document.getElementById("buy-tickets-error").style.display = "block";
        return;
    }

    let index = event.currentTarget.index;
    let ticket = tickets.find(e => e.ticketlist_index == index);

    let newTicket = new Ticket(
        document.getElementsByName("firstname")[0].value,
        document.getElementsByName("lastname")[0].value,
        document.getElementsByName("email")[0].value,
        document.getElementsByName("birthdate-year")[0].value + "-" + document.getElementById("birthdate-month").getAttribute("data-value") + "-" + document.getElementsByName("birthdate-day")[0].value,
        false,
        ticket.from_current_user,
        index,
    );

    let i = tickets.findIndex(e => e.ticketlist_index == index);
    tickets[i] = newTicket;
    localStorage.setItem("tickets", JSON.stringify(tickets));

    reloadTicketList();

    clearBuyTicketScreen();
}

function clearBuyTicketScreen(save_changes = false) {
    let button_html = `<div class="button add-ticket"><img class="add-image" src="/assets/media/images/basket.png" alt=""> toevoegen</div>`;
    if (save_changes) {
        button_html = `<div class="button save-changes"><img src="/assets/media/images/save.png"> Opslaan</div>`;
    } else {
        if (tickets.length > 0) {
            document.querySelector(".screen#buy-tickets .form").innerHTML = initial_form;
            loadDropdownListeners();
        }
        if (tickets.length > 0) {
            button_html += `<div class="button goto next" data-next="confirm">Volgende (` + tickets.length + `)</div>`;
        }
    }

    document.querySelector(".screen#buy-tickets .screen-buttons-container").innerHTML = `<div class="screen-buttons-container-buttons">` + button_html + `</div><div class="price">Totale prijs: &euro;<span class="price-value">0,00</span></div>`;
    loadScreenButtonsListeners();

    document.querySelector(".screen#buy-tickets .price-value").innerHTML = (tickets.length * parseFloat(document.querySelector("meta[name='ticket-price']").getAttribute("content"))).toFixed(2).replace(".", ",");
}

function generateTicketListIndex() {
    let index = Math.floor(Math.random() * (99999999 - 5) + 5);

    tickets.forEach(function(ticket) {
        if (ticket.ticketlist_index == index) {
            generateTicketListIndex();
        }
    });

    return index;
}

function validateBuyTicketForm() {
    [...document.getElementsByClassName("invalid")].forEach(function(element) { element.classList.remove("invalid") });

    let firstname = document.getElementsByName("firstname")[0];
    let lastname = document.getElementsByName("lastname")[0];
    let email = document.getElementsByName("email")[0];
    let date = document.getElementsByName("birthdate-year")[0].value + "-" + document.getElementById("birthdate-month").getAttribute("data-value").padStart(2, "0") + "-" + document.getElementsByName("birthdate-day")[0].value.padStart(2, "0");

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

    if (isNaN(Date.parse(date))) {
        document.querySelectorAll(".screen#buy-tickets .date-input").forEach(function(element) {
            element.classList.add("invalid");
        });
        valid = false;
    }

    return valid;
}
