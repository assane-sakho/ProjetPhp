@extends('layout.mainlayout')

@section('content')
<section class="banner_part owl-carousel">
  <div class="single_banner_part bg_1">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-12">
          <div class="banner_iner">
            <h3 class="text-white">Bienvenue sur l'espace de candidature de </h3>
            <h4 class="text-white">Paris Nanterre</h4>
            <div class="text-center">
              <br />
              <button class="btn btn-primary btn-lg" type="button" style="width: 25%;" id="btnSignIn">Deposer une candidature</button>&nbsp;
              <button class="btn btn-success btn-lg" type="button" style="width: 25%;" id="btnLogin">Se connecter</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="bottomSection">

  <div class="d-flex justify-content-around p-5">

    <div class="col-md-3" id="logInDiv" method="POST">
      <h4 class="mb-3">Connexion</h4>
      <hr class="mb-4">
      <form action="" id="formLogIn">
        <label for="userLoginMail">Adresse mail :</label>
        <input type="email" name="userLoginMail" id="userLoginMail" class="form-control" required><br />

        <label for="userLoginPassword">Mot de passe :</label>
        <input type="password" name="userLoginPassword" id="userLoginPassword" class="form-control" required autocomplete="on"><br />

        <hr class="mb-4">
        <button class="btn btn-danger btn-lg btn-block" type="submit" value="Se connecter">Se connecter</button>
      </form>
    </div>

    <div class="col-md-8" id="signInDiv">
      <h4 class="mb-3">Inscription</h4>
      <hr class="mb-4">

      <form action="" id="formSignIn" method="POST">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="userLastname">Nom :</label> <i class="fa fa-info-circle text-info"></i>
            <input type="text" name="userLastname" id="userLastname" class="form-control" maxlength="50" required><br />
          </div>
          <div class="col-md-6 mb-3">
            <label for="userFirstname">Prénom :</label> <i class="fa fa-info-circle text-info"></i>
            <input type="text" name="userFirstname" id="userFirstname" class="form-control" maxlength="50" required><br />
          </div>
        </div>

        <hr class="mb-4">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="userCardId">N° de carte d'identité :</label> <i class="fa fa-info-circle text-info"></i>
            <input type="text" name="userCardId" id="userCardId" class="form-control" maxlength="37" required><br />

            <label for="userBirthdate">Date de naissance</label>
            <input type="date" name="userBirthdate" id="userBirthdate" class="form-control" required><br />
          </div>
        </div>

        <hr class="mb-4">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="userStreet">Rue :</label>
            <input type="text" name="userStreet" id="userStreet" class="form-control" maxlength="50" required><br />
          </div>
          <div class="col-md-3 mb-3">
            <label for="userCity">Ville :</label>
            <input type="text" name="userCity" id="userCity" class="form-control" maxlength="30" required><br />
          </div>
          <div class="col-md-3 mb-3">
            <label for="userZipCode">Code postal :</label>
            <input type="number" name="userZipCode" id="userZipCode" class="form-control" maxlength="5" onKeyPress="if(this.value.length==5) return false;" required><br />
          </div>
        </div>

        <hr class="mb-4">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="userPhoneNumber">Téléphone :</label> <i class="fa fa-info-circle text-info"></i>
            <input type="text" name="userPhoneNumber" id="userPhoneNumber" class="form-control" maxlength="14" required><br />

          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="userMail">Adresse mail :</label> <i class="fa fa-info-circle text-info"></i>
            <input type="mail" name="userMail" id="userMail" class="form-control" required><br />
          </div>
          <div class="col-md-6 mb-3">
            <label for="userMail">Mot de passe :</label>
            <input type="password" name="userPassword" id="userPassword" class="form-control" required autocomplete="on"><br />
          </div>
        </div>

        <hr class="mb-4">

        <button class="btn btn-danger btn-lg btn-block" type="submit" value="S'inscire">S'inscire</button>
      </form>
    </div>

  </div>
</section>

@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    $('#signInDiv, #logInDiv').hide();

    $('#btnSignIn, #btnLogin').click(function() {
      var btnId = $(this).attr('id');
      var href = "signInDiv";

      if (btnId == "btnLogin") {
        href = "logInDiv"
      }

      $('html, body').animate({
        scrollTop: $("#bottomSection").offset().top
      }, 2000);

      if (btnId == "btnSignIn") {
        $('#logInDiv').hide();
        $('#signInDiv').show();
      } else {
        $('#signInDiv').hide();
        $('#logInDiv').show();
      }
      $('input').val('');
    });

    $("#formSignIn").submit(function(e) {
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: '/Student/Add',
        type: 'POST',
        data: form.serialize(),
        success: function(data) {
          form.find(":submit").prop('disabled', true);
          displayToastr('studentRegistred');
          window.location.href = data.nextLocation;
        },
        error: function(xhr, status, error) {
          form.find(":submit").prop('disabled', false);
          if (xhr.responseJSON.message == 'alreadyExist') {
            displayToastr('errorMsg',
              'Un étudiant ayant les mêmes informations <i class="fa fa-info-circle text-info"></i> existe déjà !');
          } else if (xhr.responseJSON.message == 'emailNotPossible') {
            displayToastr('errorMsg', 'L\'adresse mail que vous avez renseigné n\'est pas dispoblible !');
          } else {
            displayToastr('error');
          }
        },
      });

    });

    $("#formLogIn").submit(function(e) {
      var form = $(this);
      e.preventDefault();

      $.ajax({
        url: '/Login',
        type: 'POST',
        data: form.serialize(),
        success: function(data) {
          displayToastr('connected', data.name);
          window.location.href = data.nextLocation;
        },
        error: function(xhr, status, error) {
          form.find(":submit").prop('disabled', false);
          if (xhr.responseJSON.message == 'userNotFound') {
            displayToastr('errorMsg', 'Veuillez vérifier votre login et votre mot de passe !');
          } else {
            displayToastr('error');
          }
        },
      });
    });

  });
  $('#btnSignIn, #btnLogin').click(function() {

  });

  $("#userPhoneNumber").on('keyup', function() {
    let phoneNumber = $(this).val();

    if (phoneNumber.length < 13) {
      phoneNumber = phoneNumber.split('.').join(''); // Remove dash (-) if mistakenly entered.
      let finalVal = phoneNumber.match(/.{0,2}/g).join('.');
      $("#userPhoneNumber").val(finalVal);
    }
  });
  
  $("#userPhoneNumber").on('keypress', function() {
    return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))
  });
</script>
@endsection