<br />
<h5>Déposez {{ $uploadTitle }}</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <table class="table table-bordered">
            <tr>
                <td>{{ $fileText }}</td>
                <td>
                    <input class="input-{{ $inputName }} form-control" accept="{{ $acceptedFile }}application/pdf" name="{{ $inputName }}" id="{{ $inputName }}" type="file" onchange="$(this).removeClass('bg-danger');" required>
                    <div class="help-block with-errors"></div>
                </td>
            </tr>
        </table>
        <div class="help-block with-errors"></div>
    </div>
</div>