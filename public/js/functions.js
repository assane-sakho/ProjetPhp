function displayToastr(type, message) {
    var title = $("title").text() + " - " + "Administration";
    var timeOut =
        type == "error" || type == "errorMsg" || type == "warning"
            ? 3000
            : 2000;

    toastr.options = {
        timeOut: timeOut
    };

    toastr.clear();

    switch (type) {
        case "studentRegistred":
            toastr.success("Vos données ont été ajoutés.", title);
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
            toastr.success("Les modifications ont été enregistrés.", title);
            break;
        case "loaded":
            toastr.success("Les données ont été chargés.", title);
            break;
        case "deleted":
            toastr.info("Les données ont été supprimés.", title);
            break;
        case "warning":
            toastr.warning(
                '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention<p/>' +
                    message,
                title
            );
            break;
        case "checked":
            toastr.info("Vérification terminé", title);
            break;
        case "errorMsg":
            toastr.error(
                'Attention <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <p/><br/>' +
                    message,
                title
            );
            break;
    }
}
