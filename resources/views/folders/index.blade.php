@extends('layout.mainlayout')

@section('content')

<section class="breadcrumb_part blog_grid_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <div class="breadcrumb_iner">
                    <h2>Étude des dossiers</h2>
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
                </p><br />
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
                    </tbody>
                </table>
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
                <form action="Folder/EditStatus">
                    <input type="hidden" id="folderId">
                    <label for="folderStatus">Statut :</label><br/>
                    <select name="folderStatus" id="folderStatus" class="form-control">
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

        $("table").DataTable({
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
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "Folders/Get",
                dataSrc: ""
            },
            "columns": [
                null,
                null,
                null,
                null,
                null,
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data[5] != 1) {
                            var result = $('<button><button>')
                                .text('Modifier')
                                .addClass('btn btn-warning')
                                .attr('data-toggle', 'modal')
                                .attr('data-id', data[0])
                                .attr('data-statusid', data[5])
                                .attr('data-target', '#editStatusModal').prop('outerHTML');
                        }
                        else
                        {
                            var result = '<i class="fas fa-hourglass"></i>';
                        }
                        return '<div class="text-center">' + result + '</div>';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data[5] != 1) {
                            var result = $('<button><button>')
                                .text('Télécharger')
                                .addClass('btn btn-success')
                                .attr('data-id', data[0]).prop('outerHTML');
                        }
                        else
                        {
                            var result = '<i class="fas fa-hourglass"></i>';
                        }
                        return '<div class="text-center">' + result + '</div>';
                    }
                }
            ]
        });

        $('#editStatusModal').on('show.bs.modal', function(e) {
            $('#folderId').val($(e.relatedTarget).data('id'));
            $('#folderStatus').val($(e.relatedTarget).data('statusid')).change();
        });
    });
</script>
@endsection