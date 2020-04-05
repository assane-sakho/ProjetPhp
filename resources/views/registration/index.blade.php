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

                    <!-- SmartWizard html -->
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1" data-content-url="/Registration/GetStepData">Étape 1<br /><small>Choix de la formation</small></a></li>
                            <li><a href="#step-2" data-content-url="/Registration/GetStepData">Étape 2<br /><small>Dépôt - CV</small></a></li>
                            <li><a href="#step-3" data-content-url="/Registration/GetStepData">Étape 3<br /><small>Dépôt - Lettre de motivation</small></a></li>
                            <li><a href="#step-4" data-content-url="/Registration/GetStepData">Étape 4<br /><small>Dépôt - Relevés de notes</small></a></li>
                            <li><a href="#step-5" data-content-url="/Registration/GetStepData">Étape 5<br /><small>Dépot - Imprime écran ENT</small></a></li>
                            <li><a href="#step-6" data-content-url="/Registration/GetStepData">Étape 6<br /><small>Validation</small></a></li>
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
                            <div id="step-6" class="">

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
        let registrationEditable = ('{{ session("student")->registration->status_id }}' == '1');
        if (!registrationEditable) {
            $(".form-control").prop('disabled', true);
            $(".btnRegistration").remove();
        }

        var btnFinish;

        if (registrationEditable) {
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
                                        $(".btnRegistration").remove();
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
        }

        $('#smartwizard').smartWizard({
            selected: 0,
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
                enableAllAnchors: !registrationEditable
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
                if (registrationEditable) {
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
            return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            if (stepNumber == 5 && registrationEditable) {
                $('.btn-finish').removeClass('disabled');

            } else {
                $('.btn-finish').addClass('disabled');
            }
        });
    });
</script>
@endsection