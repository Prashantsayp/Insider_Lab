<!-- Document Url Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('document_url', 'Document Url:') !!}
    {!! Form::textarea('document_url', null, ['class' => 'form-control']) !!}
</div>

<!-- Document Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('document_type', 'Document Type:') !!}
    {!! Form::text('document_type', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50]) !!}
</div>

<!-- Agent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('agent_id', 'Agent Id:') !!}
    {!! Form::number('agent_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Case Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('case_id', 'Case Id:') !!}
    {!! Form::number('case_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
</div>
