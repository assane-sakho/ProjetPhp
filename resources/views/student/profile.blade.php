@extends('layout.mainlayout')

@section('content')

<section class="breadcrumb_part blog_grid_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <div class="breadcrumb_iner">
                    <h2>Profil</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="popular_course section_padding section_bg">
    <div class="d-flex justify-content-center">
        <div class="col-md-8 " id="editDiv">
            <h4 class="mb-3">Vos informations</h4>
            <hr class="mb-4">
            <form action="" id="formEdit" method="POST">
                <input type="hidden" name="userId" id="userId" value="{{ $student->id }}" class="form-control"><br />

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userLastname">Nom :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userLastname" id="userLastname" value="{{ $student->lastname }}" class="form-control" required><br />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="userFirstname">Prénom :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userFirstname" id="userFirstname" value="{{ $student->firstname }}" class="form-control" required><br />
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userCardId">N° de carte d'identité :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userCardId" id="userCardId" value="{{ $student->card_id }}" maxlength="37" class="form-control" required>

                        <br />

                        <label for="userBirthdate">Date de naissance</label>
                        <input type="date" name="userBirthdate" id="userBirthdate" value="{{ $student->birthdate->format('Y-m-d') }}" class="form-control" required><br />
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userStreet">Rue :</label>
                        <input type="text" name="userStreet" id="userStreet" value="{{ $student->address->street }}" maxlength="50" class="form-control" required><br />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="userCity">Ville :</label>
                        <input type="text" name="userCity" id="userCity" value="{{ $student->address->city }}" maxlength="30" class="form-control" required><br />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="userZipCode">Code postal :</label>
                        <input type="number" name="userZipCode" id="userZipCode" value="{{ $student->address->zip_code }}" maxlength="5" onKeyPress="if(this.value.length==5) return false;" class="form-control" required><br />
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userPhoneNumber">Téléphone :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userPhoneNumber" id="userPhoneNumber" value="{{ $student->phone_number }}" maxlength="14" class="form-control" required><br />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userMail">Adresse mail :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="mail" name="userMail" id="userMail" value="{{ $student->email }}" class="form-control" required><br />
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userMail">Nouveau Mot de passe :</label>
                        <input type="password" name="userPassword" id="userPassword" class="form-control" autocomplete="on"><br />
                    </div>
                </div>

                <hr class="mb-4">

                <button class="btn btn-danger btn-lg btn-block btnRegistration" type="submit" value="Modifier">Modifier</button>
            </form>
            <br />
            <p class="text-center">
                <a href="/Registration" class="go_back"> <i class="arrow_back"></i>Retour au dépot de candidature</a>
            </p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let isRegistrationComplete = ('{{ $isRegistrationComplete }}');
        if (isRegistrationComplete) {
            $(".form-control").prop('disabled', true);
            $(".btnRegistration").remove();
        }

        $("#formEdit").submit(function(e) {
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url: '/Student/Update',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('studentRegistred');
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    if (xhr.responseJSON.message == 'alreadyExist') {
                        displayToastr('errorMsg', 'Un étudiant ayant les mêmes informations <i class="fa fa-info-circle text-info"></i> existe déjà !');
                    } else if (xhr.responseJSON.message == 'emailNotPossible') {
                        displayToastr('errorMsg', 'L\'adresse mail que vous avez renseigné n\'est pas dispoblible !');
                    } else {
                        displayToastr('error');
                    }
                },
            });
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
            return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))
        });
    });
</script>
@endsection