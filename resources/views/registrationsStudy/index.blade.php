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
                                <td>Classique</td>
                                <td>Apprentissage</td>
                                <td>Voir +</td>
                                <td>Modifier le statut</td>
                                <td>Télécharger les docs.</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['registrations'] as $registration)
                            <tr id="registration_{{ $registration->id }}">
                                <td>{{ $registration->id }}</td>
                                <td>{{ $registration->student->lastname }}</td>
                                <td>{{ $registration->student->firstname  }}</td>
                                <td>{{ $registration->training->name ?? 'Non renseigné' }}</td>
                                <td>{{ $registration->registration_status->title  }}</td>
                                <td><i class="fas fa-{{ $registration->classicTraining == '1' ? 'check text-success' : 'times text-danger'}}"></i></td>
                                <td><i class="fas fa-{{ $registration->apprenticeshipTraining == '1' ? 'check text-success' : 'times text-danger'  }}"></i></td>
                                <td class="not-export-col">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#seeMoreModal" data-id="{{ $registration->id }}">Voir +</button>
                                    </div>
                                </td>
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
                            @foreach($data['teachers'] as $teacher)
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
                    <label for="trainingType">Choix du type de candidature :</label><br />
                    <select name="trainingType" id="trainingType" class="form-control">
                        <option value="all">Tout les types</option>
                        <option value="classic">Classique</option>
                        <option value="apprenticeship">Apprentissage</option>
                    </select>
                    <br />
                    <br />
                    <div class="help-block with-errors"></div> <button class="btn btn-success" id="downloadAllRegistration" value="Télécharger" type="submit">Télécharger</button>
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

<div class="modal fade" id="seeMoreModal" tabindex="-1" role="dialog" aria-labelledby="seeMoreModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seeMoreModalLabel">Informations de <span id="seeMore-studentName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="spinner-border" role="status" id="seeMore-loader">
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
                        <td colspan="3" id="training-none">Non renseigné</td>
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
                    <tr>
                        <th>CV</th>
                        <td colspan="3" class="hidden" id="student-cv">
                            <embed src="" style="width:150px; height:200px;" frameborder="0">
                        </td>
                        <td colspan="3" id="cv-none">Non renseigné</td>
                    </tr>
                    <tr>
                        <th>Lettre de motivation</th>
                        <td colspan="3" class="hidden" id="student-cover_letter">
                            <embed src="" style="width:150px; height:200px;" frameborder="0">
                        </td>
                        <td colspan="3" id="cover_letter-none">Non renseigné</td>
                    </tr>
                    <tr>
                        <th>Relevés de notes de l’année précédente</th>
                        @for($i = 0; $i < 3; $i++) <td id="student-report_card_{{ $i }}" class="hidden">
                            <embed src="" style="width:150px; height:200px;" frameborder="0">
                            </td>
                            <td id="report_card_{{ $i }}-none">Non renseigné</td>
                            @endfor
                    </tr>
                    <tr>
                        <th>Imprime écran de l’ENT de l’année en cours</th>
                        <td colspan="3" class="hidden" id="student-vle_screenshot">
                            <img class="img-fluid" src="" alt="">
                        </td>
                        <td colspan="3" id="vle_screenshot-none">Non renseigné</td>
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
            $("embed, #student-vle_screenshot").attr('src', '')

            var studentId = $(e.relatedTarget).data('id');
            var rowIdx = $("#registrationsTable").find("#registration_" + studentId).index();
            var studentName = registrationsTable.row(rowIdx).data()[1] + ' ' + registrationsTable.row(rowIdx).data()[2];
            $("#seeMore-studentName").text(studentName);

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
                    var folder = data.folder;
                    var report_cards = data.report_cards;

                    setTableValue('registration_status', registration_status.title);
                    setTableValue('card_id', student.card_id);
                    setTableValue('birthdate', moment(student.birthdate).format('DD-MM-YYYY'));
                    setTableValue('email', student.email);
                    setTableValue('phone_number', student.phone_number);
                    setTableValue('address', address.street + ', ' + address.zip_code + ' ' + address.city);

                    if (training) {
                        setTableValue('training', training.name);
                    }

                    $("#student-classicTraining").text(registration.classicTraining == 1 ? 'Oui' : 'Non');
                    $("#student-apprenticeshipTraining").text(registration.apprenticeshipTraining == 1 ? 'Oui' : 'Non');

                    setTableValue('cv', folder.cv, 'pdf', studentId);
                    setTableValue('cover_letter', folder.cover_letter, 'pdf', studentId);
                    setTableValue('vle_screenshot', folder.vle_screenshot, 'img', studentId);

                    for (let i = 0; i < 3; i++) {
                        setTableValue('report_card_' + i, null, 'pdf', studentId);
                    }

                    $(report_cards).each(function(idx) {
                        var report_card = report_cards[idx];
                        var fileName = report_card.name;
                        var name = fileName.split('.pdf')[0];
                        setTableValue(name, fileName, 'pdf', studentId);
                    });
                    $('#seeMore-loader').hide();
                    $("#seeMore-table").show();
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
            var statusTitle = registrationsTable.row(rowIdx).data()[4];
            $("#registrationStatus option").each(function() {
                this.selected = (this.text == statusTitle);
            });
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

    function setTableValue(tdId, value, typeDoc, studentId) {
        var td = $("#student-" + tdId);

        if (value != null) {
            if (typeDoc) {
                var doc = td.children().first();
                if (typeDoc == 'pdf') {
                    var src = '';
                    if (value.indexOf('report_card') != -1) {
                        var idx = value.split('_')[2].split('.pdf')[0];
                        src = '/Registration/GetFile?fileName=report_card&number=' + idx + '&studentId=' + studentId;
                    } else {
                        src = '/Registration/GetFile?fileName=' + tdId + '&studentId=' + studentId;
                    }
                    doc.attr('src', src);
                } else {
                    doc.attr('src', '/Registration/GetFile?fileName=' + tdId + '&studentId=' + studentId);
                }

            } else {
                td.text(value);
            }
            td.removeClass('hidden');
            $("#" + tdId + "-none").addClass('hidden');
        } else {
            td.addClass('hidden');
            $("#" + tdId + "-none").removeClass('hidden');
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

    function randString() {
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
                '        <button type="button" class="btn btn-secondary reload" onclick="$(this).parent().find(\'.teacherPassword\').val(randString())"><i class="fas fa-sync-alt" aria-hidden="true"></i></button>' +
                '    </div>' +
                '</div>');

        $(inputDiv).find('.teacherPassword').val(randString());
        $("#addTeachersInputDiv").append(inputDiv);
    }

</script>

@endsection