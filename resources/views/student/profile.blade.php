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
                <input type="hidden" name="userId" id="userId" value="{{ session('student')->id }}" class="form-control"><p/>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userLastname">Nom :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userLastname" id="userLastname" value="{{ session('student')->lastname }}" class="form-control" required><p/>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="userFirstname">Prénom :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userFirstname" id="userFirstname" value="{{ session('student')->firstname }}" class="form-control" required><p/>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userCardId">N° de carte d'identité :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="text" name="userCardId" id="userCardId" value="{{ session('student')->card_id }}" class="form-control" required>
                        
                        <br/>

                        <label for="userBirthdate">Date de naissance</label>
                        <input type="date" name="userBirthdate" id="userBirthdate" value="{{ session('student')->birthdate }}" class="form-control" required><p/>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userStreet">Rue :</label>
                        <input type="text" name="userStreet" id="userStreet" value="{{ session('student')->address->street }}" class="form-control" required><p/>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="userCity">Ville :</label>
                        <input type="text" name="userCity" id="userCity" value="{{ session('student')->address->city }}" class="form-control" required><p/>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="userZipCode">Code postal :</label>
                        <input type="number" name="userZipCode" id="userZipCode" value="{{ session('student')->address->zip_code }}" class="form-control" required><p/>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userPhoneNumber">Téléphone :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="number" name="userPhoneNumber" id="userPhoneNumber" value="{{ session('student')->phone_number }}" class="form-control"required><p/>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userMail">Adresse mail :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="mail" name="userMail" id="userMail" value="{{ session('student')->email }}" class="form-control" required><p/>
                    </div>
                </div>
                
                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="userMail">Nouveau Mot de passe :</label>
                        <input type="password" name="userPassword" id="userPassword" class="form-control"><p/>
                    </div>
                </div>

                <hr class="mb-4">

                <button class="btn btn-danger btn-lg btn-block" type="submit" value="Modifier">Modifier</button>
            </form>
            <br/>
            <p class="text-center">
                <a href="/Registration" class="go_back"> <i class="arrow_back"></i>Retour au dépot de candidature</a>
            </p>
        </div>  
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $("#formEdit").submit(function(e){
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url:'/Student/Update',
                type:'POST',
                data: form.serialize(),
                success: function(data) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('studentRegistred');
                },
                error: function(xhr, status, error)  {
                    form.find(":submit").prop('disabled', false);
                    if(xhr.responseJSON.message  == 'alreadyExist')
                    {
                        displayToastr('errorMsg', 'Un étudiant ayant les mêmes informations <i class="fa fa-info-circle text-info"></i> existe déjà !');
                    }
                    else if(xhr.responseJSON.message  == 'emailNotPossible')
                    {
                        displayToastr('errorMsg', 'L\'adresse mail que vous avez renseigné n\'est pas dispoblible !');
                    }
                    else
                    {
                        displayToastr('error');
                    }
                },
            });
        });
    });
</script>
@endsection
