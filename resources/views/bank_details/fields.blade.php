<!-- Bank Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('bank_details', 'Bank Details:') !!}
    {!! Form::textarea('bank_details', null, ['class' => 'form-control']) !!}
</div>

<!-- Terms And Conditions Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('terms_and_conditions', 'Terms And Conditions:') !!}
    {!! Form::textarea('terms_and_conditions', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('bankDetails.index') }}" class="btn btn-secondary">Cancel</a>
</div>
