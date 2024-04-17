<div class="table-responsive-sm" style="overflow-y: auto">
    <table class="table table-striped" id="users-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Email</th>
        <th>Pan Card</th>
        <th>Aadhar Card</th>
        <th>Mobile Verified At</th>
        <th>Mobile</th>
        <th>Location</th>
        <th>Email Verified At</th>
        <th>Disabled</th>
        <th>User Type</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->pan_card }}</td>
            <td>{{ $user->aadhar_card }}</td>
            <td>{{ $user->mobile_verified_at }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->location }}</td>
            <td>{{ $user->email_verified_at }}</td>
            <td>{{ $user->disabled }}</td>
            <td>{{ $user->user_type }}</td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
