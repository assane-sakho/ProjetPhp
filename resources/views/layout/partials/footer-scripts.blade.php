<script  src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script  src="{{ asset('js/bootstrap.min.js') }}"></script>
<script  src="{{ asset('js/toastr/toastr.js') }}"></script>
<script  src="{{ asset('js/smart_wizard/validator.min.js') }}"></script>
<script  src="{{ asset('js/smart_wizard/jquery.smartWizard.js') }}"></script>
<script  src="{{ asset('js/function.js') }}"></script>
<script  src="{{ asset('js/dataTables/datatables.js') }}"></script>
<script  src="{{ asset('js/dataTables/dataTables.buttons.min.js') }}"></script>
<script  src="{{ asset('js/dataTables/buttons.flash.min.js') }}"></script>
<script  src="{{ asset('js/dataTables/jszip.min.js') }}"></script>
<script  src="{{ asset('js/dataTables/pdfmake.min.js') }}"></script>
<script  src="{{ asset('js/dataTables/vfs_fonts.js') }}"></script>
<script  src="{{ asset('js/dataTables/popper.min.js') }}"></script>
<script  src="{{ asset('js/dataTables/buttons.html5.min.js') }}"></script>
<script  src="{{ asset('js/dataTables/buttons.print.min.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>