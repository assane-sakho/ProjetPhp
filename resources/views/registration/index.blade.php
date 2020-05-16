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
                <form action="/Registration/Save" id="registrationForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <input type="hidden" name="step_number" id="step_number" value="{{ $stepNumber }}">
                    <!-- SmartWizard html -->
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1" data-content-url="/Registration/GetStepData">Étape 1<br /><small>Choix de la formation</small></a></li>
                            <li><a href="#step-2" data-content-url="/Registration/GetStepData">Étape 2<br /><small>Dépôt - CV</small></a></li>
                            <li><a href="#step-3" data-content-url="/Registration/GetStepData">Étape 3<br /><small>Dépôt - Lettre de motivation</small></a></li>
                            <li><a href="#step-4" data-content-url="/Registration/GetStepData">Étape 4<br /><small>Dépôt - Relevés de notes</small></a></li>
                            <li><a href="#step-5" data-content-url="/Registration/GetStepData">Étape 5<br /><small>Dépot - Imprime écran ENT</small></a></li>
                            <li><a href="#step-6" data-content-url="/Registration/GetStepData">Étape 6<br /><small>Dépot - Formulaire d'inscription</small></a></li>
                            <li><a href="#step-7" data-content-url="/Registration/GetStepData">Étape 7<br /><small> {{ !$isRegistrationComplete ? "Validation" : "Récapitulatif" }}</small></a></li>
                        </ul>
                        <div>
                            <div id="step-1">

                            </div>
                            <div id="step-2">

                            </div>
                            <div id="step-3">

                            </div>
                            <div id="step-4">

                            </div>
                            <div id="step-5">

                            </div>
                            <div id="step-6">

                            </div>
                            <div id="step-7">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<style>
    .sw-container {
        min-height: 0px !important;
    }
</style>
<input type="hidden" id="registration_statusId" value="{{ $registrationStatusId }}">
<input type="hidden" id="isRegistrationComplete" value="{{ $isRegistrationComplete ? 'true' : 'false' }}">
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        var registration_statusId = $("#registration_statusId").val();
        let isRegistrationComplete = $("#isRegistrationComplete").val() == 'true';
        var smartWizardStep = $("#step_number");

        if (registration_statusId == 3) {
            displayToastr('warning', 'Votre candidature a été signalée comme incomplète.<br/><br/>Veuillez la compléter avant de l\'envoyer de nouveau.');
        }

        var btnFinish;

        if (!isRegistrationComplete) {
            btnFinish = $('<button></button>')
                .text('Valider')
                .addClass('btn btn-info btn-finish btnRegistration')
                .addClass('disabled')
                .prop("type", "button")
                .on('click', function() {
                    if (!$(this).hasClass('disabled')) {
                        var elmForm = $("#myForm");
                        if (elmForm) {
                            elmForm.validator('validate');
                            var elmErr = elmForm.find('.has-error');
                            if (elmErr && elmErr.length > 0) {
                                return false;
                            } else {
                                $.ajax({
                                    url: '/Registration/Complete',
                                    type: 'POST',
                                    success: function(data) {
                                        displayToastr('registrationSaved');
                                        window.location.reload();
                                    },
                                    error: function(xhr, status, error) {
                                        displayToastr('error');
                                    },
                                });
                                return false;
                            }
                        }
                    }
                });
        } else {
            $(".form-control, input").prop('disabled', true);
            $(".btnRegistration").remove();
        }

        $('#smartwizard').smartWizard({
            selected: parseInt(smartWizardStep.val()),
            theme: 'default',
            transitionEffect: 'fade',
            contentCache: false,
            showStepURLhash: false,
            toolbarSettings: {
                toolbarPosition: 'bottom',
                toolbarExtraButtons: [btnFinish]
            },
            anchorSettings: {
                markDoneStep: true, // add done css
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                enableAnchorOnDoneStep: true, // Enable/Disable the done steps navigation
                enableAllAnchors: isRegistrationComplete
            },
            lang: {
                previous: 'Précédent',
                next: 'Suivant'
            },
        });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

            var elmForm = $("#form-step-" + stepNumber);

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
                } else if (stepNumber == 0) {
                    if ($("#training").val() == '') {
                        $("#training").addClass('has-error').addClass('border-danger');
                        $(".help-block").show();
                        return false;
                    }

                    if ($(":checkbox:checked").length == 0) {
                        $(".form-check-label").addClass('text-danger');
                        $("#errorTraining").show();
                        return false;
                    }
                } else if (stepNumber == 3) {
                    if (elmForm.find('#report_card_0').length && $("#report_card_0").val() == '') {
                        $("#report_card_0").addClass("bg-danger").addClass('has-error');
                        $(".help-block").show();
                        return false;
                    }
                    $('.input-report_card').each(function() {
                        if ($(this).get(0).files.length == 0) {
                            $(this).remove();
                        }
                    });
                    let k = elmForm.find('embed').length;
                    $('.input-report_card').each(function() {
                        $(this).attr('name', 'report_card_' + k);
                        k++;
                    });
                }

                if (!isRegistrationComplete) {
                    $.ajax({
                        url: '/Registration/SaveStepData',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: new FormData($("#registrationForm")[0]),
                        success: function(data) {
                            return true;
                        },
                        error: function(xhr, status, error) {
                            displayToastr('error');
                        },
                    });
                }
            }
            $(".sw-container").css({
                "min-height": "0px"
            });
            return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            $(".sw-container").css({
                "min-height": "0px"
            });
            if (stepNumber == 6 && !isRegistrationComplete) {
                $('.btn-finish').removeClass('disabled');

            } else {
                $('.btn-finish').addClass('disabled');
            }
            smartWizardStep.val(stepNumber);
        });
    });
</script>
@endsection