<div class="table-responsive-sm" style="overflow-y: auto">
    <table class="table table-striped" id="agents-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Email Verified</th>
                <th>Mobile</th>
                <th>Mobile Verified</th>
                <th>Location</th>
                <th>Is Active</th>
                <th>User Type</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($agents as $agents)
            <tr>
                <td>{{ $agents->name }}</td>
                <td>{{ $agents->email }}</td>
                <td>{{ $agents->email_verified_at }}</td>
                <td>{{ $agents->mobile }}</td>
                <td>{{ $agents->mobile_verified_at }}</td>
                <td>{{ $agents->location }}</td>
                <td>{{ ($agents->disabled) ? "Yes" : "No" }}</td>
                <td>{{ $agents->user_type }}</td>
                <td>
                    {!! Form::open(['route' => ['agents.destroy', $agents->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('agents.show', [$agents->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('agents.edit', [$agents->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
