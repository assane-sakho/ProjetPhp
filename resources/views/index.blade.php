@extends('layout.mainlayout')

@section('content')

<div class="text-center">
  <h1>Gestion des candidatures</h1>
  </p>
  <button class="btn btn-primary btn-lg" style="width: 25%;" id="btnSignIn">Deposer une candidature</button>&nbsp;
  <button class="btn btn-success btn-lg" style="width: 25%;" id="btnLogIn">Se connecter</button>
</div>  

<div class="d-flex justify-content-around p-5">

  <div class="col-md-3" id="logInDiv">
    <h4 class="mb-3">Connexion</h4>
    <hr class="mb-4">
    <form action="" id="formLogIn">
      @csrf
      <label for="userId">Adresse mail :</label>
      <input type="mail" name="userId" id="userId" class="form-control"required></p>

      <label for="userPassword">Mot de passe :</label>
      <input type="password"name="userPassword" id="userPassword" class="form-control"required></p>

      <hr class="mb-4">
      <button class="btn btn-secondary btn-lg btn-block" type="submit">Se connecter</button>
    </form>
  </div>

  <div class="col-md-8" id="signInDiv">
    <form action="" id="formSignIn">
      @csrf
      <h4 class="mb-3">Inscription</h4>
      <hr class="mb-4">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="userLastname">Nom :</label> <i class="fa fa-info-circle text-info"></i>
          <input type="text" name="userLastname" id="userLastname" class="form-control"required></p>
        </div>
        <div class="col-md-6 mb-3">
          <label for="userFirstname">Prénom :</label> <i class="fa fa-info-circle text-info"></i>
          <input type="text" name="userFirstname" id="userFirstname" class="form-control"required></p>
        </div>
      </div>

      <hr class="mb-4">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="userCardId">N° de carte d'identité :</label> <i class="fa fa-info-circle text-info"></i>
          <input type="text" name="userCardId" id="userCardId" class="form-control"required></p>

          <label for="userBirthdate">Date de naissance</label>
          <input type="date" name="userBirthdate" id="userBirthdate" class="form-control"required></p>
        </div>
      </div>

      <hr class="mb-4">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="userStreet">Rue :</label>
          <input type="text" name="userStreet" id="userStreet" class="form-control"required></p>
        </div>
        <div class="col-md-3 mb-3">
          <label for="userCity">Ville :</label>
          <input type="text" name="userCity" id="userCity" class="form-control"required></p>
        </div>
        <div class="col-md-3 mb-3">
          <label for="userZipCode">Code postal :</label>
          <input type="number" name="userZipCode" id="userZipCode" class="form-control"required></p>
        </div>
      </div>

      <hr class="mb-4">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="userPhoneNumber">Téléphone :</label> <i class="fa fa-info-circle text-info"></i>
          <input type="number" name="userPhoneNumber" id="userPhoneNumber" class="form-control"required></p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="userMail">Adresse mail :</label> <i class="fa fa-info-circle text-info"></i>
          <input type="mail" name="userMail" id="userMail" class="form-control"required></p>
        </div>
        <div class="col-md-6 mb-3">
          <label for="userMail">Mot de passe :</label>
          <input type="password" name="userPassword" id="userPassword" class="form-control"required></p>
        </div>
      </div>

      <hr class="mb-4">

      <button class="btn btn-secondary btn-lg btn-block" type="submit">S'inscire</button>
    </form>
  </div>  

</div>

@endsection
@section('scripts')
  <script>
  $(document).ready(function(){
    $('#signInDiv, #logInDiv').hide();

    $('#btnSignIn, #btnLogIn').click(function(){
      var btnId = $(this).attr('id');
      if(btnId == "btnSignIn")
      {
        $('#logInDiv').hide();
        $('#signInDiv').show();
      }
      else
      {
        $('#signInDiv').hide();
        $('#logInDiv').show();
      }
      $('input').val('');
    });

    $("#formSignIn").submit(function(e){
      e.preventDefault();

      $.ajax({
          url:'/Student/Add',
          type:'GET',
          data:$("#formSignIn").serialize(),
          success: function(data) {
              displayToastr('studentRegistred');
          },
          error: function(xhr, status, error)  {
            if(xhr.responseJSON.message  == 'alreadyExist')
            {
              displayToastr('errorMsg', 
              'Un étudiant ayant les mêmes informations <i class="fa fa-info-circle"></i> existe déjà !');
            }
            else
            {
              displayToastr('error');
            }
          },
      });

    });

    $("#formLogIn").submit(function(e){
      e.preventDefault();

    });

  });
  </script>
@endsection

