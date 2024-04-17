<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $agents->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $agents->email }}</p>
</div>

<!-- Pan Card Field -->
{{--<div class="form-group">--}}
{{--    {!! Form::label('pan_card', 'Pan Card:') !!}--}}
{{--    <p><img src="{{ $agents->pan_card }}"/></p>--}}
{{--</div>--}}

{{--<!-- Aadhar Card Field -->--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('aadhar_card', 'Aadhar Card:') !!}--}}
{{--    <p><img src="{{ $agents->aadhar_card }}"/></p>--}}
{{--</div>--}}

<!-- Mobile Verified At Field -->
<div class="form-group">
    {!! Form::label('mobile_verified_at', 'Mobile Verified At:') !!}
    <p>{{ $agents->mobile_verified_at }}</p>
</div>

<!-- Mobile Field -->
<div class="form-group">
    {!! Form::label('mobile', 'Mobile:') !!}
    <p>{{ $agents->mobile }}</p>
</div>

<!-- Location Field -->
<div class="form-group">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $agents->location }}</p>
</div>

<!-- Email Verified At Field -->
<div class="form-group">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    <p>{{ $agents->email_verified_at }}</p>
</div>

<!-- Password Field -->
{{--<div class="form-group">--}}
{{--    {!! Form::label('password', 'Password:') !!}--}}
{{--    <p>{{ $agents->password }}</p>--}}
{{--</div>--}}

<!-- Remember Token Field -->
{{--<div class="form-group">--}}
{{--    {!! Form::label('remember_token', 'Remember Token:') !!}--}}
{{--    <p>{{ $agents->remember_token }}</p>--}}
{{--</div>--}}

<!-- Disabled Field -->
<div class="form-group">
    {!! Form::label('disabled', 'Disabled:') !!}
    <p>{{ $agents->disabled }}</p>
</div>

<!-- User Type Field -->
<div class="form-group">
    {!! Form::label('user_type', 'User Type:') !!}
    <p>{{ $agents->user_type }}</p>
</div>
@for($i = 0; $i < 5; $i++)
    @php
        $i_n = $i+1;
    @endphp
    <div class="form-group">
        {!! Form::label("doc_$i_n", "Document $i_n:") !!}
        @if(isset($url) && isset($files[$i])) <a target="_blank" href="{{$url.$files[$i]}}">View</a>@endif
    </div>
@endfor
