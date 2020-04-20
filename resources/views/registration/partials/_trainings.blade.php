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
        <div class="help-block with-errors"></div>
    </div>
</div>