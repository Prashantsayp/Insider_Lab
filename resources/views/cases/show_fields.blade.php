<div class="row">
    <div class="col-sm-6">
        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('id', 'CaseID:') !!}
            <p>{{ $case->id }}</p>
        </div>

        <!-- First Name Field -->
        <div class="form-group">
            {!! Form::label('first_name', 'First Name:') !!}
            <p>{{ $case->first_name }}</p>
        </div>

        <!-- Last Name Field -->
        <div class="form-group">
            {!! Form::label('last_name', 'Last Name:') !!}
            <p>{{ $case->last_name }}</p>
        </div>

        <!-- Mobile Field -->
        <div class="form-group">
            {!! Form::label('mobile', 'Mobile:') !!}
            <p>{{ $case->mobile }}</p>
        </div>

        <!-- Pin Code Field -->
        <div class="form-group">
            {!! Form::label('pin_code', 'Pin Code:') !!}
            <p>{{ $case->pin_code }}</p>
        </div>


        <!-- Date Of Birth Field -->
        <div class="form-group">
            {!! Form::label('date_of_birth', 'Date Of Birth:') !!}
            <p>{{ $case->date_of_birth }}</p>
        </div>

        <!-- Company Field -->
        <div class="form-group">
            {!! Form::label('company', 'Company:') !!}
            <p>{{ $case->company }}</p>
        </div>

        <!-- Field Of Work Field -->
        <div class="form-group">
            {!! Form::label('field_of_work', 'Field Of Work:') !!}
            <p>{{ $case->field_of_work }}</p>
        </div>

        <!-- Designation Field -->
        <div class="form-group">
            {!! Form::label('designation', 'Designation:') !!}
            <p>{{ $case->designation }}</p>
        </div>

        <!-- Monthly Salary Field -->
        <div class="form-group">
            {!! Form::label('monthly_salary', 'Monthly Salary:') !!}
            <p>{{ $case->monthly_salary }}</p>
        </div>

        <!-- Monthly Emi Field -->
        <div class="form-group">
            {!! Form::label('monthly_emi', 'Monthly Emi:') !!}
            <p>{{ $case->monthly_emi }}</p>
        </div>

        <!-- Load Type Field -->
        <div class="form-group">
            {!! Form::label('load_type', 'Load Type:') !!}
            <p>{{ $case->load_type }}</p>
        </div>

        <!-- Load Amount Field -->
        <div class="form-group">
            {!! Form::label('load_amount', 'Load Amount:') !!}
            <p>{{ $case->load_amount }}</p>
        </div>

        <!-- Mode Of Salary Field -->
        <div class="form-group">
            {!! Form::label('mode_of_salary', 'Mode Of Salary:') !!}
            <p>{{ $case->mode_of_salary }}</p>
        </div>

        <!-- Salary Bank Field -->
        <div class="form-group">
            {!! Form::label('salary_bank', 'Salary Bank:') !!}
            <p>{{ $case->salary_bank }}</p>
        </div>

        <!-- Load Purpose Field -->
        <div class="form-group">
            {!! Form::label('load_purpose', 'Load Purpose:') !!}
            <p>{{ $case->load_purpose }}</p>
        </div>

        <!-- Assigned To Field -->
        <div class="form-group">
            {!! Form::label('assigned_to', 'Assigned To:') !!}
            <p>{{ $case->assigned_to }}</p>
        </div>

        <!-- Created By Field -->
        <div class="form-group">
            {!! Form::label('created_by', 'Created By:') !!}
            <p>{{ isset($case->CreatedBy->name) ? $case->CreatedBy->name : $case->created_by }}</p>
        </div>

        <!-- Status Field -->
        <div class="form-group">
            {!! Form::label('status', 'Additional Status:') !!}
            <p>{{ $case->status }}</p>
        </div>
		<div class="form-group">
            {!! Form::label('case_status', 'Status:') !!}
            <p>{{ $case->case_status }}</p>
        </div>

        @if(isset($url) && isset($files[0]))
        <div class="form-group">
            <a href="{{\Illuminate\Support\Facades\URL::to("downloadCasesZip/$case->id")}}"
                class="btn btn-primary">Download Zip</a>
        </div>
        @endif
        <!-- Pan Card Field -->
        {{--@for($i = 0; $i < 8; $i++)--}}
        {{--@php--}}
        {{--$i_n = $i+1;--}}
        {{--@endphp--}}
        {{--<div class="form-group">--}}
        {{--{!! Form::label("doc_$i_n", "Document $i_n:") !!}--}}
        {{--@if(isset($url) && isset($files[$i])) <a target="_blank" href="{{$url.$files[$i]}}">View</a>@endif--}}
        {{--</div>--}}
        {{--@endfor--}}
        <!-- Load Purpose Field -->
        <div class="form-group">
            {!! Form::label('case_login_date', 'Case Login date:') !!}
            <p>{{ date('d-M-Y h:i A', strtotime($case->case_login_date)) }}</p>
        </div>

        <!-- Load Purpose Field -->
        <div class="form-group">
            {!! Form::label('bank_login_date', 'Bank Login Date:') !!}
            <p>{{ date('d-M-Y h:i A', strtotime($case->bank_login_date)) }}</p>
        </div>

        <!-- disbursed_amount -->
        <div class="form-group">
            {!! Form::label('disbursed_amount', 'Disbursed Amount:') !!}
            <p>{{ $case->disbursed_amount ?? "-" }}</p>
        </div>

        <!-- disbursed_interest_rate -->
        <div class="form-group">
            {!! Form::label('disbursed_interest_rate', 'Disbursed Interest Rate:') !!}
            <p>{{ $case->disbursed_interest_rate ?? "-" }}</p>
        </div>

        <!-- final_emi -->
        <div class="form-group">
            {!! Form::label('final_emi', 'Final EMI:') !!}
            <p>{{ $case->final_emi ?? "-" }}</p>
        </div>

        <!-- disbursed_tenure -->
        <div class="form-group">
            {!! Form::label('disbursed_tenure', 'Disbursed Tenure:') !!}
            <p>{{ $case->disbursed_tenure ?? "-" }}</p>
        </div>
        <!-- agent_payout -->
        <div class="form-group">
            {!! Form::label('agent_payout', 'Agent Payout:') !!}
            <p>{{ $case->agent_payout ?? "-" }}</p>
        </div>

        <!-- insiderlab_payout -->
        <div class="form-group">
            {!! Form::label('insiderlab_payout', 'InsiderLab Payout:') !!}
            <p>{{ $case->insiderlab_payout ?? "-" }}</p>
        </div>

        <!-- selected_loan -->
        <div class="form-group">
            {!! Form::label('selected_loan', 'Selected Loan:') !!}
            <p>{{ $case->selected_loan ?? "-" }}</p>
        </div>

        <!-- loan_period -->
        <div class="form-group">
            {!! Form::label('loan_period', 'Loan Period:') !!}
            <p>{{ $case->loan_period ?? "-" }}</p>
        </div>

    </div>
    <div class="col-sm-6">


        <!-- email -->
        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            <p>{{ $case->email ?? "-" }}</p>
        </div>

        <!-- gender -->
        <div class="form-group">
            {!! Form::label('gender', 'Gender:') !!}
            <p>{{ $case->gender ?? "-" }}</p>
        </div>

        <!-- marital_status -->
        <div class="form-group">
            {!! Form::label('marital_status', 'Marital Status:') !!}
            <p>{{ $case->marital_status ?? "-" }}</p>
        </div>

        <!-- past_loans -->
        <div class="form-group">
            {!! Form::label('past_loans', 'Past Loans:') !!}
            <p>{{ $case->past_loans ?? "-" }}</p>
        </div>

        <!-- aadhar_card_number Left - aadhar_card-->
        <div class="form-group">
            {!! Form::label('aadhar_card_number', 'Aadhar Card Number:') !!}
            <p>{{ $case->aadhar_card_number ?? "-" }}</p>
        </div>

        <!-- pan_card_number-->
        <div class="form-group">
            {!! Form::label('pan_card_number', 'PAN Number:') !!}
            <p>{{ $case->pan_card_number ?? "-" }}</p>
        </div>

        <!-- address_type-->
        <div class="form-group">
            {!! Form::label('address_type', 'Address Type:') !!}
            <p>{{ $case->address_type ?? "-" }}</p>
        </div>

        <!-- residential_status-->
        <div class="form-group">
            {!! Form::label('residential_status', 'Residential Status:') !!}
            <p>{{ $case->residential_status ?? "-" }}</p>
        </div>

        <!-- ongoing_monthly_obligations-->
        <div class="form-group">
            {!! Form::label('ongoing_monthly_obligations', 'Ongoing Monthly Obligations:') !!}
            <p>{{ $case->ongoing_monthly_obligations ?? "-" }}</p>
        </div>

        <!-- work_experience-->
        <div class="form-group">
            {!! Form::label('work_experience', 'Work Experience:') !!}
            <p>{{ $case->work_experience ?? "-" }}</p>
        </div>

        <!-- exp_with_current_employer-->
        <div class="form-group">
            {!! Form::label('exp_with_current_employer', 'Experience With Current Employer:') !!}
            <p>{{ $case->exp_with_current_employer ?? "-" }}</p>
        </div>

        <!-- highest_degree-->
        <div class="form-group">
            {!! Form::label('highest_degree', 'Highest Degree:') !!}
            <p>{{ $case->highest_degree ?? "-" }}</p>
        </div>

        <!-- years_in_business-->
        <div class="form-group">
            {!! Form::label('years_in_business', 'Years In Business:') !!}
            <p>{{ $case->years_in_business ?? "-" }}</p>
        </div>

        <!-- business_industry-->
        <div class="form-group">
            {!! Form::label('business_industry', 'Industry of Business:') !!}
            <p>{{ $case->business_industry ?? "-" }}</p>
        </div>

        <!-- how_old_business-->
        <div class="form-group">
            {!! Form::label('how_old_business', 'How old is the business:') !!}
            <p>{{ $case->how_old_business ?? "-" }}</p>
        </div>

        <!-- total_loans-->
        <div class="form-group">
            {!! Form::label('total_loans', 'Total Loans:') !!}
            <p>{{ $case->total_loans ?? "-" ?? "-" }}</p>
        </div>

        <!-- total_loans-->
        <div class="form-group">
            {!! Form::label('employer_name', 'Employer Name:') !!}
            <p>{{ $case->employer_name ?? "-" }}</p>
        </div>

        <!-- firm_name-->
        <div class="form-group">
            {!! Form::label('occupation', 'Occupation:') !!}
            <p>{{ $case->occupation ?? "-" }}</p>
        </div>

        <!-- employment_type-->
        <div class="form-group">
            {!! Form::label('employment_type', 'Employment Type:') !!}
            <p>{{ $case->employment_type ?? "-" }}</p>
        </div>

        <!-- organisation_type-->
        <div class="form-group">
            {!! Form::label('organisation_type', 'Organisation Type:') !!}
            <p>{{ $case->organisation_type ?? "-" }}</p>
        </div>

        <!-- industry-->
        <div class="form-group">
            {!! Form::label('industry', 'Industry:') !!}
            <p>{{ $case->industry ?? "-" }}</p>
        </div>

        <!-- working_from_home-->
        <div class="form-group">
            {!! Form::label('working_from_home', 'Working From Home:') !!}
            <p>{{ $case->working_from_home ?? "-" }}</p>
        </div>

        <!-- premise_ownership_status-->
        <div class="form-group">
            {!! Form::label('premise_ownership_status', 'Premise Ownership Status:') !!}
            <p>{{ $case->premise_ownership_status ?? "-" }}</p>
        </div>

        <!-- business_health-->
        <div class="form-group">
            {!! Form::label('business_health', 'Declare health of Business:') !!}
            <p>{{ $case->business_health ?? "-" }}</p>
        </div>

        <!-- profitability_years-->
        <div class="form-group">
            {!! Form::label('profitability_years', 'Latest years of profitability:') !!}
            <p>{{ $case->profitability_years ?? "-" }}</p>
        </div>

        <!-- business_health-->
        <div class="form-group">
            {!! Form::label('business_health', 'Declare health of Business:') !!}
            <p>{{ $case->business_health ?? "-" }}</p>
        </div>
        <!-- inform_client_income-->
        <div class="form-group">
            {!! Form::label('inform_client_income', 'Inform Client Income:') !!}
            <p>{{ $case->inform_client_income ?? "-" }}</p>
        </div>

        <!-- primary_account-->
        <div class="form-group">
            {!! Form::label('primary_account', 'Primary Account:') !!}
            <p>{{ $case->primary_account ?? "-" }}</p>
        </div>

        <!-- client_income-->
        <div class="form-group">
            {!! Form::label('client_income', 'Client Income:') !!}
            <p>{{ $case->client_income ?? "-" }}</p>
        </div>

        <!-- account_holder_name -->
        <div class="form-group">
            {!! Form::label('account_holder_name', 'Account Holder Name:') !!}
            <p>{{ $case->account_holder_name ?? "-" }}</p>
        </div>

        <!-- account_number -->
        <div class="form-group">
            {!! Form::label('account_holder_name', 'Account Number:') !!}
            <p>{{ $case->account_number ?? "-" }}</p>
        </div>

        <!-- ifsc_code -->
        <div class="form-group">
            {!! Form::label('ifsc_code', 'IFSC:') !!}
            <p>{{ $case->ifsc_code ?? "-" }}</p>
        </div>

        <!-- address -->
        <div class="form-group">
            {!! Form::label('address', 'Bank Address:') !!}
            <p>{{ $case->address ?? "-" }}</p>
        </div>
    </div>
</div>
