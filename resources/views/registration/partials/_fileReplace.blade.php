<br />
<h5>Déposez {{ $data['uploadTitle'] }}</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <p>Vous avez déjà enregistré <b><u data-toggle="modal" data-target="#displayFilesModal-{{ $data['inputName'] }}">{{ count($data['filesUploaded']) }} document(s)</u></b>.
        </p>
        @if(!session('isRegistrationComplete'))
        <p class=" warningReplace-{{ $data['inputName'] }}"><b class="text-danger">Attention</b> : Remplacer le document actuel effaçera le précédent.
            <br />
            <button type="button" class="btn btn-sm btnRegistration btn-warning warningReplace-{{ $data['inputName'] }}" onclick="replaceFile()">Remplacer</button>
        </p>
        <p>
            <button type="button" class="btn btn-sm btnRegistration btn-info cancelReplace-{{ $data['inputName'] }}" onclick="cancelReplaceFile()">Annuler le remplacement</button>
        </p>
        @endif
        <br />
        <div id="divUpload-{{ $data['inputName'] }}" class="d-none">
            <table class="table table-bordered">
                <tr>
                    <td>{{ $data['fileText'] }}</td>
                    <td>
                        <input class="input-{{ $data['inputName'] }} form-control" accept="{{ $data['acceptedFile'] }}" name="{{ $data['inputName'] }}" id="{{ $data['inputName'] }}" type="file" onchange="$(this).removeClass('bg-danger');" required disabled>
                    </td>
                </tr>
            </table>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="displayFilesModal-{{ $data['inputName'] }}" tabindex="-1" role="dialog" aria-labelledby="displayFilesModalLabel-{{ $data['inputName'] }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Affichage de {{ $data['uploadTitle'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div id="{{ $data['inputName'] }}-content" class="col-md-12 d-flex justify-content-center">
                            <div id="loading-{{ $data['inputName'] }}">
                                Chargement {{ $data['uploadTitle'] }}...&nbsp;
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                </div>
                            </div>
                            <br/>
                            @if( $data['inputName'] == "vle_screenshot")
                            <img id="img-{{ $data['inputName'] }}" class="img-fluid" src="/Registration/GetFile?fileName={{ $data['inputName'] }}" alt="vle_screenshot">
                            @else
                            <embed id="embed-{{ $data['inputName'] }}" src="/Registration/GetFile?fileName={{ $data['inputName'] }}" style="width:600px; height:800px;" frameborder="0">
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
    function replaceFile() {
        $("#divUpload-{{ $data['inputName'] }}").removeClass('d-none');
        $("#{{ $data['inputName'] }}").removeAttr('disabled');
        $(".cancelReplace-{{ $data['inputName'] }}").show();
        $(".warningReplace-{{ $data['inputName'] }}").hide();
    }

    function cancelReplaceFile() {

        $("#divUpload-{{ $data['inputName'] }}").addClass('d-none');
        $("#{{ $data['inputName'] }}").prop('disabled', true);
        $(".warningReplace-{{ $data['inputName'] }}").show();
        $(".cancelReplace-{{ $data['inputName'] }}").hide();
    }
    
    $(document).ready(function() {
        $(".sw-container").css({"min-height" : "0px"});
        $(".cancelReplace-{{ $data['inputName'] }}").hide();
        $("#embed-{{ $data['inputName'] }}").on('load', function() {
            $("#loading-{{ $data['inputName'] }}").hide();
        });
        $("#loading-{{ $data['inputName'] }}").hide()
    });
</script>
