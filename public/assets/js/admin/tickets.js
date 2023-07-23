[...document.getElementsByClassName("resend-mail")].forEach(function(element) {
    element.addEventListener("click", resendEmail);
});

[...document.getElementsByClassName("refund-ticket")].forEach(function(element) {
    element.addEventListener("click", refundTicket);
});

function resendEmail(event) {
    let id = event.currentTarget.parentNode.parentNode.parentNode.getAttribute("data-attr-ticket-id");

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                alert("Mail is opnieuw verzonden.")
            } else {
                alert("Er was een fout bij het verzenden.")
            }
        }
    }
    xhr.open("POST", "/dashboard/tickets/resend-email/" + id, true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send();
}

function refundTicket(event) {
    let id = event.currentTarget.parentNode.parentNode.parentNode.getAttribute("data-attr-ticket-id");

    if (!confirm("Ticket #" + id + " terugbetalen?")) {
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            console.log(xhr.responseText);
            if (xhr.status == 200) {
                alert("Dit ticket zal worden terugbetaald.")
                document.querySelector("tbody tr[data-attr-ticket-id='"+id+"'] .status-td").innerHTML = `<div class="status refunding">REFUNDING</div>`;
            } else {
                alert("Er kon geen terugbetaling voor dit ticket aangemaakt worden.")
            }
        }
    }
    xhr.open("POST", "/dashboard/tickets/refund/" + id, true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send();
}
