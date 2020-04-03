<br />
<h5>Sélectionnez une formation</h5>
<div id="form-step-0" role="form" data-toggle="validator">
    <div class="form-group col-md-6">
        <select class="input-training form-control" name="training" id="training" required>
            <option value="">-- Sélectionnez une option</option>
            @php
                $selected;
                foreach ($trainings as $training)
                {
                    if($training->id == session('registration')->training_id)
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