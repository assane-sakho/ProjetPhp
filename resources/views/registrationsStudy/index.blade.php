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
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                        Ajouter des professeurs
                    </button>
                    <button type="button" class="btn btn-success">Télécharger toutes les candidatures</button>

                </p><br />
                <form id="formDownloadRegistration" action="" method="POST">
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
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editStatusModal" data-id="{{ $registration->id }}" data-statusid="{{ $registration->registration_status->id}}">Modifier</button>
                                        @else
                                        <i class="fas fa-hourglass"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        @if($registration->registration_status->id != 1)
                                        <button type="submit" value="Téléchager" id="btnDownload{{ $registration->id }}" class="btn btn-success downloadRegistration" data-id="{{ $registration->student->id }}">Télécharger</button>
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


<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter des professeurs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="Teacher/Add">
                    <label for="teacherEmail">Email: </label>
                    <input class="form-control" type="text" name="teacherEmail" id="teacherEmail"><br />

                    <label for="teacherEmail">Mot de passe: </label>
                    <input class="form-control" type="password" name="teacherPassword" id="teacherPassord">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Ajouter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier le statut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditStatus" action="RegistrationStudy/EditStatus" method="POST">
                    <input type="hidden" id="registrationId">
                    <label for="registrationStatus">Statut :</label><br />
                    <select name="registrationStatus" id="registrationStatus" class="form-control">
                        <option value="">-- Sélectionnez un statut --</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning">Modifier</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var fileName = $("title").text() + " - " + $("#title").text();
        // var filterValues = {};
        $(document).ready(function() {
            $('.table').DataTable({
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
        });

        $('#editStatusModal').on('show.bs.modal', function(e) {
            $("#registration").val($(e.relatedTarget).data('id'));
            $('#registrationStatus').val($(e.relatedTarget).data('statusid')).change();
        });

        $(".downloadRegistration").click(function(e) {
            e.preventDefault();
            var form = $("#formDownloadRegistration");
            $("#student_id").val($(this).data('id'));
            $.ajax({
                url: '/RegistrationsStudy/DownloadRegistration',
                type: 'POST',
                data: form.serialize(),
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, textStatus, request) {
                    var fileName = request.getResponseHeader("Content-disposition").split('="')[1].replace('"', "");
                    $(this).prop('disabled', false);
                    displayToastr('studentRegistred');
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = fileName;
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    $(this).prop('disabled', false);
                    displayToastr('error');
                },
            });
        })
    });
</script>
@endsection