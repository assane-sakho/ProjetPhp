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
                @if($isAdmin)
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                        Ajouter un professeur
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
                                <td>Email</td>
                                <td>Date de naissance</td>
                                <td>Téléphone</td>
                                <td>Adresse postal</td>
                                <td>N° de carte d'identité</td>
                                <td>Niveau</td>
                                <td>Statut</td>
                                <td>Classique</td>
                                <td>Apprentissage</td>
                                <td class="col-md-8">
                                    <select class="form-control" id="trainingFilter">
                                        <option value="">Niveau</option>
                                        @foreach($trainings as $training)
                                        <option value="{{ $training->id }}">{{ $training->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-md-8">
                                    <select class="form-control" id="statusFilter">
                                        <option value="">Statut</option>
                                        @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>Classique</td>
                                <td>Apprentissage</td>
                                <td>Voir +</td>
                                <td>Modifier le statut</td>
                                <td>Télécharger les docs.</td>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</section>

@if($isAdmin)
<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" id="formAddTeacher" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Ajouter un professeur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Professeurs existants :
                    <table class="table table-bordered" id="teachersTable">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>email</td>
                                <td>Supprimer</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td><button class="btn btn-danger removeTeacher" type="button">Supprimer</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br />
                    <br />
                    <hr>
                    <br>
                    <button type="button" class="btn btn-primary btn-circle btn-sm" id="addMoreEmail"><i class="fa fa-plus"></i></button>
                    <br>
                    <br>
                    <div id="addTeachersInputDiv">

                    </div>
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
                <h5 class="modal-title" id="downloadRegisrationModalLabel">Télécharger les candidatures</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDownloadMultipleRegistrations" action="" method="post">
                    <label for="registration_status_d">Choix des niveaux :</label><br />
                    <select class="form-control" id="training_d" name="training_d">
                        <option value="all">Tout les niveaux</option>
                        @foreach($trainings as $training)
                        <option value="{{ $training->id }}">{{ $training->name }}</option>
                        @endforeach
                    </select>
                    <br />
                    <label for="registration_status_d">Choix des candidatures :</label><br />
                    <select name="registration_status_d" id="registration_status_d" class="form-control">
                        <option value="all">Tout les statuts</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                    </select>
                    <br />
                    <label for="trainingType">Choix du type de candidature :</label><br />
                    <select name="trainingType" id="trainingType" class="form-control">
                        <option value="all">Tout les types</option>
                        <option value="classic">Classique</option>
                        <option value="apprenticeship">Apprentissage</option>
                    </select>
                    <br />
                    <br />
                    <div class="help-block with-errors"></div> <button class="btn btn-success" id="downloadMultipleRegistration" value="Télécharger" type="submit">Télécharger</button>
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
                    <h5 class="modal-title" id="editStatusModalLabel">Modifier le statut</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="registrationId" name="registrationId">
                    <label for="registrationStatus">Statut :</label><br />
                    <select name="registrationStatus" id="registrationStatus" class="form-control">
                        <option>-- Sélectionnez un statut --</option>
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

<div class="modal fade" id="seeMoreModal" tabindex="-1" role="dialog" aria-labelledby="seeMoreModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seeMoreModalLabel">Informations de <span id="seeMore-studentName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="spinner-border text-center" role="status" id="seeMore-loader">
                    <span class="sr-only">Loading...</span>
                </div>
                <table class="table table-bordered hidden" id="seeMore-table">
                    <tr>
                        <th>Statut de la candidature</th>
                        <td colspan="3" id="student-registration_status" class="text-info studentInfo"></td>
                    </tr>
                    <tr rowspan="2">
                        <td>&nbsp;</td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <th>N° de carte d'identité</th>
                        <td colspan="3" id="student-card_id" class="studentInfo"></td>
                    </tr>
                    <tr>
                        <th>Date de naissance</th>
                        <td colspan="3" id="student-birthdate" class="studentInfo"></td>
                    </tr>
                    <tr>
                        <th>Adresse mail</th>
                        <td colspan="3" id="student-email" class="studentInfo"></td>
                    <tr>
                        <th>Téléphone</th>
                        <td colspan="3" id="student-phone_number" class="studentInfo"></td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td colspan="3" id="student-address" class="studentInfo"></td>
                    </tr>
                    <tr rowspan="2">
                        <td>&nbsp;</td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <th>Filière choisis</th>
                        <td colspan="3" id="student-training" class="studentInfo"></td>
                        <td colspan="3" id="student-training-none">Non renseigné</td>
                    </tr>
                    <tr>
                        <th>Pour la formation classique</th>
                        <td colspan="3" id="student-classicTraining" class="studentInfo"></td>
                    </tr>
                    <tr>
                        <th>Pour la formation par apprentissage</th>
                        <td colspan="3" id="student-apprenticeshipTraining" class="studentInfo"></td>
                    </tr>
                    <tr rowspan="2">
                        <td>&nbsp;</td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr id="student-conversation">
                        <th>Conversation avec l'étudiant</th>
                        <td colspan="3">
                            <div style="max-height: 300px"></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var registrations = $("#registrations").val();

        var fileNameExportTeachers = 'Listes des professeurs - ' + moment().format('DD-MMMM-YYYY');

        var teachersTable = $('#teachersTable').DataTable({
            info: false,
            paging: false,
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
                        columns: ':not(.not-export-col)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':not(.not-export-col)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':not(.not-export-col)'
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimer',
                    className: 'btn btn-info',
                    title: fileNameExportRegistrations,
                    exportOptions: {
                        columns: ':not(.not-export-col)'
                    }
                },
            ],
            columnDefs: [{
                    "targets": [12, 13, 14, 15, 16, 17, 18],
                    "orderable": false,
                    "className": 'not-export-col'
                },
                {
                    "targets": [3, 4, 5, 6, 7, 8, 9, 10, 11],
                    "visible": false
                }
            ],
            orders: [0, 1, 2, 3, 4, 5, 6],
            'createdRow': function(row, data, dataIndex) {
                $(row).attr('id', 'registration_' + data['id']);
            },
            'columns': [{
                    data: 'id',
                },
                {
                    data: 'student_lastname'
                },
                {
                    data: 'student_firstname'
                },
                {
                    data: 'student_email'
                },
                {
                    data: 'student_birthdate'
                },
                {
                    data: 'student_phone_number'
                },
                {
                    data: null,
                    "render": function(data, type, row, meta) {
                        return row["student_address_street"] + ", " + row["student_address_zip_code"] + " " + row["student_address_city"];
                    }
                },
                {
                    data: 'student_card_id'
                },
                {
                    data: 'training_name',
                    "render": function(data, type, row, meta) {
                        if (data == null) {
                            return "Non renseigné"
                        } else {
                            return data
                        }
                    },
                },
                {
                    data: 'registration_status'
                },
                {
                    data: 'classicTraining',
                    "render": function(data, type, row, meta) {
                        var result = '';
                        if (row['classicTraining'] == 1) {
                            result += 'Oui';
                        } else {
                            result += 'Non';
                        }
                        return result;
                    },
                },
                {
                    data: 'apprenticeshipTraining',
                    "render": function(data, type, row, meta) {
                        var result = '';
                        if (row['apprenticeshipTraining'] == 1) {
                            result += 'Oui';
                        } else {
                            result += 'Non';
                        }
                        return result;
                    },
                },
                {
                    data: 'training_name',
                    "render": function(data, type, row, meta) {
                        if (data == null) {
                            return "Non renseigné"
                        } else {
                            return data
                        }
                    },
                },
                {
                    data: 'registration_status'
                },
                {
                    data: 'classicTraining',
                    "render": function(data, type, row, meta) {
                        var result = '<i class="fas fa-';
                        if (row['classicTraining'] == 1) {
                            result += 'check text-success';
                        } else {
                            result += 'times text-danger';
                        }
                        result += '"></i>';
                        return result;
                    },
                },
                {
                    data: 'apprenticeshipTraining',
                    "render": function(data, type, row, meta) {
                        var result = '<i class="fas fa-';
                        if (row['apprenticeshipTraining'] == 1) {
                            result += 'check text-success';
                        } else {
                            result += 'times text-danger';
                        }
                        result += '"></i>';
                        return result;
                    },
                },
                {
                    data: null,
                    "render": function(data, type, row, meta) {
                        return '<div class="text-center"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#seeMoreModal" data-id="' + row['id'] + '">Voir +</button></div>'
                    }
                },
                {
                    data: null,
                    "render": function(data, type, row, meta) {
                        var result = '<div class="text-center">';
                        if (row['registration_status_id'] != 1) {
                            result += '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editStatusModal" data-id="' + row['id'] + '">Modifier</button>';
                        } else {
                            result += '<i class="fas fa-hourglass"></i>';
                        }
                        result += '</div>';
                        return result;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, row, meta) {
                        var result = '<div class="text-center">';
                        if (row['registration_status_id'] != 1) {
                            result += '<button type="submit" value="Téléchager" class="btn btn-success downloadRegistration" data-id="' + row['id'] + '">Télécharger</button>';
                        } else {
                            result += '<i class="fas fa-hourglass"></i>';
                        }
                        result += '</div>';
                        return result;
                    }
                }
            ],
            "serverSide": true,
            'ajax': {
                'url': 'RegistrationStudy/GetRegistrations',
                'data': function(data) {
                    // Read values
                    var training = $('#trainingFilter').val();
                    var status = $('#statusFilter').val();

                    data.training_id = training;
                    data.status_id = status;
                }
            },
            "processing": true
        });

        var trsRow = [
            ["CV", "cv"],
            ["Lettre de motitivation", "cover_letter"],
            [
                "Relevés de notes de l’année précédente",
                ["report_card_0", "report_card_1", "report_card_2"],
            ],
            ["Imprime écran de l’ENT de l’année en cours", "vle_screenshot"],
            ["Formulaire d'inscription", "registration_form"],
        ];

        $(document).on('click', '.removeTeacher', function() {
            var tr = $(this).closest('tr');
            var teacherId = tr.find("td:first").text();

            $.ajax({
                url: '/Teacher/Delete',
                type: 'POST',
                data: {
                    teacherId: teacherId
                },
                success: function(data) {
                    $(document).find(":submit").prop('disabled', false);
                    teachersTable.row(tr).remove().draw();
                    displayToastr('teacherDeleted');
                },
                error: function(xhr, status, error) {
                    displayToastr('error');
                }
            });

        });

        $("#trainingFilter").on('change', function() {
            registrationsTable.draw();
        });

        $("#statusFilter").on('change', function() {
            registrationsTable.draw();
        });

        $('#addTeacherModal').on('show.bs.modal', function(e) {
            $(document).find(":submit").prop('disabled', false);

            $("#addTeachersInputDiv").empty();
            addInputEmail();
        });

        $('#downloadRegisrationModal').on('show.bs.modal', function(e) {
            $("#registration_status_d, #training_d").val('all').change();
        });

        $('#seeMoreModal').on('show.bs.modal', function(e) {
            $('#seeMore-loader').show();
            $("#seeMore-table").hide();
            $("embed, #student-vle_screenshot").attr('src', '');

            var studentId = $(e.relatedTarget).data('id');
            var rowIdx = $("#registrationsTable").find("#registration_" + studentId).index();
            var studentName = registrationsTable.row(rowIdx).data()['student_lastname'] + ' ' + registrationsTable.row(rowIdx).data()['student_firstname'];
            $("#seeMore-studentName").text(studentName);

            $('.trFile, #trReportCards').remove();
            $(trsRow).each(function(idx, trRow) {
                if (trRow[1].length == 3) {
                    $("#seeMore-table").append('<tr id="trReportCards"><th>' + trRow[0] + '</th></tr>');
                    $(trRow[1]).each(function(i, trRowChild) {
                        appendTrToSeeMoreTable(["", trRowChild], true);
                    });
                } else {
                    appendTrToSeeMoreTable(trRow, false);
                }
            });

            $.ajax({
                url: '/Student/GetStudentInfo',
                type: 'POST',
                data: {
                    studentId: studentId
                },
                success: function(data) {

                    var student = data.student;
                    var address = data.address;
                    var registration = data.registration;
                    var registration_status = data.registration_status;
                    var training = data.training;
                    var trainingName = training ? training.name : null;
                    var folder = data.folder;
                    var report_cards = data.report_cards;
                    var messages = data.messages;

                    setSeeMoreTableValue('registration_status', registration_status.title);
                    setSeeMoreTableValue('card_id', student.card_id);
                    setSeeMoreTableValue('birthdate', moment(student.birthdate).format('DD-MM-YYYY'));
                    setSeeMoreTableValue('email', student.email);
                    setSeeMoreTableValue('phone_number', student.phone_number);
                    setSeeMoreTableValue('address', address.street + ', ' + address.zip_code + ' ' + address.city);
                    setSeeMoreTableValue('training', trainingName);

                    $("#student-classicTraining").text(registration.classicTraining == 1 ? 'Oui' : 'Non');
                    $("#student-apprenticeshipTraining").text(registration.apprenticeshipTraining == 1 ? 'Oui' : 'Non');

                    setSeeMoreTableValue('cv', folder.cv, 'pdf', studentId);
                    setSeeMoreTableValue('cover_letter', folder.cover_letter, 'pdf', studentId);
                    setSeeMoreTableValue('vle_screenshot', folder.vle_screenshot, 'img', studentId);
                    setSeeMoreTableValue('registration_form', folder.registration_form, 'pdf', studentId);

                    setConversation(messages);

                    for (let i = 0; i < 3; i++) {
                        setSeeMoreTableValue('report_card_' + i, null, 'pdf', studentId);
                    }

                    $(report_cards).each(function(idx) {
                        var report_card = report_cards[idx];
                        var fileName = report_card.name;
                        var name = fileName.split('.pdf')[0];
                        setSeeMoreTableValue(name, fileName, 'pdf', studentId);
                    });
                    $('#seeMore-loader').hide();
                    $("#seeMore-table").show();
                    $(document).find(":submit").prop('disabled', false);
                },
                error: function() {
                    displayToastr('error');
                },
            });

        });

        $('#editStatusModal').on('show.bs.modal', function(e) {
            var registrationId = $(e.relatedTarget).data('id');
            $("#registrationId").val(registrationId);
            var rowIdx = $("#registrationsTable").find("#registration_" + registrationId).index();
            var statusId = registrationsTable.row(rowIdx).data()['registration_status_id'];
            $("#registrationStatus").val(statusId);
        });

        $("#formAddTeacher").submit(function(e) {
            var form = $(this);
            e.preventDefault();

            var hasFail = false;

            $('.addTeacherDiv').each(function(index, value) {
                var email = $(this).find('.teacherEmail').val();
                var password = $(this).find('.teacherPassword').val();

                var inputDivCount = $('.addTeacherDiv').length;

                tryAddTeacher(email, password, teachersTable).then(() => {
                    if (index === $('.addTeacherDiv').length - 1 && !hasFail) {
                        $('#addTeacherModal').modal('toggle');
                    } else {
                        $(this).remove();
                    }
                }, () => {
                    hasFail = true;
                    $(this).addClass('border border-warning');
                });;
            });
        });

        $("#formEditStatus").submit(function(e) {
            var registrationId = $("#registrationId").val();
            var statusTitle = $("#registrationStatus option:selected").text();
            var rowIdx = $("#registrationsTable").find("#registration_" + registrationId).index();
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
        });

        $("#formDownloadMultipleRegistrations").submit(function(e) {
            var form = $(this);
            e.preventDefault();

            var xhr = new XMLHttpRequest();
            $.ajax({
                url: '/RegistrationsStudy/downloadMultipleRegistrations',
                type: 'POST',
                data: $("#formDownloadMultipleRegistrations").serialize(),
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

        });

        $("#addMoreEmail").click(function() {
            addInputEmail();
        });
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

    function setSeeMoreTableValue(tdId, value, typeDoc, studentId) {
        var td = $("#student-" + tdId);

        if (value != null) {
            if (typeDoc) {
                var doc = td.children().first();
                var buttonDisplayFile = td.children().last();

                if (typeDoc == 'pdf') {
                    var src = '';
                    if (value.indexOf('report_card') != -1) {
                        var idx = value.split('_')[2].split('.pdf')[0];
                        src = '/Registration/GetFile?fileName=report_card&number=' + idx + '&studentId=' + studentId;
                    } else {
                        src = '/Registration/GetFile?fileName=' + tdId + '&studentId=' + studentId;
                    }
                } else {
                    src = '/Registration/GetFile?fileName=' + tdId + '&studentId=' + studentId;
                }
                doc.attr('src', src);
                buttonDisplayFile.off("click", "");
                buttonDisplayFile.on('click', function() {
                    displayFile(src, typeDoc == 'pdf');
                });
            } else {
                td.text(value);
            }
            td.removeClass('hidden');
            $("#student-" + tdId + "-none").addClass('hidden');
        } else {
            td.addClass('hidden');
            $("#student-" + tdId + "-none").removeClass('hidden');
        }
    }

    function tryAddTeacher(email, password, teachersTable) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '/Teacher/Add',
                type: 'POST',
                data: {
                    teacherEmail: email,
                    teacherPassword: password,
                },
                success: function(data) {
                    teachersTable.row.add([data.teacherId, email, '<td><button class="btn btn-danger removeTeacher" type="button">Supprimer</button></td>']).draw(false);
                    $('#formAddTeacher').find(":submit").prop('disabled', false);
                    displayToastr('teacherAdded');
                    resolve();
                },
                error: function(xhr, status, error) {
                    $('#formAddTeacher').find(":submit").prop('disabled', false);
                    if (xhr.responseJSON.message == 'emailNotPossible') {
                        displayToastr('errorMsg', 'Cet email n\'est pas disponible !');
                    } else if (xhr.responseJSON.message == 'emailAlreadyExist') {
                        displayToastr('errorMsg', 'Un professeur ayant la même adresse mail <i class="fa fa-info-circle text-info"></i> existe déjà !');
                    } else {
                        displayToastr('error');
                    }
                    reject();
                },
            });
        });
    }

    function getRandString() {
        var possible = '';
        possible += 'abcdefghijklmnopqrstuvwxyz';
        possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        possible += '0123456789';
        possible += '![]{}()%&*$#^<>~@|';
        var text = '';
        for (var i = 0; i < 12; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

    function addInputEmail() {

        var inputDiv =
            $('<div class="mt-3 border border-dark addTeacherDiv">' +
                '    <button type="button" class="btn btn-danger removeEmailInput" onclick="$(this).parent().remove();"><i class="fa fa-times"></i></button>' +
                '    <br>' +
                '    <div class="input-group">' +
                '        <label for="teacherEmail" class="col-md-2">Email: </label><br />&nbsp;&nbsp;' +
                '        <input class="form-control teacherEmail col-md-8" type="email" required><br>' +
                '    </div>' +
                '    <div class="input-group">' +
                '        <label for="teacherPassword" class="col-md-2">Mot de passe: </label><br />&nbsp;&nbsp;' +
                '        <input class="form-control teacherPassword col-md-8" type="text" required>&nbsp;&nbsp;' +
                '        <button type="button" class="btn btn-secondary reload" onclick="$(this).parent().find(\'.teacherPassword\').val(getRandString())"><i class="fas fa-sync-alt" aria-hidden="true"></i></button>' +
                '    </div>' +
                '</div>');

        if ($('.addTeacherDiv').length < 1) {
            $(inputDiv).find(".removeEmailInput").remove();
        }
        $(inputDiv).find('.teacherPassword').val(getRandString());
        $("#addTeachersInputDiv").append(inputDiv);
    }

    function appendTrToSeeMoreTable(trRow, isReportCard) {
        var trStart = '<tr class="trFile">';
        var trEnd = '</tr>';
        var th = '<th>' + trRow[0] + '</th>';
        var tdColspan = !isReportCard ? 'colspan="3" ' : '';

        var content = '<td ' + tdColspan + ' class="hidden" id="student-' + trRow[1] + '">';
        if (trRow[1] == "vle_screenshot") {
            content += '<img src="" class="img-fluid">';
        } else {
            content += '<embed src="" style="width:150px; height:200px;" frameborder="0">';
        }
        content += '<a href="#"><i class="fas fa-external-link-alt"></i></a></td>';
        content += '<td ' + tdColspan + ' id="student-' + trRow[1] + '-none">Non renseigné</td>';

        if (!isReportCard) {
            $("#seeMore-table").append(trStart + th + content + trEnd);
        } else {
            $("#trReportCards").append(content);
        }
    }

    function setConversation(messages) {
        var td = $('#student-conversation').children().last();
        var div = td.children().first();
        div.empty();
        if (messages.length != 0) {
            $(messages).each(function(i, message) {
                var msg =
                    '<div class="media w-50 mb-3">' +
                    '  <div class="media-body ml-3">' +
                    '    <div class="bg-light rounded py-2 px-3 mb-2">' +
                    '      <p class="text-small mb-0 text-muted">' + message.messageContent + '</p>' +
                    '    </div>' +
                    '    <p class="small text-muted">' + moment(message.messageDate).format('DD MMMM | HH:mm') + '</p>' +
                    '  </div>' +
                    '</div>';
                var response =
                    '<div class="media w-50 ml-auto mb-3">' +
                    '  <div class="media-body">' +
                    '    <div class="bg-primary rounded py-2 px-3 mb-2">' +
                    '      <p class="text-small mb-0 text-white">' + message.responseContent + '</p>' +
                    '    </div>' +
                    '    <p class="small text-muted">' + moment(message.responseDate).format('DD MMMM | HH:mm') + '</p>' +
                    '  </div>' +
                    '</div>';
                div.append(msg);
                if (message.responseContent != null)
                    div.append(response);
            });
            div.css("overflow", "scroll")
        } else {
            div.append("Aucun message n'a été échangé");
            div.css("overflow", "hidden")
        }
    }
</script>

@endsection