<!-- Pin Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pin_code', 'Pin Code:') !!}
    {!! Form::text('pin_code', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50,'maxlength' => 50]) !!}
</div>

<!-- Ff Available Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ff_available', 'Ff Available:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('ff_available', 0) !!}
        {!! Form::checkbox('ff_available', '1', null) !!}
    </label>
</div>


<!-- Bank Available Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_available', 'Bank Available:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('bank_available', 0) !!}
        {!! Form::checkbox('bank_available', '1', null) !!}
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('pinCodes.index') }}" class="btn btn-secondary">Cancel</a>
</div>
