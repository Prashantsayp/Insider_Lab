<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgentsRequest;
use App\Http\Requests\UpdateAgentsRequest;
use App\Models\User;
use App\Models\AgentTransaction;
use App\Repositories\AgentsRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Agents as UserAgents;
use App\Models\Cases;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Storage;
use Response;
//use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Arr;

class AgentsController extends AppBaseController
{
    /** @var  AgentsRepository */
    private $agentsRepository;

    public function __construct(AgentsRepository $agentsRepo)
    {
        $this->agentsRepository = $agentsRepo;
    }

    /**
     * Display a listing of the Agents.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $agents = UserAgents::where([["user_type", "=", "agent"]])->get();

        return view('agents.index')
            ->with('agents', $agents);
    }

    public function list(Request $request){

        $search = $request;
//print_r($search);exit;
        try {

            $agents = UserAgents::where([["user_type", "=", "agent"]])
                ->when($search,function($query,$search){                    

                    if(!empty($search->agentFilter)) {                                       
                       $query->whereIn('id', $search->agentFilter);
                    } 
                    if(!empty($search->statusFilter)) {

                        $query->whereIn('disabled', $search->statusFilter);;
                    } 

                    if(!empty($search->yearFilter)) {                      
                      $query->whereDate('created_at','>=', $search->yearFilter);
                    } 
 //print_r($query);exit;
                    if(!empty($search->MonthFilter)) {   
                       $query->whereDate('created_at','<=', $search->MonthFilter);              
                    }                     

                return $query;

            })->whereNotNull("name")->orderBy('id', 'DESC')
            ->get()->toArray();
                    
        } catch (\Throwable $th) {
        
            dd($th);
        }
       

        $data = (object) array(
            'draw'            => 1,
            'recordsTotal'    => 0,
            'recordsFiltered' => 0,
            'agent_list' => array(),
            'filters' => $search->input()
        );

         
        function action($id){
                  
            //$address = route('agents.show', [$agent->id]);

            //$address = route('Agent-Details'); 
            $view   = '<a href="'.$address.'">View</a>';            
       
            return $view;
        }     
//echo "<pre>";print_r($agents);exit;
        foreach($agents as $key => $agent){
           
            // $data->agent_list[] = array(
            //      'action'           => '<a href="'.route('Agent-Details', ['id=' .$agent['id']]).'" target="_blank">View</a>',
            //      'name'             => $agent['name'],
            //      'mobile'           => $agent['mobile'],
            //      'email'            => $agent['email'],
            //      'aadhar_card'      => $agent['aadhar_card'],
            //      'user_type'      => $agent['user_type'],
            //      'created_at'      => \Carbon\Carbon::parse(@$agent['created_at'])->format('d-m-Y'), 
                           
            //     );
            $data->agent_list[] = array(
                 'action'           => '<a href="'.route('Agent-Details', ['id=' .$agent['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'agent_id'             => $agent['id'],
                 'name'             => $agent['name'],
                 'mobile'           => $agent['mobile'],
                 'email'            => $agent['email'],
                 'location'            => $agent['location'],
                 'industry_services'            => $agent['financial_industry'],
                 'aadhar_card'      => $agent['aadhar_card'],
                 'user_type'      => $agent['current_profession'],
                 'disabled'      => $agent['disabled'] ? "Yes" : "No",
                 'created_at'      => \Carbon\Carbon::parse(@$agent['created_at'])->format('d M Y'), 
                 'mobile_verified_at'      => \Carbon\Carbon::parse(@$agent['v'])->format('d M Y'),
                 'mobile'      => $agent['mobile'],           
                );
        }   
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->agent_list);
        $data->recordsFiltered = count($data->agent_list);

        return Response::json($data);

    }
    public function details($id=null, Request $request)
    {
        
        $agents = $this->agentsRepository->find($request->id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $files = Storage::disk('s3')->files("agents/$request->id/");
        $files = array_reverse($files);

        $documents = Storage::disk('s3')->files("agents/$request->id/agreement_document/");
        $documents = array_reverse($documents);

        $total_disbursed_amount = Cases::where([["created_by", "=", $request->id],["case_status", "=", 'Disbursed']])
                       ->sum('disbursed_amount');

        $total_disbursed_cases = Cases::where([["created_by", "=", $request->id],["case_status", "=", 'Disbursed']])
                       ->count('id'); 
        
        $month_disbursed_cases = Cases::where([["created_by", "=", $request->id],["case_status", "=", 'Disbursed']])
                    ->whereMonth('updated_at', Carbon::now()->month)                 
                    ->count('id');
        $month_disbursed_amount = Cases::where([["created_by", "=", $request->id],["case_status", "=", 'Disbursed']])
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->sum('disbursed_amount');                 

        $month_case_registered = Cases::where([["created_by", "=", $request->id]])
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->count('id');
        $month_case_logins = Cases::where([["created_by", "=", $request->id]])
                    ->whereMonth('case_login_date', Carbon::now()->month)
                    ->count('id');
        $month_case_rejections = Cases::where([["created_by", "=", $request->id],["status", "=", 'Case-Rejected']])
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->count('id');
        $month_case_approval = Cases::where([["created_by", "=", $request->id],["case_status", "=", 'Approved']])
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->count('id');

        $case_created = Cases::where([["created_by", "=", $request->id]])->count('id');
        $case_approved = Cases::where([["created_by", "=", $request->id],["case_status", "=", 'Approved']])->orWhere([["created_by", "=", $request->id],["case_status", "=", 'Disbursed']])->count('id');
        $conversion_ratio =  0;
        if($case_created && $case_approved){
        $conversion_ratio =   $case_created / $case_approved * 100; 
        }
        


        $case_active = Cases::where([["created_by", "=", $request->id],["case_status", "!=", 'Disbursed']])->Where([["created_by", "=", $request->id],["status", "!=", 'Case-Rejected']])->Where([["created_by", "=", $request->id],["status", "!=", 'Hold']])->Where([["created_by", "=", $request->id],["status", "!=", 'Not Eligible']])->count('id');

        // echo $currentMonth;
         //echo "<pre>"; print_r($case_active);
        // //echo "<pre>"; print_r(count($month_disbursed_amount));
        // exit;



        $transaction = DB::table('agent_transaction')
                    ->where('agent_id', $request->id)
                    ->get()->toArray();
       
        
        return view('agents.details', compact('agents','transaction','files','url','documents','total_disbursed_amount','total_disbursed_cases','month_disbursed_cases','month_disbursed_amount','month_case_registered','month_case_logins','month_case_rejections','month_case_approval','conversion_ratio','case_active'));
    }
	public function agentStatus(Request $request){
        $data  = $request->input();
        //print_r($data);exit;
        if(UserAgents::find($data['id'])->update(['disabled' => $data['disabled']])){
            $values['msg'] = 'Agent Status Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Agent Status Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }
	public function cases_list(Request $request){


        $search = $request;
        try {
            $cases = Cases::where([["load_type", "=", "Professional"],["created_by", "=", $search->agent_id]])
                      // ->select('id','first_name','last_name','mobile','status','address','updated_at','created_at','employment_type','occupation','loan_period','load_amount','total_loans','monthly_salary','client_income','cibil','highest_degree','past_loans','*.agents')
                      ->select('*')
                      ->with('agents')
                      ->when($search,function($query,$search){                    

 //                    if(!empty($search->agentFilter)) {                                       
 //                       $query->whereIn('id', $search->agentFilter);
 //                    } 
 //                    if(!empty($search->statusFilter)) {

 //                        $query->whereIn('disabled', $search->statusFilter);;
 //                    } 

 //                    if(!empty($search->yearFilter)) {                      
 //                      $query->whereDate('created_at','>=', $search->yearFilter);
 //                    } 
 // //print_r($query);exit;
 //                    if(!empty($search->MonthFilter)) {   
 //                       $query->whereDate('created_at','<=', $search->MonthFilter);              
 //                    }                     

                //return $query;

            })->whereNotNull("first_name")->orderBy('id', 'DESC')
            ->get()->toArray();
                    
        } catch (\Throwable $th) {
        
            dd($th);
        }
      // echo "<pre>";print_r($cases);exit;

        $data = (object) array(
            'draw'            => 1,
            'recordsTotal'    => 0,
            'recordsFiltered' => 0,
            'case_list' => array(),
            'filters' => $search->input()
        );

         
        // function action($id){
                  
        //     $address = route('agents.show', [$agent->id]);

        //     $address = route('Agent-Details'); 
        //    $view   = '<a href="'.$address.'">View</a>';            
       
        //     return $view;
        // }     

        foreach($cases as $key => $case){
           //echo "<pre>";print_r($case);exit;
            
            $data->case_list[] = array(
                 'action'           => '<a href="'.route('Case-Details', ['id=' .$case['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'case_id'         => $case['id'],
                 'name'             => $case['first_name'].' '.$case['last_name'],
                 'mobile'           => $case['mobile'],
                 // 'email'            => $case['email'],
                 'location'            => $case['address'],
                 'status'            => $case['status'],
                 'updated'      => \Carbon\Carbon::parse(@$case['updated_at'])->format('d M Y h:i:s'),
                 'cibil'      => $case['cibil'],
                 'user_name'      => '<a href="'.route('Agent-Details', ['id=' .$case['created_by']]).'" target="_blank">'.$case['agents']['name'].'</a>',
                 // 'case_in_system'      => 'Case In System',
                 'profession'            => $case['occupation'],
                 'create_date_time'            => \Carbon\Carbon::parse(@$case['created_at'])->format('d M Y h:i:s'),
                 'employee_type'            => $case['employment_type'],
                 'degree'            => $case['highest_degree'],
                 'lender'            => $case['loan_period'],
                 'desired_loan_amount'            => $case['load_amount'],
                 'past_loan'            => $case['past_loans'],
                 'monthly_salary'            => $case['monthly_salary'],
                 'annual_income'            => $case['client_income'],
                            
                );
        }   
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->case_list);
        $data->recordsFiltered = count($data->case_list);

        return Response::json($data);
    }

    public function cases_list_personal(Request $request){
    //echo "<pre>";print_r('vijay');exit;
        $search = $request;
        try {

            $cases = Cases::where([["load_type", "=", "Personal"],["created_by", "=", $search->agent_id]])
                // ->select('id','first_name','last_name','mobile','status','address','updated_at','created_at','employment_type','occupation','loan_period','load_amount','total_loans','monthly_salary','client_income','past_loans','cibil','highest_degree')
                ->select('*')
                ->with('agents')
                ->when($search,function($query,$search){                    

         //                    if(!empty($search->agentFilter)) {                                       
         //                       $query->whereIn('id', $search->agentFilter);
         //                    } 
         //                    if(!empty($search->statusFilter)) {

         //                        $query->whereIn('disabled', $search->statusFilter);;
         //                    } 

         //                    if(!empty($search->yearFilter)) {                      
         //                      $query->whereDate('created_at','>=', $search->yearFilter);
         //                    } 
         // //print_r($query);exit;
         //                    if(!empty($search->MonthFilter)) {   
         //                       $query->whereDate('created_at','<=', $search->MonthFilter);              
         //                    }                     

                return $query;

            })->whereNotNull("first_name")->orderBy('id', 'DESC')
            ->get()->toArray();
                    
        } catch (\Throwable $th) {
        
            dd($th);
        }
       //echo "<pre>";print_r($cases);exit;

        $data = (object) array(
            'draw'            => 1,
            'recordsTotal'    => 0,
            'recordsFiltered' => 0,
            'personal_list' => array(),
            'filters' => $search->input()
        );

         
        function action($id){
                  
            //$address = route('agents.show', [$agent->id]);

            //$address = route('Agent-Details'); 
           // $view   = '<a href="'.$address.'">View</a>';            
       
            return $view;
        }     

        foreach($cases as $key => $case){
           //echo "<pre>";print_r($case);exit;
            
            $data->personal_list[] = array(
                 'action'           => '<a href="'.route('Case-Details', ['id=' .$case['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'case_id'         => $case['id'],
                 'name'             => $case['first_name'].' '.$case['last_name'],
                 'mobile'           => $case['mobile'],
                 // 'email'            => $case['email'],
                 'location'            => $case['address'],
                 'status'            => $case['status'],
                 'updated'      => \Carbon\Carbon::parse(@$case['updated_at'])->format('d M Y h:i:s'),
                 'cibil'      => $case['cibil'],
                 'user_name'      => '<a href="'.route('Agent-Details', ['id=' .$case['created_by']]).'" target="_blank">'.$case['agents']['name'].'</a>',
                 // 'case_in_system'      => 'Case In System',
                 'profession'            => $case['occupation'],
                 'create_date_time'            => \Carbon\Carbon::parse(@$case['created_at'])->format('d M Y h:i:s'),
                  'employee_type'            => $case['employment_type'],
                 // 'degree'            => $case['highest_degree'],
                 'lender'            => $case['loan_period'],
                 'desired_loan_amount'            => $case['load_amount'],
                 'past_loan'            => $case['past_loans'],
                 'monthly_salary'            => $case['monthly_salary'],
                 // 'annual_income'            => $case['client_income'],
                            
                );
        }   
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->personal_list);
        $data->recordsFiltered = count($data->personal_list);

        return Response::json($data);

    }


    public function cases_list_business(Request $request){
    //echo "<pre>";print_r('vijay');exit;
        $search = $request;
        try {

            $cases = Cases::where([["load_type", "=", "Business"],["created_by", "=", $search->agent_id]])
                // ->select('id','first_name','last_name','mobile','status','address','updated_at','created_at','employment_type','occupation','loan_period','load_amount','total_loans','monthly_salary','client_income','cibil','highest_degree','past_loans')
                ->select('*')
                ->with('agents')
                ->when($search,function($query,$search){                    

         //                    if(!empty($search->agentFilter)) {                                       
         //                       $query->whereIn('id', $search->agentFilter);
         //                    } 
         //                    if(!empty($search->statusFilter)) {

         //                        $query->whereIn('disabled', $search->statusFilter);;
         //                    } 

         //                    if(!empty($search->yearFilter)) {                      
         //                      $query->whereDate('created_at','>=', $search->yearFilter);
         //                    } 
         // //print_r($query);exit;
         //                    if(!empty($search->MonthFilter)) {   
         //                       $query->whereDate('created_at','<=', $search->MonthFilter);              
         //                    }                     

                return $query;

            })->whereNotNull("first_name")->orderBy('id', 'DESC')
            ->get()->toArray();
                    
        } catch (\Throwable $th) {
        
            dd($th);
        }
       //echo "<pre>";print_r($cases);exit;

        $data = (object) array(
            'draw'            => 1,
            'recordsTotal'    => 0,
            'recordsFiltered' => 0,
            'business_list' => array(),
            'filters' => $search->input()
        );

         
        function action($id){
                  
            //$address = route('agents.show', [$agent->id]);

            //$address = route('Agent-Details'); 
           // $view   = '<a href="'.$address.'">View</a>';            
       
            return $view;
        }     

        foreach($cases as $key => $case){
           //echo "<pre>";print_r($case);exit;
            
            $data->business_list[] = array(
                 'action'           => '<a href="'.route('Case-Details', ['id=' .$case['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'case_id'         => $case['id'],
                 'name'             => $case['first_name'].' '.$case['last_name'],
                 'mobile'           => $case['mobile'],
                 // 'email'            => $case['email'],
                 'location'            => $case['address'],
                 'status'            => $case['status'],
                 'updated'      => \Carbon\Carbon::parse(@$case['updated_at'])->format('d M Y'),
                 'cibil'      => $case['cibil'],
                 'user_name'      => '<a href="'.route('Agent-Details', ['id=' .$case['created_by']]).'" target="_blank">'.$case['agents']['name'].'</a>',
                 // 'case_in_system'      => 'Case In System',
                 'profession'            => $case['occupation'],
                 'create_date_time'            => \Carbon\Carbon::parse(@$case['created_at'])->format('d M Y h:i:s'),
                 'employee_type'            => $case['employment_type'],
                 'degree'            => $case['highest_degree'],
                 
                 'past_loan'            => $case['past_loans'],
                 'tenure'            => $case['loan_period'],
                 'desired_loan_amount'            => $case['load_amount'],
                 
                 'monthly_salary'            => $case['monthly_salary'],
                 'annual_income'            => $case['client_income'],
                            
                );
        }   
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->business_list);
        $data->recordsFiltered = count($data->business_list);

        return Response::json($data);

    }

    
    /**
     * Show the form for creating a new Agents.
     *
     * @return Response
     */
    public function create()
    {
        return view('agents.create');
    }

