<!-- Policy Id Field -->
<div class="form-group">
    {!! Form::label('policy_id', 'Policy Id:') !!}
    <p>{{ $professionalPolicyDetails->policy_id }}</p>
</div>

<!-- Linked Condition Key Field -->
<div class="form-group">
    {!! Form::label('linked_condition_key', 'Linked Condition Key:') !!}
    <p>{{ $professionalPolicyDetails->linked_condition_key }}</p>
</div>

<!-- Condition Field -->
<div class="form-group">
    {!! Form::label('condition', 'Condition:') !!}
    <p>{{ $professionalPolicyDetails->condition }}</p>
</div>

<!-- Condition Value Field -->
<div class="form-group">
    {!! Form::label('condition_value', 'Condition Value:') !!}
    <p>{{ $professionalPolicyDetails->condition_value }}</p>
</div>

<!-- Condition Type Field -->
<div class="form-group">
    {!! Form::label('condition_type', 'Condition Type:') !!}
    <p>{{ $professionalPolicyDetails->condition_type }}</p>
</div>

<!-- Parent Condition Id Field -->
<div class="form-group">
    {!! Form::label('parent_condition_id', 'Parent Condition Id:') !!}
    <p>{{ $professionalPolicyDetails->parent_condition_id }}</p>
</div>

<!-- Parent Condition Value Field -->
<div class="form-group">
    {!! Form::label('parent_condition_value', 'Parent Condition Value:') !!}
    <p>{{ $professionalPolicyDetails->parent_condition_value }}</p>
</div>

<!-- Calculation Field Field -->
<div class="form-group">
    {!! Form::label('calculation_field', 'Calculation Field:') !!}
    <p>{{ $professionalPolicyDetails->calculation_field }}</p>
</div>

<!-- Final Value Field -->
<div class="form-group">
    {!! Form::label('final_value', 'Final Value:') !!}
    <p>{{ $professionalPolicyDetails->final_value }}</p>
</div>

