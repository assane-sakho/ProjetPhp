<!-- jquery slim -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<!-- popper js -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- bootstarp js -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- owl carousel js -->
<script src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
<!-- aos js -->
<script src="{{ asset('vendors/aos/aos.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('js/custom.js') }}"></script>
<!-- Functions js -->
<script src="{{ asset('js/functions.js') }}"></script>
<!-- Toastr js -->
<script src="{{ asset('vendors/toastr/js/toastr.js') }}"></script>
<!-- Validator js -->
<script src="{{ asset('vendors/smart_wizard/js/validator.min.js') }}"></script>
<!-- Smart wizard js -->
<script src="{{ asset('vendors/smart_wizard/js/jquery.smartWizard.js') }}"></script>
<!-- FontAwesome js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
<!-- DataTables Button print js -->
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>


<!-- DataTables js -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.3.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.62/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.62/vfs_fonts.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="date"]').attr('max', moment().format('YYYY-MM-DD'));   

        var btnSubmitClicked;
        var loadingText = 'Chargement ';
        var loader = '&nbsp;<i class="fa fa-spinner fa-spin"></i>';
        moment.locale('fr')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(':submit').click(function() {
            btnSubmitClicked = this;
            $(btnSubmitClicked).text(loadingText);
            $(btnSubmitClicked).append(loader);
        });

        $(document).ajaxStart(function() {
            $(':submit').each(function() {
                $(this).prop('disabled', true);
            });
        });

        $(document).ajaxStop(function() {
            $(':submit').not(btnSubmitClicked).each(function() {
                $(this).prop('disabled', false);
            });
            $(btnSubmitClicked).text($(btnSubmitClicked).val());
        });

        $('#logout').click(function() {
            $.ajax({
                url: '/Logout',
                type: 'POST',
                success: function(data) {
                    window.location.href = "/";
                    displayToastr('disconnected');
                },
                error: function(xhr, status, error) {
                    displayToastr('error');
                }
            });

        });
        $.extend(true, $.fn.dataTable.defaults, {
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
        });

    });
</script>