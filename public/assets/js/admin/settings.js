document.getElementById("empty-tickets").addEventListener("click", function(event) {
    event.preventDefault();

    if (confirm("Bent u zeker dat u alle tickets in de databank wilt verwijderen? Dit kan niet meer ongedaan gemaakt worden!")) {
        if (prompt("Typ VERWIJDEREN om door te gaan.") == "VERWIJDEREN") {
            event.currentTarget.parentNode.submit();
        }
    }
});

document.getElementById("empty-logs").addEventListener("click", function(event) {
    event.preventDefault();

    if (confirm("Bent u zeker dat u alle logs wilt verwijderen? Dit kan niet meer ongedaan gemaakt worden!")) {
        if (prompt("Typ VERWIJDEREN om door te gaan.") == "VERWIJDEREN") {
            event.currentTarget.parentNode.submit();
        }
    }
});
