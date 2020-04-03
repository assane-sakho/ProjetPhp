 <br />
 <h5>Déposez {{ $uploadTitle }}</h5>
 <div id="form-step-1" role="form" data-toggle="validator">
     <div class="form-group col-md-10">
         <table class="table table-bordered">
             <tr>
                 <td>{{ $fileText }}</td>
                 <td><input class="input-{{ $inputName }} form-control" accept="{{ $acceptedFile }}application/pdf" name="{{ $inputName }}" id="{{ $inputName }}" type="file" data-validation='Veuillez renseiger un CV' required></td>
             </tr>
         </table>
         <div class="help-block with-errors"></div>
     </div>
 </div>