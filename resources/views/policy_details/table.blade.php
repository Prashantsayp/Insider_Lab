<div class="table-responsive-sm" style="overflow-y: auto">
    <table class="table table-striped" id="policyDetails-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Policy Id</th>
                <th>Calculation Field Type</th>
                <th>Calculation Field Value</th>
                <th>Linked Condition Key</th>
                <th>Condition</th>
                <th>Condition Value</th>
                <th>Condition Type</th>
                <th>Parent Condition Id</th>
                <th>Parent Condition Value</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($policyDetails as $policyDetails)
            <tr>
                <td>{{ $policyDetails->id }}</td>
                <td>{{ $policyDetails->policy_id }}</td>
                <td>{{ $policyDetails->calculation_field }}</td>
                <td>{{ $policyDetails->final_value }}</td>
                <td>{{ $policyDetails->linked_condition_key }}</td>
                <td>{{ $policyDetails->condition }}</td>
                <td>{{ $policyDetails->condition_value }}</td>
                <td>{{ $policyDetails->condition_type }}</td>
                <td>{{ $policyDetails->parent_condition_id }}</td>
                <td>{{ $policyDetails->parent_condition_value }}</td>
                <td>
                    {!! Form::open(['route' => ['policyDetails.destroy', $policyDetails->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('policyDetails.show', [$policyDetails->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('policyDetails.edit', [$policyDetails->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
