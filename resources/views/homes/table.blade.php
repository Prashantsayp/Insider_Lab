<div class="table-responsive-sm" style="overflow-y: auto">
    <table class="table table-striped" id="homes-table">
        <thead>
            <tr>

                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($homes as $home)
            <tr>

                <td>
                    {!! Form::open(['route' => ['homes.destroy', $home->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('homes.show', [$home->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('homes.edit', [$home->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
