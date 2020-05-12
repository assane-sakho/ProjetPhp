@php
$i = 0;
@endphp

<br />
<h5>Déposez vos relevés de notes</h5>
<div id="form-step-{{ $stepNumber }}" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <table class="table table-bordered">
            @for(; $i < count($data['filesUploaded']); $i++) <tr>
                <td class="{{ $data['inputName'] }}_title">{{ $data['fileText'] }} n° {{ $i+1 }}</td>
                <td>
                    <embed id="embed-{{ $data['inputName'] }}_{{ $i }}" src="/Registration/GetFile?fileName={{ $data['inputName'] }}&number={{ $i }}" style="width:600px; height:800px;" frameborder="0">
                </td>
                @if(!session('isRegistrationComplete') && count($data['filesUploaded']) > 1)
                <td><button class="btn btn-danger btnRegistration deleteFile" type="button">Supprimer</button></td>
                @endif
                </tr>
                @endfor

                @if($i < 3 && !session('isRegistrationComplete')) @for($j=0; $j < 3 - count($data['filesUploaded']); $j++) @php $required="" ; if($j==0 && $i==0) $required="required" ; @endphp <tr>
                    <td>{{ $data['fileText'] }} n° {{ $j + $i +1 }}</td>
                    <td colspan="2">
                        <input class="input-{{ $data['inputName'] }} form-control" accept="application/pdf" name="{{ $data['inputName'] }}_{{ ($j + $i) }}" id="{{ $data['inputName'] }}_{{ ($j + $i) }}" type="file" onchange="$(this).removeClass('bg-danger'); $('.help-block').hide();" {{ $required }}>
                    </td>
                    </tr>
                    @endfor
                    @endif
        </table>
        <div class="help-block with-errors">Veuillez sélectionner un fichier.
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".sw-container").css({
                "min-height": "0px"
            });
            $(".help-block").hide();
            $(".deleteFile").click(function() {
                var row = $(this).closest('tr');
                var index = row.index();

                $.ajax({
                    url: '/Registration/DeleteFile',
                    type: 'POST',
                    data: {
                        fileName: "{{ $data['inputName'] }}",
                        number: index
                    },
                    success: function(data) {
                        displayToastr('deleted');

                        var table = row.parent().parent();
                        row.remove();

                        $(".sw-container").css({
                            "min-height": "0px"
                        });

                        var reportCardCount = table.find('embed').length;

                        if (reportCardCount == 1) {
                            $(".deleteFile").remove();
                        }

                        var idx = $('#form-step-{{ $stepNumber }}').find('embed').length + $('#form-step-{{ $stepNumber }}').find('input').length;
                        var tr = $('<tr></tr>').append('<td>Relevé de note n° ' + (idx + 1) + '</td>' +
                            '<td colspan="2">' +
                            '<input class="input-{{ $data["inputName"] }} form-control" ' +
                            'accept="application/pdf" ' +
                            'name="{{ $data["inputName"] }}_' + idx + '" ' +
                            'id="{{ $data["inputName"] }}_' + idx + '" ' +
                            'type="file" onchange="$(this).removeClass(\'bg-danger\'); $(\'.help-block\').hide();" ' +
                            '</td>');
                        table.append(tr);

                        $('#form-step-{{ $stepNumber }} td:first-child').each(function(idx) {
                            $(this).text("Relevé de note n° " + (idx + 1));
                            var inputFile = $(this).parent().find('input');
                            if (inputFile.length != 0) {
                                inputFile
                                .attr('name', '{{ $data["inputName"] }}_' + idx)
                                .attr('id', '{{ $data["inputName"] }}_' + idx);
                            }
                            idx++;
                        });
                    },
                    error: function(xhr, status, error) {
                        displayToastr('error');
                    },
                });

            });
        });
    </script>