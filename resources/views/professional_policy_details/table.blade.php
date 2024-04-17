<div class="table-responsive-sm">
    <table class="table table-striped" id="professionalPolicyDetails-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Policy Id</th>
                <th>Linked Condition Key</th>
                <th>Condition</th>
                <th>Condition Value</th>
                <th>Condition Type</th>
                <th>Parent Condition Id</th>
                <th>Parent Condition Value</th>
                <th>Calculation Field</th>
                <th>Final Value</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($professionalPolicyDetails as $professionalPolicyDetails)
            <tr>
                <td>{{ $professionalPolicyDetails->id }}</td>
                <td>{{ $professionalPolicyDetails->policy_id }}</td>
                <td>{{ $professionalPolicyDetails->linked_condition_key }}</td>
                <td>{{ $professionalPolicyDetails->condition }}</td>
                <td>{{ $professionalPolicyDetails->condition_value }}</td>
                <td>{{ $professionalPolicyDetails->condition_type }}</td>
                <td>{{ $professionalPolicyDetails->parent_condition_id }}</td>
                <td>{{ $professionalPolicyDetails->parent_condition_value }}</td>
                <td>{{ $professionalPolicyDetails->calculation_field }}</td>
                <td>{{ $professionalPolicyDetails->final_value }}</td>
                <td>
                    {!! Form::open(['route' => ['professionalPolicyDetails.destroy', $professionalPolicyDetails->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('professionalPolicyDetails.show', [$professionalPolicyDetails->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('professionalPolicyDetails.edit', [$professionalPolicyDetails->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
