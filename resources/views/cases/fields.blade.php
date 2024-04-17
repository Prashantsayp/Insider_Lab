<div class="row">
    <div class="col-sm-6">
        <!-- First Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('first_name', 'First Name:') !!}
            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Last Name Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('last_name', 'Last Name:') !!}
            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Mobile Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('mobile', 'Mobile:') !!}
            {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Pin Code Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('pin_code', 'Pin Code:') !!}
            {!! Form::text('pin_code', null, ['class' => 'form-control']) !!}
        </div>

        @if(isset($url) && isset($files[0]) && isset($case))
            <div class="form-group">
                <a href="{{\Illuminate\Support\Facades\URL::to("downloadCasesZip/$case->id")}}" class="btn btn-primary">Download Zip</a>
            </div>
        @endif
        @for($i = 0; $i < 8; $i++)
            @php
                $i_n = $i+1;
            @endphp
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label("doc_$i_n", "Document $i_n:") !!}
                {!! Form::file("doc_$i_n", null, ['class' => 'form-control']) !!}
            </div>
        @endfor

{{--    <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_1', 'Document 1:') !!}--}}
{{--            {!! Form::file('doc_1', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}
{{--        <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_3', 'Document 3:') !!}--}}
{{--            {!! Form::file('doc_3', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}

{{--        <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_4', 'Document 4:') !!}--}}
{{--            {!! Form::file('doc_4', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}

{{--        <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_5', 'Document 5:') !!}--}}
{{--            {!! Form::file('doc_5', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}

{{--        <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_6', 'Document 6:') !!}--}}
{{--            {!! Form::file('doc_6', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}

{{--        <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_7', 'Document 7:') !!}--}}
{{--            {!! Form::file('doc_7', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}

{{--        <!-- Pan Card Field -->--}}
{{--        <div class="form-group col-sm-12 col-lg-12">--}}
{{--            {!! Form::label('doc_8', 'Document 8:') !!}--}}
{{--            {!! Form::file('doc_8', null, ['class' => 'form-control']) !!} <a href="">View</a>--}}
{{--        </div>--}}

        <!-- Date Of Birth Field -->
        <div class="form-group col-sm-12">
            <!-- {!! Form::label('date_of_birth', 'Date Of Birth:') !!}

            {!! Form::date('date_of_birth', null, ['class' => 'form-control dtp','id'=>'date_of_birth']) !!} -->
            <label>Date Of Birth</label>
             <input type="date" class="form-control" placeholder="Date Of Birth" value="{{ date('Y-m-d', $case->date_of_birth) }}" name="date_of_birth" style="width: 170px;">
        </div>

        @push('scripts')
            <script type="text/javascript">
                $('.dtp').datetimepicker({
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


    <!-- Company Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('company', 'Company:') !!}
            {!! Form::text('company', null, ['class' => 'form-control']) !!}
        </div>
        <!-- Field Of Work Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('field_of_work', 'Field Of Work:') !!}
            {!! Form::textarea('field_of_work', null, ['class' => 'form-control']) !!}
        </div>


        <!-- Designation Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('designation', 'Designation:') !!}
            {!! Form::text('designation', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Monthly Salary Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('monthly_salary', 'Monthly Salary:') !!}
            {!! Form::text('monthly_salary', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Monthly Emi Field -->
    {{--<div class="form-group col-sm-12">--}}
    {{--    {!! Form::label('monthly_emi', 'Monthly Emi:') !!}--}}
    {{--    {!! Form::text('monthly_emi', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}

    <!-- Load Type Field -->

        <div class="form-group col-sm-12">
            {!! Form::label('load_type', 'Load Type:') !!}
            {!! Form::select('status', ['Professional'=>'Professional', 'Personal'=>'Personal'], null, ['class' => 'form-control']) !!}
        </div>
        <!-- Load Amount Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('load_amount', 'Load Amount:') !!}
            {!! Form::text('load_amount', null, ['class' => 'form-control']) !!}
        </div>
        <!-- Mode Of Salary Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('mode_of_salary', 'Mode Of Salary:') !!}
            {!! Form::select('mode_of_salary', ['cash'=>'Cash', 'cheque'=>'Cheque', 'bank'=>'Bank'], null, ['class' => 'form-control']) !!}
        </div>

        <!-- Salary Bank Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('salary_bank', 'Salary Bank:') !!}
            {!! Form::text('salary_bank', null, ['class' => 'form-control']) !!}
        </div>
        <!-- Load Purpose Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('load_purpose', 'Load Purpose:') !!}
            {!! Form::textarea('load_purpose', null, ['class' => 'form-control']) !!}
        </div>

		<!-- Assigned To Agents -->
        {{--<div class="form-group col-sm-6 col-md-6">--}}
            {{--{!! Form::label('assigned_to', 'Assigned To(Agents):') !!}--}}
            {{--{!! Form::select('assigned_to', $agents, null, ['class' => 'form-control']) !!}--}}
        {{--</div>--}}
		
        <!-- Assigned To Field -->
        <div class="form-group col-sm-6 col-md-6">
            {!! Form::label('created_by', 'Assigned To(Created By/Agents):') !!}
            {!! Form::select('created_by', $agents, null, ['class' => 'form-control']) !!}
        </div>

        <!-- Created By Field -->
    {{--<div class="form-group col-sm-12">--}}
    {{--    {!! Form::label('created_by', 'Created By:') !!}--}}
    {{--</div>--}}
    {{--{!! Form::hidden('created_by', 1, ['class' => 'form-control']) !!}--}}

    <!-- Status Field -->
		<div class="form-group col-sm-6">
			{!! Form::label('status', 'Additional Status:') !!}
            {!! Form::select('status', ['Not Selected'=>'Not Selected', 'New Document Request'=>'New Document Request', 'Not Eligible'=>'Not Eligible', 'Case-Rejected'=>'Case-Rejected'], null, ['class' => 'form-control']) !!}
        </div>
		<div class="form-group col-sm-6">
            {!! Form::label('case_status', 'Status:') !!}
            {!! Form::select('case_status', ['New - Select Loan Product'=>'New - Select Loan Product', 'New - Upload Documents'=>'New - Upload Documents', 'New - Submit Application'=>'New - Submit Application', 'Check Eligibility'=>'Check Eligibility', 'Lender Login'=>'Lender Login', 'Approved'=>'Approved', 'Disbursed'=>'Disbursed'], null, ['class' => 'form-control']) !!}
        </div>
        <!--<div class="form-group col-sm-12">
            {!! Form::label('status', 'Status:') !!}
            {!! Form::select('status', $case_status, null, ['class' => 'form-control']) !!}
        </div>-->

        <!-- Case Login Date Field -->
        <div class="form-group col-sm-12 col-lg-12">
            <!-- {!! Form::label('case_login_date', 'Case Login Date:') !!}
            {!! Form::text('case_login_date', null, ['class' => 'form-control dtp']) !!} -->
            <label>Case Login Date</label>
             <input type="date" class="form-control" placeholder="Case Login Date" value="{{ date('Y-m-d', strtotime($case->case_login_date)) }}" name="case_login_date" style="width: 170px;">
        </div>

        <!-- Case Login Date Field -->
        <div class="form-group col-sm-12 col-lg-12">
           <!--  {!! Form::label('bank_login_date', 'Bank Login Date:') !!}
            {!! Form::text('bank_login_date', null, ['class' => 'form-control dtp']) !!} -->
            <label>Bank Login Date</label>
             <input type="date" class="form-control" placeholder="Bank Login Date" value="{{ date('Y-m-d', strtotime($case->bank_login_date)) }}" name="bank_login_date" style="width: 170px;">
        </div>



        <!-- disbursed_amount Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('disbursed_amount', 'Disbursed Amount:') !!}
            {!! Form::text('disbursed_amount', null, ['class' => 'form-control']) !!}
        </div>

        <!-- disbursed_interest_rate Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('disbursed_interest_rate', 'Disbursed Interest Rate:') !!}
            {!! Form::text('disbursed_interest_rate', null, ['class' => 'form-control']) !!}
        </div>



    </div>
    <div class="col-sm-6">
        <!-- final_emi Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('final_emi', 'Final EMI:') !!}
            {!! Form::text('final_emi', null, ['class' => 'form-control']) !!}
        </div>

        <!-- disbursed_tenure Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('disbursed_tenure', 'Disbursed Tenure:') !!}
            {!! Form::text('disbursed_tenure', null, ['class' => 'form-control']) !!}
        </div>

        <!-- disbursed_tenure Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('agent_payout', 'Agent Payout:') !!}
            {!! Form::text('agent_payout', null, ['class' => 'form-control']) !!}
        </div>

        <!-- insiderlab_payout Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('insiderlab_payout', 'InsiderLab Payout:') !!}
            {!! Form::text('insiderlab_payout', null, ['class' => 'form-control']) !!}
        </div>
        <!-- selected_loan -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('selected_loan', 'Selected Loan:') !!}
            {!! Form::text('selected_loan', null, ['class' => 'form-control']) !!}
        </div>

        <!-- loan_period -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('loan_period', 'Loan Period(Year):') !!}
            {!! Form::number('loan_period', null, ['class' => 'form-control', 'min'=>1]) !!}
        </div>

        <!-- email -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>

        <!-- gender -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('gender', 'Gender:') !!}
            {!! Form::text('gender', null, ['class' => 'form-control']) !!}
        </div>

        <!-- marital_status -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('marital_status', 'Marital Status:') !!}
            {!! Form::text('marital_status', null, ['class' => 'form-control']) !!}
        </div>

        <!-- past_loans -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('past_loans', 'Past Loans:') !!}
            {!! Form::text('past_loans', null, ['class' => 'form-control']) !!}
        </div>

        <!-- aadhar_card_number Left - aadhar_card-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('aadhar_card_number', 'Aadhar Card Number:') !!}
            {!! Form::text('aadhar_card_number', null, ['class' => 'form-control']) !!}
        </div>

        <!-- pan_card_number-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('pan_card_number', 'PAN Number:') !!}
            {!! Form::text('pan_card_number', null, ['class' => 'form-control']) !!}
        </div>

        <!-- address_type-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('address_type', 'Address Type:') !!}
            {!! Form::text('address_type', null, ['class' => 'form-control']) !!}
        </div>

        <!-- residential_status-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('residential_status', 'Residential Status:') !!}
            {!! Form::text('residential_status', null, ['class' => 'form-control']) !!}
        </div>

        <!-- ongoing_monthly_obligations-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('ongoing_monthly_obligations', 'Ongoing Monthly Obligations:') !!}
            {!! Form::text('ongoing_monthly_obligations', null, ['class' => 'form-control']) !!}
        </div>

        <!-- work_experience-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('work_experience', 'Work Experience:') !!}
            {!! Form::text('work_experience', null, ['class' => 'form-control']) !!}
        </div>

        <!-- exp_with_current_employer-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('exp_with_current_employer', 'Experience With Current Employer:') !!}
            {!! Form::text('exp_with_current_employer', null, ['class' => 'form-control']) !!}
        </div>

        <!-- highest_degree-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('highest_degree', 'Highest Degree:') !!}
            {!! Form::text('highest_degree', null, ['class' => 'form-control']) !!}
        </div>

        <!-- years_in_business-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('years_in_business', 'Years In Business:') !!}
            {!! Form::text('years_in_business', null, ['class' => 'form-control']) !!}
        </div>

        <!-- total_loans-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('total_loans', 'Total Loans:') !!}
            {!! Form::text('total_loans', null, ['class' => 'form-control']) !!}
        </div>

        <!-- total_loans-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('employer_name', 'Employer Name:') !!}
            {!! Form::text('employer_name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- firm_name-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('occupation', 'Occupation:') !!}
            {!! Form::text('occupation', null, ['class' => 'form-control']) !!}
        </div>

        <!-- employment_type-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('employment_type', 'Employment Type:') !!}
            {!! Form::text('employment_type', null, ['class' => 'form-control']) !!}
        </div>

        <!-- organisation_type-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('organisation_type', 'Organisation Type:') !!}
            {!! Form::text('organisation_type', null, ['class' => 'form-control']) !!}
        </div>

        <!-- industry-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('industry', 'Industry:') !!}
            {!! Form::text('industry', null, ['class' => 'form-control']) !!}
        </div>

        <!-- working_from_home-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('working_from_home', 'Working From Home:') !!}
            {!! Form::text('working_from_home', null, ['class' => 'form-control']) !!}
        </div>

        <!-- premise_ownership_status-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('premise_ownership_status', 'Premise Ownership Status:') !!}
            {!! Form::text('premise_ownership_status', null, ['class' => 'form-control']) !!}
        </div>

        <!-- inform_client_income-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('inform_client_income', 'Inform Client Income:') !!}
            {!! Form::text('inform_client_income', null, ['class' => 'form-control']) !!}
        </div>

        <!-- primary_account-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('primary_account', 'Primary Account:') !!}
            {!! Form::text('primary_account', null, ['class' => 'form-control']) !!}
        </div>

        <!-- client_income-->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('client_income', 'Client Income:') !!}
            {!! Form::text('client_income', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('cases.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</div>


