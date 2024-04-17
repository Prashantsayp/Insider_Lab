
<div class="table-responsive-sm" style="overflow-y: auto">
     {{-- $cases->appends(Illuminate\Support\Facades\Input::except('page'))->links() --}}  
    <table class="table table-striped" id="cases-table">
        <thead>
        <tr>
            <th>CaseID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Mobile</th>
            <th>Pin Code</th>
            <th>Date Of Birth</th>
            <th>Company</th>
            <th>Field Of Work</th>
            <th>Designation</th>
            <th>Monthly Salary</th>
            <th>Monthly Emi</th>
            <th>Load Type</th>
            <th>Load Amount</th>
            <th>Mode Of Salary</th>
            <th>Salary Bank</th>
            <th>Load Purpose</th>
            <th>Assigned To</th>
            <th>Created By</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cases as $case)
{{--            @php--}}
{{--                $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';--}}
{{--                $files = \Illuminate\Support\Facades\Storage::disk('s3')->files("cases/$case->id/");--}}
{{--                $files = array_reverse($files);--}}
{{--            @endphp--}}
            <tr>
                <td>{{ $case->id }}</td>
                <td>{{ $case->first_name }}</td>
                <td>{{ $case->last_name }}</td>
                <td>{{ $case->mobile }}</td>
                <td>{{ $case->pin_code }}</td>
{{--                <td>--}}
{{--                    @if(count($files)>0)--}}
{{--                        <img src="{{$url.$files[0] }}" height="50px;"/><br>--}}
{{--                        <a target="_blank" href="{{$url.$files[0] }}">View</a>--}}
{{--                    @endif--}}
{{--                </td>--}}
                {{--                <td>{{ $case->pan_card }}</td>--}}
                <td>{{ $case->date_of_birth }}</td>
                <td>{{ $case->company }}</td>
                <td>{{ $case->field_of_work }}</td>
                <td>{{ $case->designation }}</td>
                <td>{{ $case->monthly_salary }}</td>
                <td>{{ $case->monthly_emi }}</td>
                <td>{{ $case->load_type }}</td>
                <td>{{ $case->load_amount }}</td>
                <td>{{ $case->mode_of_salary }}</td>
                <td>{{ $case->salary_bank }}</td>
                <td>{{ $case->load_purpose }}</td>
                <td>{{ $case->assigned_to }}</td>
                <td>{{ $case->created_by }}</td>
                <td>{{ $case->case_status }}</td>
                <td>
                    {!! Form::open(['route' => ['cases.destroy', $case->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cases.show', [$case->id]) }}" class='btn btn-ghost-success'><i
                                    class="fa fa-eye"></i></a>
                        <a href="{{ route('cases.edit', [$case->id]) }}" class='btn btn-ghost-info'><i
                                    class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $cases->links() !!}
</div>
