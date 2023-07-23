function showTicketsInConfirmScreen() {
    document.getElementById("ticket-confirmation-list").innerHTML = "";

    tickets.forEach(function(ticket) {

        let delete_or_view_button = `<img class="ticket-icon delete-ticket-button-confirm" src="/assets/media/images/delete.png" alt="Verwijderen">`;
        if (ticket.from_current_user) {
            delete_or_view_button = `<img class="ticket-icon edit-or-view-ticket-button-confirm" src="/assets/media/images/view.png" alt="Bekijken">`;
        }

        let html = `
            <div class="ticket-confirmation-list-item" data-index="` + ticket.ticketlist_index + `">
                <div>
                    <span class="ticket-confirmation-list-item-name">Ticket van <strong>` + ticket.firstname + ` ` + ticket.lastname + `</strong></span>
                    <div class="ticket-confirmation-list-item-info">
                        <div>
                            <span class="label">E-mail:</span>
                            <span class="value">` + ticket.email + `</span>
                        </div>
                        <div>
                            <span class="label">Geboortedatum:</span>
                            <span class="value">` + ticket.birthdate + `</span>
                        </div>
                    </div>
                </div>
                <div class="ticket-list-item-buttons">
                    <img class="ticket-icon edit-or-view-ticket-button-confirm" src="/assets/media/images/edit.png" alt="Wijzigen">
                    ` + delete_or_view_button + `
                </div>
            </div>
        `;

        document.getElementById("ticket-confirmation-list").insertAdjacentHTML("beforeend", html);
    });

    document.querySelector(".screen#confirm .price-value").innerHTML = (tickets.length * parseFloat(document.querySelector("meta[name='ticket-price']").getAttribute("content"))).toFixed(2).replace(".", ",");
    loadConfirmationListItemButtonListeners();
}

function gotoTicket(event) {
    let index = event.currentTarget.parentNode.parentNode.getAttribute("data-index");
    displayScreen("buy-tickets");
    showTicket(index, true);
}

function deleteTicketInConfirmScreen(event) {
    let index = event.currentTarget.parentNode.parentNode.getAttribute("data-index");
    tickets.splice(tickets.findIndex(e => e.ticketlist_index == index), 1);
    localStorage.setItem("tickets", JSON.stringify(tickets));
    event.currentTarget.parentNode.parentNode.remove();

    showTicketsInConfirmScreen();
    reloadTicketList();

    if (tickets.length == 0) {
        displayScreen("buy-tickets");
    }
}

loadConfirmationListItemButtonListeners();
function loadConfirmationListItemButtonListeners() {
    Array.from(document.getElementsByClassName("edit-or-view-ticket-button-confirm")).forEach(function(element) {
        element.removeEventListener("click", gotoTicket);
        element.addEventListener("click", gotoTicket);
    });

    Array.from(document.getElementsByClassName("delete-ticket-button-confirm")).forEach(function(element) {
        element.removeEventListener("click", deleteTicketInConfirmScreen);
        element.addEventListener("click", deleteTicketInConfirmScreen);
    });
}