    /**
     * Store a newly created Agents in storage.
     *
     * @param CreateAgentsRequest $request
     *
     * @return Response
     */
    public function store(CreateAgentsRequest $request)
    {
        $input = $request->all();

        $agents = User::create($input);
        if ($request->hasFile('doc_1')) {
            $file = $request->file('doc_1');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$agents->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_2')) {
            $file = $request->file('doc_2');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$agents->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_3')) {
            $file = $request->file('doc_3');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$agents->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_4')) {
            $file = $request->file('doc_4');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$agents->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_5')) {
            $file = $request->file('doc_5');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$agents->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        Flash::success('Agents saved successfully.');

        return redirect(route('agents.index'));
    }

    /**
     * Display the specified Agents.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agents = $this->agentsRepository->find($id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $files = Storage::disk('s3')->files("agents/$id/");
        $files = array_reverse($files);
        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        return view('agents.show', compact('files', 'url'))->with('agents', $agents);
    }

    /**
     * Show the form for editing the specified Agents.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agents = $this->agentsRepository->find($id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $files = Storage::disk('s3')->files("agents/$id/");
        $files = array_reverse($files);
        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        return view('agents.edit', compact('url', 'files'))->with('agents', $agents);
    }

    /**
     * Update the specified Agents in storage.
     *
     * @param int $id
     * @param UpdateAgentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgentsRequest $request)
    {
        $agents = $this->agentsRepository->find($id);

        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }
        $agents = $this->agentsRepository->update($request->all(), $id);
        if ($request->hasFile('doc_1')) {
            $file = $request->file('doc_1');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_2')) {
            $file = $request->file('doc_2');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_3')) {
            $file = $request->file('doc_3');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_4')) {
            $file = $request->file('doc_4');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_5')) {
            $file = $request->file('doc_5');
            $name = time() . $file->getClientOriginalName();
            $filePath = "agents/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        Flash::success('Agents updated successfully.');

        return redirect(route('agents.index'));
    }

    /**
     * Remove the specified Agents from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agents = $this->agentsRepository->find($id);

        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        $this->agentsRepository->delete($id);

        Flash::success('Agents deleted successfully.');

        return redirect(route('agents.index'));
    }


    public function summary_create(Request $request)
    {   
        $data  = $request->input(); 
      // print_r($data);exit;
        if(UserAgents::find($data['id'])->update($data)){
            $values['msg'] = 'Agent Summary Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Agent Summary Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }
    public function bank_earning_create(Request $request)
    {   
        $data  = $request->input(); 
       //print_r();exit;
        if(UserAgents::find($data['id'])->update($data)){
            $values['msg'] = 'Agent Bank & Earning Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Agent Bank & Earning Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }
    public function bank_transaction_create(Request $request)
    {   
       $transactionData = array();
       $agent_id = $request->agent_id;
       $from = $request->from;
       $to = $request->to;
       $total_amount = $request->total_amount;
       $reference_no = $request->reference_no;
       $receipt = $request->receipt;

        for($s = 0; $s < count($from); $s++){
              array_push($transactionData,array(
                  'agent_id' => $agent_id,
                  'from' => $from[$s],
                  'to' => $to[$s],
                  'total_amount'      => !empty($total_amount[$s]) ? $total_amount[$s] : "Null",
                  'reference_no'      => !empty($reference_no[$s]) ? $reference_no[$s] : "Null",
                  'receipt'      => !empty($receipt[$s]) ? $receipt[$s] : "Null"

              ));  
             if ($receipt[$s]) {  
                    $fileName = time().'.'.$receipt[$s]->getClientOriginalExtension();  
                    
                    $receipt[$s]->move(public_path('transaction_receipts'), $fileName);
                    //$data['upload_letter'] = $fileName;
                } 
           
        }  
       
        //echo "<pre>"; print_r($transactionData);exit;
        AgentTransaction::where('agent_id', $agent_id)->delete();
        $transactionRowsTableResponse = AgentTransaction::insert($transactionData);
        if($transactionRowsTableResponse){
            $values['msg'] = 'Agent Transaction Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Agent Transaction Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }
    public function documents_update(Request $request)
    {
        $data = $request->all();  
        $agent_id = $data['id'];
        
        $agents = $this->agentsRepository->find($agent_id);
       // print_r($agents);exit;
        if (empty($agents)) {
             $values['msg'] = 'Service Partner Agreement Not Updated!';
             $values['message'] = 'fail';
             $successresult = json_encode($values);
             echo $successresult;
             exit; 
        }
       // $agents = $this->agentsRepository->update($request->all(), $id);
       // echo "<pre>"; print_r($file);exit;
        if ($request->hasFile('agreement_document')) {
            $file = $request->file('agreement_document');
            $name = time() . $file->getClientOriginalName();
            //echo "<pre>"; print_r($name);exit;
            $filePath = "agents/$agent_id/agreement_document/" . $name;

            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }

       $values['msg'] = 'Service Partner Agreement Updated successfully!';
       $values['message'] = 'success';
       $successresult = json_encode($values);
       echo $successresult;
       exit; 
    }
}
