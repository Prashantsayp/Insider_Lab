<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

{{--<!-- Pan Card Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('pan_card', 'Pan Card:') !!}--}}
{{--</div>--}}

{{--<!-- Aadhar Card Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('aadhar_card', 'Aadhar Card:') !!}--}}
{{--</div>--}}
{{--{!! Form::hidden('aadhar_card', 0, ['class' => 'form-control']) !!}--}}
{{--{!! Form::hidden('pan_card', 0, ['class' => 'form-control']) !!}--}}
@if(!isset($agents))
    {!! Form::hidden('password', bcrypt('12345678'), ['class' => 'form-control']) !!}
@else
    {!! Form::hidden('password', $agents->password, ['class' => 'form-control']) !!}
@endif
{!! Form::hidden('user_type', 'agent', ['class' => 'form-control']) !!}

<!-- Mobile Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mobile_verified_at', 'Mobile Verified At:') !!}
    {!! Form::text('mobile_verified_at', null, ['class' => 'form-control','id'=>'mobile_verified_at']) !!}
</div>
@for($i = 0; $i < 5; $i++)
    @php
        $i_n = $i+1;
    @endphp
    <div class="form-group col-sm-12 col-lg-12">
        {!! Form::label("doc_$i_n", "Document $i_n:") !!}
        {!! Form::file("doc_$i_n", null, ['class' => 'form-control']) !!}@if(isset($url) && isset($files[$i])) <a
                target="_blank"
                href="{{$url.$files[$i]}}">View</a>@endif
    </div>
@endfor

@push('scripts')
    <script type="text/javascript">
        $('#mobile_verified_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            icons: {
                up: "icon-arrow-up-circle icons font-2xl",
                down: "icon-arrow-down-circle icons font-2xl"
            },
            sideBySide: true
        })
    </script>
@endpush


<!-- Mobile Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mobile', 'Mobile:') !!}
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    {!! Form::text('email_verified_at', null, ['class' => 'form-control','id'=>'email_verified_at']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#email_verified_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            icons: {
                up: "icon-arrow-up-circle icons font-2xl",
                down: "icon-arrow-down-circle icons font-2xl"
            },
            sideBySide: true
        })
    </script>
@endpush


<!-- Disabled Field -->
<div class="form-group col-sm-6">
    {!! Form::label('disabled', 'Is Active:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('disabled', 0) !!}
        {!! Form::checkbox('disabled', '1', null) !!}
    </label>
</div>


{{--<!-- User Type Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('user_type', 'User Type:') !!}--}}
{{--    {!! Form::text('user_type', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('agents.index') }}" class="btn btn-secondary">Cancel</a>
</div>
