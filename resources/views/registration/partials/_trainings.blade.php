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