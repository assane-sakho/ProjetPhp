@extends('layout.mainlayout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        var fileName = $("title").text() + " - " +  $("#title").text();

        $("table").DataTable({
            "language" : {
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Afficher _MENU_ éléments",
                "sLoadingRecords": "Chargement...",
                "sProcessing":     "Traitement...",
                "sSearch":         "Rechercher :",
                "sZeroRecords":    "Aucun élément correspondant trouvé",
                "oPaginate": {
                    "sFirst":    "Premier",
                    "sLast":     "Dernier",
                    "sNext":     "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
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
            buttons: [
                { extend: 'csv', text: 'CSV', title : fileName, exportOptions: { columns: ':visible:not(.not-export-col)'}},
                { extend: 'excel', text: 'Excel', title : fileName, exportOptions: { columns: ':visible:not(.not-export-col)'} },
                { extend: 'pdf', text: 'PDF', title : fileName, exportOptions: { columns: ':visible:not(.not-export-col)'} },
                { extend: 'print', text: 'Imprimer', title : fileName, exportOptions: { columns: ':visible:not(.not-export-col)'} },
                { extend: 'copy', text: 'Copier', title : fileName, exportOptions: { columns: ':visible:not(.not-export-col)'} }
            ]
        });
    });
</script>
@endsection
