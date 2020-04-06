@extends('layout.mainlayout')

@section('content')

<section class="breadcrumb_part blog_grid_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <div class="breadcrumb_iner">
                    <h2>Étude des candidatures</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="popular_course section_padding section_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('teacher')->id == 1)
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                        Ajouter des professeurs
                    </button>
                </p><br />
                @endif
                <p>
                    <form id="formDownloadAllRegistrations" action="" method="post">
                        <button class="btn btn-success" id="downloadAllRegistration" value="Télécharger toutes les candidatures" type="submit">Télécharger toutes les candidatures</button>
                    </form>
                </p><br />
                <form id="formDownloadRegistration" action="" method="post">
                    <input type="hidden" id="student_id" name="student_id">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>Niveau</td>
                                <td>Statut</td>
                                <td>Modifier le statut</td>
                                <td>Télécharger les docs.</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                            <tr>
                                <td>{{ $registration->id }}</td>
                                <td>{{ $registration->student->lastname }}</td>
                                <td>{{ $registration->student->firstname  }}</td>
                                <td>{{ $registration->training->name }}</td>
                                <td>{{ $registration->registration_status->title  }}</td>
                                <td>
                                    <div class="text-center">
                                        @if($registration->registration_status->id != 1)
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editStatusModal" data-id="{{ $registration->id }}">Modifier</button>
                                        @else
                                        <i class="fas fa-hourglass"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        @if($registration->registration_status->id != 1)
                                        <button type="submit" value="Téléchager" class="btn btn-success downloadRegistration" data-id="{{ $registration->student->id }}">Télécharger</button>
                                        @else
                                        <i class="fas fa-hourglass"></i>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>

@if(session('teacher')->id == 1)
<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="formAddTeacher" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter des professeurs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="teacherEmail">Email: </label>
                    <input class="form-control" type="email" name="teacherEmail" id="teacherEmail" required><br />

                    <label for="teacherPassword">Mot de passe: </label>
                    <input class="form-control" type="password" name="teacherPassword" id="teacherPassword" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" value="Ajouter">Ajouter</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditStatus" action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier le statut</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="registrationId" name="registrationId">
                    <label for="registrationStatus">Statut :</label><br />
                    <select name="registrationStatus" id="registrationStatus" class="form-control">
                        <option value="">-- Sélectionnez un statut --</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning" value="Modifier">Modifier</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var fileName = $("title").text() + " - " + $("#title").text();

        var table = $('.table').DataTable({
            "language": {
                "sEmptyTable": "Aucune donnée disponible dans le tableau",
                "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Afficher _MENU_ éléments",
                "sLoadingRecords": "Chargement...",
                "sProcessing": "Traitement...",
                "sSearch": "Rechercher :",
                "sZeroRecords": "Aucun élément correspondant trouvé",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sLast": "Dernier",
                    "sNext": "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                },
                "select": {
                    "rows": {
                        "_": "%d lignes sélectionnées",
                        "0": "Aucune ligne sélectionnée",
                        "1": "1 ligne sélectionnée"
                    }
                }
            },
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-info',
                    title: fileName,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-info',
                    title: fileName,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-info',
                    title: fileName,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimer',
                    className: 'btn btn-info',
                    title: fileName,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
            ]
        });

        $('#addTeacherModal').on('show.bs.modal', function(e) {
            $("#teacherEmail, #teacherPassword").val('');
        });

        $('#editStatusModal').on('show.bs.modal', function(e) {
            var registrationId = $(e.relatedTarget).data('id');
            $("#registrationId").val(registrationId);
            var rowIdx = $("tr:contains(" + registrationId+ ")").index();
            var statusTitle = table.row(rowIdx).data()[4];
            $("#registrationStatus option").each(function() { this.selected = (this.text == statusTitle); });
        });

        $("#formAddTeacher").submit(function(e) {
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url: '/Teacher/Add',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('updated');
                    $('#addTeacherModal').modal('toggle');
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    if (xhr.responseJSON.message == 'emailAlreadyExist') {
                        displayToastr('errorMsg', 'Un professeur ayant la même adresse mail <i class="fa fa-info-circle text-info"></i> existe déjà !');
                    } else {
                        displayToastr('error');
                    }
                },
            });
        });

        $("#formEditStatus").submit(function(e) {
            var registrationId = $("#registrationId").val();
            var statusTitle = $("#registrationStatus option:selected").text();
            var rowIdx = $("tr:contains(" + registrationId+ ")").index();
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url: '/RegistrationsStudy/EditStatus',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('updated');
                    $('#editStatusModal').modal('toggle');
                    table.cell({
                        row: rowIdx,
                        column: 4
                    }).data(statusTitle).draw();
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('error');
                },
            });
        });

        $("#formDownloadRegistration").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = $(this).find("button[type=submit]:focus");
            $("#student_id").val($(btn).data('id'));

            $.ajax({
                url: '/RegistrationsStudy/DownloadRegistration',
                type: 'POST',
                data: form.serialize(),
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, textStatus, request) {
                    form.find(":submit").prop('disabled', false);
                    var contentDisposition = request.getResponseHeader("Content-disposition");
                    var fileName = contentDisposition.split('filename')[1].split('"').join("").split('=').join("");
                    displayToastr('studentRegistred');
                    getFileFromData(data, fileName);
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    $(this).prop('disabled', false);
                    displayToastr('error');
                },
            });
        })

        $("#formDownloadAllRegistrations").submit(function(e) {
            var form = $(this);
            e.preventDefault();
            $.ajax({
                url: '/RegistrationsStudy/DownloadAllRegistrations',
                type: 'POST',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, textStatus, request) {
                    form.find(":submit").prop('disabled', false);
                    var contentDisposition = request.getResponseHeader("Content-Disposition");
                    var fileName = contentDisposition.split('filename')[1].split('"').join("").split('=').join("");
                    displayToastr('studentRegistred');
                    getFileFromData(data, fileName);
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('error');
                },
            });
        })
    });

    function getFileFromData(data, fileName) {
        var a = document.createElement('a');
        var url = window.URL.createObjectURL(data);
        a.href = url;
        a.download = fileName;
        document.body.append(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    }
</script>
@endsection
<style>
    .show {
        background-color: none !important;
    }
</style>