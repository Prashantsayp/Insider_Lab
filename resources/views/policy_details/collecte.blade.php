

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('salary', 'Salary:') !!}
    {!! Form::text('salary', null, ['class' => 'form-control']) !!}
</div>

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('profile', 'Profile:') !!}
    {!! Form::select('profile', ["MBBS" => "MBBS", "MBBS_MD_MS_PG" => "MBBS-MD/MS/PG Diploma", "BDS" => "BDS", "MDS" => "MDS", "BAMS_BHMS" => "BAMS/BHMS"], null, ['class' => 'form-control']) !!}
</div>

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ownership_status', 'Ownership:') !!}
    {!! Form::select('ownership_status', ["no" => "Rented", "yes" => "Self Owned"], null, ['class' => 'form-control']) !!}
</div>

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employment_type', 'Salary:') !!}
    {!! Form::select('employment_type', ["self_employed" => "Self", "salaried" => "Salaried", "salaried_plus_self_employed" => "Salaried + Self Employed"], null, ['class' => 'form-control']) !!}
</div>

<!-- Experience Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('experience', 'Experience:') !!}
    {!! Form::text('experience', null, ['class' => 'form-control']) !!}
</div>

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_amount', 'Loan Amount:') !!}
    {!! Form::text('loan_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Condition Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tenure', 'Tenure (Months):') !!}
    {!! Form::text('tenure', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Condition Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_cat', 'Company Category:') !!}
    {!! Form::select("company_class", ["" => "Please select Category", "1" => "Category A", "2" => "Category B"], null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Condition Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obligations', 'Obligations:') !!}
    {!! Form::text('obligations', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Condition Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('salary_bank', 'Salary Bank:') !!}
    {!! Form::select("bank_account", ["" => "Please select Bank", "1" => "HDFC", "2" => "Non-HDFC"],
    null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('policyDetails.index') }}" class="btn btn-secondary">Cancel</a>
</div>
