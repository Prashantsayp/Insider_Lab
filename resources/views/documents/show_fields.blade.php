<!-- Document Url Field -->
<div class="form-group">
    {!! Form::label('document_url', 'Document Url:') !!}
    <p>{{ $documents->document_url }}</p>
</div>

<!-- Document Type Field -->
<div class="form-group">
    {!! Form::label('document_type', 'Document Type:') !!}
    <p>{{ $documents->document_type }}</p>
</div>

<!-- Agent Id Field -->
<div class="form-group">
    {!! Form::label('agent_id', 'Agent Id:') !!}
    <p>{{ $documents->agent_id }}</p>
</div>

<!-- Case Id Field -->
<div class="form-group">
    {!! Form::label('case_id', 'Case Id:') !!}
    <p>{{ $documents->case_id }}</p>
</div>

