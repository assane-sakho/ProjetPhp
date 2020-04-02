@extends('layout.mainlayout')

@section('content')

<section class="breadcrumb_part blog_grid_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 ">
                <div class="breadcrumb_iner">
                    <h2>Renseignement des informations</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="popular_course section_padding section_bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="#" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1">Étape 1<br /><small>Choix de la formation</small></a></li>
                            <li><a href="#step-2">Étape 2<br /><small>Dépôt - CV</small></a></li>
                            <li><a href="#step-3">Étape 3<br /><small>Dépôt - Lettre de motivation</small></a></li>
                            <li><a href="#step-4">Étape 4<br /><small>Dépôt - Relevés de notes</small></a></li>
                            <li><a href="#step-5">Étape 5<br /><small>Dépot - Imprime écran ENT</small></a></li>
                            <li><a href="#step-6">Étape 6<br /><small>Validation</small></a></li>
                        </ul>
                        <div>
                            <div id="step-1">
                                <br />
                                <h5>Sélectionnez une formation</h5>
                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="form-group col-md-6">
                                        <select class="input-training form-control" name="training" id="training" required>
                                            <option value="">-- Sélectionnez une option</option>
                                            @foreach ($trainings as $training)
                                            <option value="{{ $training->id }}">{{ $training->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>
                            <div id="step-2">
                                <br />
                                <h5>Déposez votre CV</h5>
                                <div id="form-step-1" role="form" data-toggle="validator">
                                    <div class="form-group col-md-10">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>CV</td>
                                                <td><input class="input-cv form-control" accept="application/pdf" name="cv" id="cv" type="file" data-validation='Veuillez renseiger un CV' required></td>
                                            </tr>
                                        </table>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3">
                                <br />
                                <h5>Déposez votre lettre de motivation</h5>
                                <div id="form-step-2" role="form" data-toggle="validator">
                                    <div class="form-group col-md-10">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Lettre de motivation</td>
                                                <td><input class="input-coverLetter form-control" accept="application/pdf" name="coverLetter" id="coverLetter" type="file" data-validation='Veuillez renseiger un CV' required></td>
                                            </tr>
                                        </table>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-4">
                                <br />
                                <h5>Déposez vos relevés de notes</h5>
                                <div id="form-step-3" role="form" data-toggle="validator">
                                    <div class="form-group col-md-10">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Relevés de notes de l’année précédente</td>
                                                <td><input class="input-reportCard form-control" accept="application/pdf" name="reportCard-1" id="reportCard-1" type="file" data-validation='Veuillez renseiger un CV' required></td>
                                            </tr>
                                        </table>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-5">
                                <br />
                                <h5>Déposez votre imprime écran de l’ENT de l’année en cours</h5>
                                <div id="form-step-4" role="form" data-toggle="validator">
                                    <div class="form-group col-md-10">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Imprime écran de l’ENT de l’année en cours</td>
                                                <td><input class="input-vleScreenshot form-control" accept="application/pdf, image/x-png,image/gif,image/jpeg" name="vleScreenshot" id="vleScreenshot" type="file" data-validation='Veuillez renseiger un CV' required></td>
                                            </tr>
                                        </table>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-6" class="">
                                <br />
                                <h5>Validation du dossier</h5>
                                <div id="form-step-5" role="form" data-toggle="validator">
                                    <div class="form-group col-md-10">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Nom</th>
                                                <td>{{ session('student')->lastname }} </td>
                                            </tr>
                                            <tr>
                                                <th>Prénom</th>
                                                <td>{{ session('student')->firstname }} </td>
                                            </tr>
                                            <tr>
                                                <th>N° de carte d'identité</th>
                                                <td>{{ session('student')->card_id }} </td>
                                            </tr>
                                            <tr>
                                                <th>Date de naissance</th>
                                                <td>{{ session('student')->birthdate->format('d/m/Y') }} </td>
                                            </tr>
                                            <tr>
                                                <th>Adresse mail</th>
                                                <td>{{ session('student')->email }} </td>
                                            <tr>
                                                <th>Téléphone</th>
                                                <td>{{ session('student')->phone_number }} </td>
                                            </tr>
                                            <tr>
                                                <th>Adresse</th>
                                                <td>{{ session('student')->address->street }}, {{ session('student')->address->zip_code }} {{ session('student')->address->city }} </td>
                                            </tr>
                                            <tr rowspan="2">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th>Filière choisis</th>
                                                <td id="td-training"> </td>
                                            </tr>
                                            <tr rowspan="2">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th>CV</th>
                                                <td id="td-cv"> </td>
                                            </tr>
                                            <tr>
                                                <th>Lettre de motivation</th>
                                                <td id="td-coverLetter"></td>
                                            </tr>
                                            <tr>
                                                <th>Relevés de notes de l’année précédente</th>
                                                <td id="td-reportCard"></td>
                                            </tr>
                                            <tr>
                                                <th>Imprime écran de l’ENT de l’année en cours</th>
                                                <td id="td-vleScreenshot"></td>
                                            </tr>
                                        </table>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        // Toolbar extra buttons

        var btnFinish = $('<button></button>')
            .text('Valider')
            .addClass('btn btn-info')
            .addClass('btn-finish')
            .addClass('disabled')
            .on('click', function() {
                if (!$(this).hasClass('disabled')) {
                    var elmForm = $("#myForm");
                    if (elmForm) {
                        elmForm.validator('validate');
                        var elmErr = elmForm.find('.has-error');
                        if (elmErr && elmErr.length > 0) {
                            alert('Oops we still have error in the form');
                            return false;
                        } else {
                            alert('Great! we are ready to submit form');
                            elmForm.submit();
                            return false;
                        }
                    }
                }
            });

        // Smart Wizard
        $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'default',
            transitionEffect: 'fade',
            toolbarSettings: {
                toolbarPosition: 'bottom',
                toolbarExtraButtons: [btnFinish]
            },
            anchorSettings: {
                markDoneStep: true, // add done css
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            },
            lang: {
                previous: 'Précédent',
                next: 'Suivant' 
            },
        });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
            var elmForm = $("#form-step-" + stepNumber);
            // stepDirection === 'forward' :- this condition allows to do the form validation
            // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
            if (stepDirection === 'forward' && elmForm) {
                elmForm.validator('validate');
                var elmErr = elmForm.children('.has-error');
                if (elmErr && elmErr.length > 0) {
                    $(elmErr).find("input").each(function() {
                        if (!this.value) {
                            $(this).addClass("bg-danger");
                        }
                    });
                    return false;
                }
            }
            $(elmErr).find("input").each(function() {
                if (!this.value) {
                    $(this).removeClass("bg-danger");
                }
            });
            return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            if (stepNumber == 5) {
                $('.btn-finish').removeClass('disabled');

                    var dict = [
                        "training",
                        "cv",
                        "coverLetter",
                        "reportCard",
                        "vleScreenshot",
                    ];

                    $(dict).each(function(i, item) {
                        var text = "";
                        if (item == "training") {
                            text = $(".input-" + item +  " option:selected").text();
                        }
                        else
                        {
                            $(".input-" + item).each(function(i, input) {
                                text += $(input).val().split('\\').pop() + " ";
                            });
                        }
                      
                        $("#td-" + item).text(text);
                    })

            } else {
                $('.btn-finish').addClass('disabled');
            }
        });

    });
</script>
@endsection