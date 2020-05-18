$(document).ready(function () {
    $('input[type="date"]').attr(
        "min",
        moment("1970-01-01").format("YYYY-MM-DD")
    );
    $('input[type="date"]').attr("max", moment().format("YYYY-MM-DD"));

    var btnSubmitClicked;
    var loadingText = "Chargement ";
    var loader = '&nbsp;<i class="fa fa-spinner fa-spin"></i>';
    moment.locale("fr");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("click", ":submit", function () {
        $(":submit").removeAttr("clicked");
        btnSubmitClicked = $(this);
    });

    $(document).on("submit", "form", function () {
        btnSubmitClicked
            .attr("clicked", "true")
            .text(loadingText)
            .append(loader);
    });

    $(document).ajaxStart(function () {
        $(":submit").each(function () {
            $(this).prop("disabled", true);
        });
    });

    $(document).ajaxStop(function () {
        $(":submit")
            .not(btnSubmitClicked)
            .each(function () {
                $(this).prop("disabled", false);
            });
        $(btnSubmitClicked).text($(btnSubmitClicked).val());
    });

    $("#logout").click(function () {
        $.ajax({
            url: "/Logout",
            type: "POST",
            success: function (data) {
                window.location.href = "/";
                displayToastr("disconnected");
            },
            error: function (xhr, status, error) {
                displayToastr("error");
            },
        });
    });

    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            sEmptyTable: "Aucune donnée disponible dans le tableau",
            sInfo:
                "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            sInfoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
            sInfoFiltered: "(filtré à partir de _MAX_ éléments au total)",
            sInfoPostFix: "",
            sInfoThousands: ",",
            sLengthMenu: "Afficher _MENU_ éléments",
            sLoadingRecords: "Chargement...",
            sProcessing: "Traitement en cours . . .",
            sSearch: "Rechercher :",
            sZeroRecords: "Aucun élément correspondant trouvé",
            oPaginate: {
                sFirst: "Premier",
                sLast: "Dernier",
                sNext: "Suivant",
                sPrevious: "Précédent",
            },
            oAria: {
                sSortAscending:
                    ": activer pour trier la colonne par ordre croissant",
                sSortDescending:
                    ": activer pour trier la colonne par ordre décroissant",
            },
            select: {
                rows: {
                    _: "%d lignes sélectionnées",
                    "0": "Aucune ligne sélectionnée",
                    "1": "1 ligne sélectionnée",
                },
            },
        },
        dom: "Bfrtip",
    });
});

function displayToastr(type, message) {
    var title = $("title").text() + " - " + "Administration";
    var timeOut =
        type == "error" || type == "errorMsg" || type == "warning"
            ? 5000
            : 2000;

    toastr.options = {
        timeOut: timeOut,
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
                    message +
                    ".",
                title
            );
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
        case "fileLoaded":
            toastr.success("Fichier chargé !", title);
            break;
        case "teacherAdded":
            toastr.info("Professeur ajouté", title);
            break;
        case "teacherDeleted":
            toastr.info("Professeur supprimé", title);
            break;
    }
}

function displayFile(href, isPdf) {
    var x = window.open();
    x.document.open();
    x.document.write(
        '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
    );

    if (!isPdf) x.document.write('<img src="' + href + '" class="img-fluid">');
    else
        x.document.write(
            '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="' +
                href +
                '"></iframe</div>'
        );

    x.document.close();
}

function checkIfArrayIsUnique(myArray) {
  return myArray.length === new Set(myArray).size;
}