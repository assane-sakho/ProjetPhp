<br />
<h5>Déposez {{ $uploadTitle }}</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <p>Vous avez déjà enregistré <b><u data-toggle="modal" data-target="#displayFilesModal-{{ $inputName }}">{{ count($filesUploaded)}} document(s)</u></b>.
        </p>

        <p class=" warningReplace-{{ $inputName }}"><b class="text-danger">Attention</b> : Remplacer le document actuel effaçera le précédent.
            <br />
            <button type="button" class="btn btn-sm btn-warning warningReplace-{{ $inputName }}" onclick="
            $('#divUpload-{{ $inputName }}').removeClass('d-none');
            $('#{{ $inputName }}').removeAttr('disabled');
            $('.cancelReplace-{{ $inputName }}').show();
            $('.warningReplace-{{ $inputName }}').hide();">Remplacer</button>
        </p>
        <p>
            <button type="button" class="btn btn-sm btn-info cancelReplace-{{ $inputName }}" onclick="
            $('#divUpload-{{ $inputName }}').addClass('d-none');
            $('#{{ $inputName }}').prop('disabled', true);
            $('.warningReplace-{{ $inputName }}').show();
            $('.cancelReplace-{{ $inputName }}').hide();">Annuler le remplacement</button>
        </p>
        <br />
        <div id="divUpload-{{ $inputName }}" class="d-none">
            <table class="table table-bordered">
                <tr>
                    <td>{{ $fileText }}</td>
                    <td>
                        <input class="input-{{ $inputName }} form-control" accept="{{ $acceptedFile }}application/pdf" name="{{ $inputName }}" id="{{ $inputName }}" type="file" onchange="$(this).removeClass('bg-danger');" required disabled>
                    </td>
                </tr>
            </table>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="displayFilesModal-{{ $inputName }}" tabindex="-1" role="dialog" aria-labelledby="displayFilesModalLabel-{{ $inputName }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Affichage de {{ $uploadTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div id="{{ $inputName }}-content" class="col-md-12 d-flex justify-content-center">
                            <div id="loading-{{ $inputName }}">
                                Chargement {{ $uploadTitle }}...&nbsp;
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                </div>
                            </div>
                            <br />
                            @if( $inputName == "vle_screenshot")
                            <img id="img-{{ $inputName }}" class="img-fluid" src="/Registration/GetFile?fileName={{ $inputName }}" alt="">
                            @else
                            <embed id="embed-{{ $inputName }}" src="/Registration/GetFile?fileName={{ $inputName }}" style="width:600px; height:800px;" frameborder="0">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.cancelReplace-{{ $inputName }}').hide();
        $('#embed-{{ $inputName }}, #img-{{ $inputName }}').on('load', function() {
            $("#loading-{{ $inputName }}").hide();
        });
    });
</script>