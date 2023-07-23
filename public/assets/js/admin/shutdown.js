document.getElementById("power-button").addEventListener("click", function(event) {
    event.preventDefault();

    let confirm_txt = "";
    if (event.currentTarget.classList.contains("on")) {
        confirm_txt = "Zeker dat u het systeem wilt aanzetten? Dan zullen mensen tickets kunnen kopen.";
    } else {
        confirm_txt = "Zeker dat u het systeem wilt uitzetten? Dan zullen mensen geen tickets meer kunnen kopen.";
    }

    if (confirm(confirm_txt)) {
        event.currentTarget.parentNode.submit();
    }
});
