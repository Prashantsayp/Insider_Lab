<!-- Policy Id Field -->
<div class="form-group">
    {!! Form::label('policy_id', 'Policy Id:') !!}
    <p>{{ $policyDetails->policy_id }}</p>
</div>

<!-- Linked Condition Key Field -->
<div class="form-group">
    {!! Form::label('linked_condition_key', 'Linked Condition Key:') !!}
    <p>{{ $policyDetails->linked_condition_key }}</p>
</div>

<!-- Condition Field -->
<div class="form-group">
    {!! Form::label('condition', 'Condition:') !!}
    <p>{{ $policyDetails->condition }}</p>
</div>

<!-- Condition Value Field -->
<div class="form-group">
    {!! Form::label('condition_value', 'Condition Value:') !!}
    <p>{{ $policyDetails->condition_value }}</p>
</div>

<!-- Condition Type Field -->
<div class="form-group">
    {!! Form::label('condition_type', 'Condition Type:') !!}
    <p>{{ $policyDetails->condition_type }}</p>
</div>

<!-- Parent Condition Id Field -->
<div class="form-group">
    {!! Form::label('parent_condition_id', 'Parent Condition Id:') !!}
    <p>{{ $policyDetails->parent_condition_id }}</p>
</div>

<!-- Parent Condition Value Field -->
<div class="form-group">
    {!! Form::label('parent_condition_value', 'Parent Condition Value:') !!}
    <p>{{ $policyDetails->parent_condition_value }}</p>
</div>

