@extends('layout.mainlayout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="#" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                <!-- SmartWizard html -->
                <div id="smartwizard">
                    <ul>
                        <li><a href="#step-1">Step 1<br /><small>Email Address</small></a></li>
                        <li><a href="#step-2">Step 2<br /><small>Name</small></a></li>
                        <li><a href="#step-3">Step 3<br /><small>Address</small></a></li>
                        <li><a href="#step-4">Step 4<br /><small>Terms and Conditions</small></a></li>
                    </ul>

                    <div>
                        <div id="step-1">
                            <h2>Your Email Address</h2>
                            <div id="form-step-0" role="form" data-toggle="validator">
                                <div class="form-group">
                                    <label for="email">Email address:</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Write your email address" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>
                        <div id="step-2">
                            <h2>Your Name</h2>
                            <div id="form-step-1" role="form" data-toggle="validator">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" id="email" placeholder="Write your name" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div id="step-3">
                            <h2>Your Address</h2>
                            <div id="form-step-2" role="form" data-toggle="validator">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Write your address..." required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div id="step-4" class="">
                            <h2>Terms and Conditions</h2>
                            <p>
                                Terms and conditions: Keep your smile :)
                            </p>
                            <div id="form-step-3" role="form" data-toggle="validator">
                                <div class="form-group">
                                    <label for="terms">I agree with the T&C</label>
                                    <input type="checkbox" id="terms" data-error="Please accept the Terms and Conditions" required>
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

@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('Finish')
                                        .addClass('btn btn-info')
                                        .on('click', function(){
                                                if( !$(this).hasClass('disabled')){
                                                    var elmForm = $("#myForm");
                                                    if(elmForm){
                                                        elmForm.validator('validate');
                                                        var elmErr = elmForm.find('.has-error');
                                                        if(elmErr && elmErr.length > 0){
                                                            alert('Oops we still have error in the form');
                                                            return false;
                                                        }else{
                                                            alert('Great! we are ready to submit form');
                                                            elmForm.submit();
                                                            return false;
                                                        }
                                                    }
                                                }
                                            });
        var btnCancel = $('<button></button>').text('Cancel')
                                        .addClass('btn btn-danger')
                                        .on('click', function(){
                                                $('#smartwizard').smartWizard("reset");
                                                $('#myForm').find("input, textarea").val("");
                                            });



        // Smart Wizard
        $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'dots',
                transitionEffect:'fade',
                toolbarSettings: {toolbarPosition: 'bottom',
                                toolbarExtraButtons: [btnFinish, btnCancel]
                                },
                anchorSettings: {
                            markDoneStep: true, // add done css
                            markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                            removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                        }
            });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
            var elmForm = $("#form-step-" + stepNumber);
            // stepDirection === 'forward' :- this condition allows to do the form validation
            // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
            if(stepDirection === 'forward' && elmForm){
                elmForm.validator('validate');
                var elmErr = elmForm.children('.has-error');
                if(elmErr && elmErr.length > 0){
                    // Form validation failed
                    return false;
                }
            }
            return true;
        });

        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            // Enable finish button only on last step
            if(stepNumber == 3){
                $('.btn-finish').removeClass('disabled');
            }else{
                $('.btn-finish').addClass('disabled');
            }
        });

    });

</script>
@endsection
