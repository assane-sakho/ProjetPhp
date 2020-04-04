<br />
<h5>Déposez {{ $uploadTitle }}</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <p>Vous avez déjà enregistré <b><u data-toggle="modal" data-target="#displayFilesModal-{{ $inputName }}">{{ count($filesUploaded)}} {{ lcfirst($fileText)}}</u></b>.<br />
            Vous pouvez encore en ajouter {{ 3- count($filesUploaded) }}.
        </p>
        <table class="table table-bordered">
            <tr>
                <td>{{ $fileText }}</td>
                <td>
                    <input class="input-{{ $inputName }} form-control" accept="{{ $acceptedFile }}application/pdf" name="{{ $inputName }}" id="{{ $inputName }}" type="file" onchange="$(this).removeClass('bg-danger');" required>
                </td>
            </tr>
        </table>
        <div class="help-block with-errors"></div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
       if('{{ count($filesUploaded) }}' > 0)
       {
            $("#input-{{ $inputName }}").prop('disabled', true);
       }
    });
</script>