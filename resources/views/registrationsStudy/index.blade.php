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
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#downloadRegisrationModal">
                    Télécharger les candidatures
                </button>
                <br />
                <br />
                <form id="formDownloadRegistration" action="" method="post">
                    <input type="hidden" id="student_id" name="student_id">
                    <table class="table table-striped" id="registrationsTable">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>
                                    <select class="form-control" id="trainingFilter">
                                        <option value="">Niveau</option>
                                        @foreach($data['trainings'] as $training)
                                        <option value="{{ $training->name }}">{{ $training->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="statusFilter">
                                        <option value="">Statut</option>
                                        @foreach($data['statuses'] as $status)
                                        <option value="{{ $status->title }}">{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>Modifier le statut</td>
                                <td>Télécharger les docs.</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['registrations'] as $registration)
                            <tr>
                                <td>{{ $registration->id }}</td>
                                <td>{{ $registration->student->lastname }}</td>
                                <td>{{ $registration->student->firstname  }}</td>
                                <td>{{ $registration->training->name ?? 'Non renseigné' }}</td>
                                <td>{{ $registration->registration_status->title  }}</td>
                                <td class="not-export-col">
                                    <div class="text-center">
                                        @if($registration->registration_status->id != 1)
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editStatusModal" data-id="{{ $registration->id }}">Modifier</button>
                                        @else
                                        <i class="fas fa-hourglass"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="not-export-col">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" id="formAddTeacher" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter des professeurs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(count($data['teachers']) > 0)
                    Professeurs existants :
                    <table class="table table-bordered" id="teachersTable">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>email</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['teachers'] as $teacher)
                            <tr>
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br/>
                    <br/>
                    <hr>
                    @endif
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

<div class="modal fade" id="downloadRegisrationModal" tabindex="-1" role="dialog" aria-labelledby="downloadRegisrationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier le statut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDownloadAllRegistrations" action="" method="post">
                    <label for="registration_status_d">Choix des niveaux :</label><br />
                    <select class="form-control" id="training_d" name="training_d">
                        <option value="all">Tout les niveaux</option>
                        @foreach($data['trainings'] as $training)
                        <option value="{{ $training->id }}">{{ $training->name }}</option>
                        @endforeach
                    </select>
                    <br />
                    <label for="registration_status_d">Choix des candidatures :</label><br />
                    <select name="registration_status_d" id="registration_status_d" class="form-control">
                        <option value="all">Tout les statuts</option>
                        @foreach($data['statuses'] as $status)
                        <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                    </select>
                    <br />
                    <br />
                    <button class="btn btn-success" id="downloadAllRegistration" value="Télécharger" type="submit">Télécharger</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

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
                        <option>-- Sélectionnez un statut --</option>
                        @foreach($data['statuses'] as $status)
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

        var fileNameExportTeachers = 'Listes des professeurs - ' + moment().format('DD-MMMM-YYYY');

        var teachersTable = $('#teachersTable').DataTable({
            info: false,
            paging : false,
            buttons: [{
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-info',
                    title: fileNameExportTeachers,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-info',
                    title: fileNameExportTeachers,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-info',
                    title: fileNameExportTeachers,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimer',
                    className: 'btn btn-info',
                    title: fileNameExportTeachers,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
            ]
        });

        var fileNameExportRegistrations = 'Candidatures - ' + moment().format('DD-MMMM-YYYY');

        var registrationsTable = $('#registrationsTable').DataTable({
            buttons: [{
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimer',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                },
            ],
            columnDefs: [{
                "targets": [3, 4],
                "orderable": false
            }],
            orders: []
        });

        $("#trainingFilter").on('change', function() {
            registrationsTable
                .columns([3])
                .search(this.value)
                .draw();
        });

        $("#statusFilter").on('change', function() {
            var regex = this.value ? '^' + this.value + '$' : '';

            registrationsTable
                .columns([4])
                .search(regex, true, false)
                .draw();
        });

        $('#addTeacherModal').on('show.bs.modal', function(e) {
            $("#teacherEmail, #teacherPassword").val('');
        });

        $('#downloadRegisrationModal').on('show.bs.modal', function(e) {
            $("#registration_status_d, #training_d").val('all').change();
        });

        $('#editStatusModal').on('show.bs.modal', function(e) {
            var registrationId = $(e.relatedTarget).data('id');
            $("#registrationId").val(registrationId);
            var rowIdx = $("tr:contains(" + registrationId + ")").index();
            var statusTitle = registrationsTable.row(rowIdx).data()[4];
            $("#registrationStatus option").each(function() {
                this.selected = (this.text == statusTitle);
            });
        });

        $("#formAddTeacher").submit(function(e) {
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url: '/Teacher/Add',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    teachersTable.row.add([data.teacherId, $("#teacherEmail").val()]).draw( false );
                    form.find(":submit").prop('disabled', false);
                    displayToastr('updated');
                    $('#addTeacherModal').modal('toggle');
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    if (xhr.responseJSON.message == 'emailNotPossible') {
                        displayToastr('errorMsg', 'Cet email n\'est pas disponible !');
                    }
                    else if (xhr.responseJSON.message == 'emailAlreadyExist') {
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
            var rowIdx = $("tr:contains(" + registrationId + ")").index();
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url: '/RegistrationsStudy/UpdateStatus',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('updated');
                    $('#editStatusModal').modal('toggle');
                    registrationsTable.cell({
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

            var xhr = new XMLHttpRequest();
            $.ajax({
                url: '/RegistrationsStudy/DownloadRegistration',
                type: 'POST',
                data: form.serialize(),
                xhrFields: {
                    responseType: 'blob'
                },
                xhr: function() {
                    return xhr;
                },
                success: function(data, textStatus, request) {
                    var contentDisposition = request.getResponseHeader("Content-Disposition");
                    var fileNameExportRegistrations = contentDisposition.split('filename')[1].split('"').join("").split('=').join("");
                    getFileFromData(data, fileNameExportRegistrations);
                    form.find(":submit").prop('disabled', false);
                    displayToastr('fileLoaded');
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

            var xhr = new XMLHttpRequest();
            $.ajax({
                url: '/RegistrationsStudy/DownloadAllRegistrations',
                type: 'POST',
                data: $("#formDownloadAllRegistrations").serialize(),
                xhr: function() {
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 2) {
                            if (xhr.status == 200) {
                                xhr.responseType = "blob";
                            } else {
                                xhr.responseType = "text";
                            }
                        }
                    };
                    return xhr;
                },
                success: function(data, textStatus, request) {
                    var contentDisposition = request.getResponseHeader("Content-Disposition");
                    var fileNameExportRegistrations = contentDisposition.split('filename')[1].split('"').join("").split('=').join("");
                    getFileFromData(data, fileNameExportRegistrations);
                    form.find(":submit").prop('disabled', false);
                    displayToastr('fileLoaded');
                },
                error: function() {
                    form.find(":submit").prop('disabled', false);
                    if (JSON.parse(xhr.responseText).message == 'noRegistration') {
                        displayToastr('errorMsg', 'Aucune candidature n\'a été trouvé pour le filtre sélectionné');
                    } else {
                        displayToastr('error');
                    }
                }
            });

        })
    });


    function getFileFromData(data, fileNameExportRegistrations) {
        var a = document.createElement('a');
        var url = window.URL.createObjectURL(data);
        a.href = url;
        a.download = fileNameExportRegistrations;
        document.body.append(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    }
</script>
@endsection