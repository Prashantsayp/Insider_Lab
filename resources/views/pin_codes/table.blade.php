<div class="table-responsive-sm">
    <table class="table table-striped" id="pinCodes-table">
        <thead>
            <tr>
                <th>Pin Code</th>
        <th>Ff Available</th>
        <th>Bank Available</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pinCodes as $pinCodes)
            <tr>
                <td>{{ $pinCodes->pin_code }}</td>
            <td>{{ $pinCodes->ff_available }}</td>
            <td>{{ $pinCodes->bank_available }}</td>
                <td>
                    {!! Form::open(['route' => ['pinCodes.destroy', $pinCodes->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('pinCodes.show', [$pinCodes->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('pinCodes.edit', [$pinCodes->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>