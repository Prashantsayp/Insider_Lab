<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Pan Card Field -->
<div class="form-group">
    {!! Form::label('pan_card', 'Pan Card:') !!}
    <p>{{ $user->pan_card }}</p>
</div>

<!-- Aadhar Card Field -->
<div class="form-group">
    {!! Form::label('aadhar_card', 'Aadhar Card:') !!}
    <p>{{ $user->aadhar_card }}</p>
</div>

<!-- Mobile Verified At Field -->
<div class="form-group">
    {!! Form::label('mobile_verified_at', 'Mobile Verified At:') !!}
    <p>{{ $user->mobile_verified_at }}</p>
</div>

<!-- Mobile Field -->
<div class="form-group">
    {!! Form::label('mobile', 'Mobile:') !!}
    <p>{{ $user->mobile }}</p>
</div>

<!-- Location Field -->
<div class="form-group">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $user->location }}</p>
</div>

<!-- Email Verified At Field -->
<div class="form-group">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    <p>{{ $user->email_verified_at }}</p>
</div>

<!-- Password Field -->
<div class="form-group">
    {!! Form::label('password', 'Password:') !!}
    <p>{{ $user->password }}</p>
</div>

<!-- Remember Token Field -->
<div class="form-group">
    {!! Form::label('remember_token', 'Remember Token:') !!}
    <p>{{ $user->remember_token }}</p>
</div>

<!-- Disabled Field -->
<div class="form-group">
    {!! Form::label('disabled', 'Disabled:') !!}
    <p>{{ $user->disabled }}</p>
</div>

<!-- User Type Field -->
<div class="form-group">
    {!! Form::label('user_type', 'User Type:') !!}
    <p>{{ $user->user_type }}</p>
</div>

