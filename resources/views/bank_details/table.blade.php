<div class="table-responsive-sm" style="overflow-y: auto">
    <table class="table table-striped" id="bankDetails-table">
        <thead>
            <tr>
                <th>Bank Details</th>
        <th>Terms And Conditions</th>
        <th>User Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bankDetails as $bankDetails)
            <tr>
                <td>{{ $bankDetails->bank_details }}</td>
            <td>{{ $bankDetails->terms_and_conditions }}</td>
            <td>{{ $bankDetails->user_id }}</td>
                <td>
                    {!! Form::open(['route' => ['bankDetails.destroy', $bankDetails->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bankDetails.show', [$bankDetails->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('bankDetails.edit', [$bankDetails->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
