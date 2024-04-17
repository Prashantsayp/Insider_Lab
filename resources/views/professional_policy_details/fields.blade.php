<!-- Policy Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('policy_id', 'Policy Id:') !!}
    {!! Form::number('policy_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Linked Condition Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('linked_condition_key', 'Linked Condition Key:') !!}
    {!! Form::text('linked_condition_key', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Condition Field -->
<div class="form-group col-sm-6">
    {!! Form::label('condition', 'Condition:') !!}
    {!! Form::text('condition', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Condition Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('condition_value', 'Condition Value:') !!}
    {!! Form::text('condition_value', null, ['class' => 'form-control','maxlength' => 250,'maxlength' => 250]) !!}
</div>

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('condition_type', 'Condition Type:') !!}
    {!! Form::text('condition_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Condition Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_condition_id', 'Parent Condition Id:') !!}
    {!! Form::number('parent_condition_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Condition Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_condition_value', 'Parent Condition Value:') !!}
    {!! Form::text('parent_condition_value', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Calculation Field Field -->
<div class="form-group col-sm-6">
    {!! Form::label('calculation_field', 'Calculation Field:') !!}
    {!! Form::text('calculation_field', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Final Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('final_value', 'Final Value:') !!}
    {!! Form::text('final_value', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('professionalPolicyDetails.index') }}" class="btn btn-secondary">Cancel</a>
</div>
