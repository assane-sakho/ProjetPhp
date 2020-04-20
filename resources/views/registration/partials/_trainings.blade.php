<br />
<h5>Sélectionnez une formation</h5>
<div id="form-step-0" role="form" data-toggle="validator">
    <div class="form-group col-md-6">
        @php
        $disabled = session('isRegistrationComplete') ? "disabled" : "";
        @endphp
        <select class="input-training form-control" name="training" id="training" required {{ $disabled }}>
            <option value="">-- Sélectionnez une option --</option>
            @php
            $selected;
            foreach ($data['trainings'] as $training)
            {
            if($training->id == $data['student_training_id'])
            {
            $selected = "selected";
            }
            else
            {
            $selected = "";
            }
            @endphp
            <option value="{{ $training->id }}" {{ $selected }}>{{ $training->name }}</option>
            @php
            }
            @endphp
        </select>
        <br />
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="classicTraining" name="classicTraining" {{ $data['classicChecked']  }}>
            <label class="form-check-label" for="classicTraining">Classique</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="apprenticeshipTraining" name="apprenticeshipTraining" {{ $data['apprenticeshipChecked']  }}>
            <label class="form-check-label" for="apprenticeshipTraining">Apprentissage</label>
        </div>
        <div class="help-block with-errors"></div>
    </div>
    <span class="text-danger" id="errorTraining">Veuillez choisir si vous candidater pour l’apprentissage, le classique ou les deux.</span>

</div>

<script>
    $(document).ready(function() {
        $("#errorTraining").hide();

        $(":checkbox").click(function() {
            if ($(":checkbox:checked").length == 0) {
                $(".form-check-label").addClass('text-danger');
                $("#errorTraining").show();

            } else {
                $("#errorTraining").hide();
                $(".form-check-label").removeClass('text-danger');
            }
        });
    });
</script>