@php
    $i = 0;
@endphp
<br />
<h5>Déposez vos relevés de notes</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <table class="table table-bordered">
            @for(; $i < count($filesUploaded); $i++)
            <tr>
                <td>{{ $fileText }} n° {{ $i+1 }}</td>
                <td>
                    <embed id="embed-{{ $inputName }}_{{ $i }}" src="/Registration/GetFile?fileName={{ $inputName }}&number={{ $i }}" style="width:600px; height:800px;" frameborder="0">
                </td>
                @if(!$isComplete)
                <td><button class="btn btn-danger btnRegistration deleteFile" type="button">Supprimer</button></td>
                @endif
                </tr>
            @endfor
                @if($i < 3 && !$isComplete)
                    @php
                        if($i < 1) 
                            $required="required" ; else $required="" ; 
                    @endphp 
                    <tr>
                        <td>{{ $fileText }} n° {{ $i +1 }}</td>
                        <td>
                            <input class="input-{{ $inputName }} form-control" accept="application/pdf" name="{{ $inputName }}_{{ $i }}" id="{{ $inputName }}_{{ $i }}" type="file" onchange="$(this).removeClass('bg-danger');" {{$required }}>
                            <div class="help-block with-errors"></div>
                        </td>
                    </tr>
                @endif
        </table>
        <div class="help-block with-errors"></div>
    </div>
</div>
<script>
    $(".deleteFile").click(function() {
        var row = $(this).closest('tr');
        var index = row.index();

        if (registrationEditable) {
            $.ajax({
                url: '/Registration/DeleteFile',
                type: 'POST',
                data: {
                    fileName: "{{ $inputName }}",
                    number: index
                },
                success: function(data) {
                    displayToastr('deleted');
                    row.remove();
                },
                error: function(xhr, status, error) {
                    displayToastr('error');
                },
            });
        }
    })
</script>