<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $products->name }}</p>
</div>

<!-- Bank Id Field -->
<div class="form-group">
    {!! Form::label('bank_id', 'Bank Id:') !!}
    <p>{{ $products->bank_id }}</p>
</div>

<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $products->type }}</p>
</div>

<!-- Features Field -->
<div class="form-group">
    {!! Form::label('features', 'Features:') !!}
    <p>{{ $products->features }}</p>
</div>

<!-- Ui Listing Field -->
<div class="form-group">
    {!! Form::label('ui_listing', 'Ui Listing:') !!}
    <p>{{ $products->ui_listing }}</p>
</div>

