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
                <br/>
                @php
                if($isAdmin)
                    $disabled = "disabled";
                else
                    $disabled = "required";
                @endphp
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="teacherEmail">Adresse mail :</label> <i class="fa fa-info-circle text-info"></i>
                        <input type="mail" name="teacherEmail" id="teacherEmail" value="{{ $teacher->email }}" class="form-control" {{ $disabled}}>
                        <br/>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="teacherPassword">Nouveau Mot de passe :</label>
                        <input type="password" name="teacherPassword" minlength="8" id="teacherPassword" class="form-control">
                        <br/>
                    </div>
                </div>

                <hr class="mb-4">

                <button class="btn btn-danger btn-lg btn-block btnRegistration" type="submit" value="Modifier">Modifier</button>
            </form>
            <br />
            <p class="text-center">
                <a href="/RegistrationsStudy" class="go_back"> <i class="arrow_back"></i>Retour à l'étude des candidature</a>
            </p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#formEdit").submit(function(e) {
            var form = $(this);
            e.preventDefault();

            $.ajax({
                url: '/Teacher/Update',
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                    form.find(":submit").prop('disabled', false);
                    displayToastr('updated');
                },
                error: function(xhr, status, error) {
                    form.find(":submit").prop('disabled', false);
                    if (xhr.responseJSON.message == 'emailAlreadyExist') {
                        displayToastr('errorMsg', 'Un professeur ayant la même adresse mail <i class="fa fa-info-circle text-info"></i> existe déjà !');
                    } else {
                        displayToastr('error');
                    }
                },
            });
        });
    });
</script>
@endsection