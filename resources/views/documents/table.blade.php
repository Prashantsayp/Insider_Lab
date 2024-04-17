<div class="table-responsive-sm">
    <table class="table table-striped" id="documents-table">
        <thead>
            <tr>
                <th>Document Url</th>
        <th>Document Type</th>
        <th>Agent Id</th>
        <th>Case Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($documents as $documents)
            <tr>
                <td>{{ $documents->document_url }}</td>
            <td>{{ $documents->document_type }}</td>
            <td>{{ $documents->agent_id }}</td>
            <td>{{ $documents->case_id }}</td>
                <td>
                    {!! Form::open(['route' => ['documents.destroy', $documents->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('documents.show', [$documents->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('documents.edit', [$documents->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>