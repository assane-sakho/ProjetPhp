<br />
<h5>Déposez {{ $data['uploadTitle'] }}</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <table class="table table-bordered">
            <tr>
                <td>{{ $data['fileText'] }}</td>
                <td>
                    <input class="input-{{ $data['inputName'] }} form-control" 
                    accept="{{ $data['acceptedFile'] }}" 
                    name="{{ $data['inputName'] }}" 
                    id="{{ $data['inputName'] }}" 
                    type="file" 
                    onchange="$(this).removeClass('bg-danger');" required>
                </td>
            </tr>
        </table>
        <div class="help-block with-errors"></div>
    </div>
</div>