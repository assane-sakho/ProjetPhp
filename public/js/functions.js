function displayToastr(type, message) {
    var title = $("title").text() + " - " + "Administration";
    var timeOut =
        type == "error" || type == "errorMsg" || type == "warning"
            ? 5000
            : 2000;

    toastr.options = {
        timeOut: timeOut
    };

    toastr.clear();

    switch (type) {
        case "studentRegistred":
            toastr.success("Vos données ont été ajoutées.", title);
            break;
        case "connected":
            toastr.info("Bienvenue " + message, title);
            break;
        case "disconnected":
            toastr.info("Vous avez été déconnecté", title);
            break;
        case "error":
            toastr.error("Une erreur est survenue.", title);
            break;
        case "updated":
            toastr.success("Les modifications ont été enregistrées.", title);
            break;
        case "deleted":
            toastr.info("Les données ont été supprimées.", title);
            break;
        case "warning":
            toastr.warning(
                '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention<br/><br/>' +
                    message + ".",title);
            break;
        case "errorMsg":
            toastr.error(
                'Attention <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><br/><br/>' +
                    message,
                title
            );
            break;
        case "registrationSaved":
            toastr.success("Votre candidature a été enregistrée.", title);
            break;
        case "messageLoaded":
            toastr.success("Les messages ont été chargés.", title);
            break;
        case "messageSent":
            toastr.info("Message envoyé.", title);
            break;
    }
}
