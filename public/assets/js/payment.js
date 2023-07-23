function loadPaymentScreen() {
    document.getElementById("price-value").innerHTML = (tickets.length * parseFloat(document.querySelector("meta[name='ticket-price']").getAttribute("content"))).toFixed(2).replace(".", ",");
}

document.getElementById("payment-button").addEventListener("click", function payment() {
    this.removeEventListener('click', payment);
    document.getElementById("loading-screen").style.display = "flex";

    let json = JSON.stringify(tickets, replacer);

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                localStorage.removeItem("tickets");
                window.location.href = xhr.responseText;
            } else {
                console.log("Error: " + xhr.responseText);
            }
        }
    }
    xhr.open("POST", "/payment", true);
    xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send(json);
});

function replacer(key, value) {
    if (["ticketlist_index"].includes(key)) {
        return undefined;
    }

    return value;
}
