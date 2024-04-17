<?php

namespace App\Http\Controllers;

use App\Models\CaseStatus;
use Illuminate\Support\Facades\Input;
use Flash;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Models\Cases;
//use Illuminate\Support\Facades\Auth;
use App\Models\EligibilityStatus;
use App\Models\Comments;
use App\Models\CaseFinalBankApproval;
use App\Models\CasePolicyDetails;
use App\Models\UploadDocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CasesRepository;
use App\Http\Requests\CreateCasesRequest;
use App\Http\Requests\UpdateCasesRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use File;
use ZipArchive;
use Illuminate\Support\Facades\Arr;
use Illuminate\Support\Facades\DB;


class CasesController extends AppBaseController
{
    /** @var  CasesRepository */
    private $casesRepository;
    protected $status = ["new", "doc_req", "doc_sub", "approved", "pending", "failed", "cold", "hot"];

    public function __construct(CasesRepository $casesRepo)
    {
        $this->casesRepository = $casesRepo;
    }

    /**
     * Display a listing of the Cases.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $case_id = \request('case_id') == '' ? '' : \request('case_id');
        $per_page = \request('per_page') == '' ? 10 : \request('per_page');

        if (!empty($case_id)) {
            $data['cases'] = Cases::where('id', '=', "$case_id")->orWhere('mobile', 'like', "%$case_id%")->orderBy('id','desc')->paginate($per_page);
        } else {
            $data['cases'] = Cases::orderBy('id','desc')->paginate($per_page);
        }
        $data['agents'] = User::all();
        // echo '<pre>';
        // print_r($data['agents']);exit;
        // $cases = Cases::where([["assigned_to", "=" , Auth::user()->id]])->get();
//        $cases = Cases::get();

        return view('cases.index', compact('case_id'))
            ->with('data', $data);
    }

    /**
     * Show the form for creating a new Cases.
     *
     * @return Response
     */
    public function create()
    {
        $case_status = CaseStatus::whereis_active(1)->pluck("title", "id");
        $agents = User::where([["user_type", "=", "agent"]])->pluck("name", "id");
        return view('cases.create', compact('case_status', 'agents'));
    }

    /**
     * Store a newly created Cases in storage.
     *
     * @param CreateCasesRequest $request
     *
     * @return Response
     */
    public function store(CreateCasesRequest $request)
    {
        $this->validate($request, [
            'pan_card' => 'max:409600'
        ]);
        $input = $request->all();
        //$cases = $this->casesRepository->create($input);
        $cases = Cases::create($input);
        if ($request->hasFile('doc_1')) {
            $file = $request->file('doc_1');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_2')) {
            $file = $request->file('doc_2');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_3')) {
            $file = $request->file('doc_3');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_4')) {
            $file = $request->file('doc_4');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_5')) {
            $file = $request->file('doc_5');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_6')) {
            $file = $request->file('doc_6');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_7')) {
            $file = $request->file('doc_7');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_8')) {
            $file = $request->file('doc_8');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$cases->id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        Flash::success('Cases saved successfully.');

        return redirect(route('cases.index'));
    }

    /**
     * Display the specified Cases.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cases = $this->casesRepository->find($id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $files = Storage::disk('s3')->files("cases/$cases->id/");
        $files = array_reverse($files);
        if (empty($cases)) {
            Flash::error('Cases not found');

            return redirect(route('cases.index'));
        }

        return view('cases.show', compact('files', 'url'))->with('case', $cases);
    }

    /**
     * Show the form for editing the specified Cases.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $case = $this->casesRepository->find($id);
        $users = User::all()->pluck("name", "id");
        $case_status = CaseStatus::whereis_active(1)->pluck("title", "id");
        $agents = User::where([["user_type", "=", "agent"]])->pluck("name", "id");
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $files = Storage::disk('s3')->files("cases/$case->id/");
        $files = array_reverse($files);
        if (empty($case)) {
            Flash::error('Cases not found');

            return redirect(route('cases.index'));
        }

        return view('cases.edit', compact('case_status', 'agents', 'case', 'users', 'files', 'url'))/*->with("case_status", $this->status)*/;
    }

    /**
     * Update the specified Cases in storage.
     *
     * @param int $id
     * @param UpdateCasesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCasesRequest $request)
    {
//        $cases = $this->casesRepository->find($id);
        $cases = Cases::find($id);

        if (empty($cases)) {
            Flash::error('Cases not found');

            return redirect(route('cases.index'));
        }
//print_r($request->file('doc_1'));exit;
        $cases = $cases->update($request->all());
        if ($request->hasFile('doc_1')) {
            $file = $request->file('doc_1');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_2')) {
            $file = $request->file('doc_2');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_3')) {
            $file = $request->file('doc_3');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_4')) {
            $file = $request->file('doc_4');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_5')) {
            $file = $request->file('doc_5');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_6')) {
            $file = $request->file('doc_6');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }

        if ($request->hasFile('doc_7')) {
            $file = $request->file('doc_7');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        if ($request->hasFile('doc_8')) {
            $file = $request->file('doc_8');
            $name = time() . $file->getClientOriginalName();
            $filePath = "cases/$id/" . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }
        Flash::success('Cases updated successfully.');

        return redirect(route('cases.index'));
    }

    /**
     * Remove the specified Cases from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $cases = $this->casesRepository->find($id);

        if (empty($cases)) {
            Flash::error('Cases not found');

            return redirect(route('cases.index'));
        }

        $this->casesRepository->delete($id);

        Flash::success('Cases deleted successfully.');

        return redirect(route('cases.index'));
    }

    public function downloadCasesZip($case_id)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $files_aws = Storage::disk('s3')->files("cases/$case_id/");
        $files_aws = array_reverse($files_aws);

        if (!empty($files_aws) && count($files_aws) > 0) {
            foreach ($files_aws as $aw) {
                $files[] = "$url$aw";
            }

            # create new zip object
            $zip = new ZipArchive();

            # create a temp file & open it
            $tmp_file = tempnam('.', '');
            $zip->open($tmp_file, ZipArchive::CREATE);

            # loop through each file
            foreach ($files as $file) {
                # download file
                $download_file = file_get_contents($file);

                #add it to the zip
                $zip->addFromString(basename($file), $download_file);
            }

            # close zip
            $zip->close();

            # send the file to the browser as a download
            header('Content-disposition: attachment; filename="CaseID-'.$case_id.'.zip"');
            header('Content-type: application/zip');
            readfile($tmp_file);
            unlink($tmp_file);
        } else {
            redirect()->back()->withErrors('No Files Found');
        }
    }

//==============New Development ================================

public function proffesional_cases(Request $request){

        $search = $request;
        // print_r($search->profession);exit;
        try {

            $cases = Cases::where([["load_type", "=", "Professional"]])
                      // ->select('id','first_name','last_name','mobile','status','address','updated_at','created_at','employment_type','occupation','loan_period','load_amount','total_loans','monthly_salary','client_income','cibil','highest_degree','past_loans','*.agents')
                      ->select('*')
                      ->with('agents')
                      ->when($search,function($query,$search){                    
                    if(!empty($search->location)) {                                       
                        $query->where('address', 'like','%'.$search->location.'%');
                    } 
                    if(!empty($search->profession)) {                                       
                        $query->where('occupation', 'like','%'.$search->profession.'%');
                    }
                    if(!empty($search->user_id)) {                                       
                       $query->where('created_by',$search->user_id);
                    } 
                    if(!empty($search->statusFilter)) {

                        $query->whereIn('disabled', $search->statusFilter);;
                    } 

                    if(!empty($search->from_date)) {                      
                      $query->whereDate('created_at','>=', $search->from_date);
                    } 
 //print_r($query);exit;
                    if(!empty($search->to_date)) {   
                       $query->whereDate('created_at','<=', $search->to_date);              
                    }                     
                    // print_r($query-all());exit;
                return $query;

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
            'agent_list' => array(),
            'filters' => $search->input()
        );

         
        // function action($id){
                  
        //     $address = route('agents.show', [$agent->id]);

        //     $address = route('Agent-Details'); 
        //    $view   = '<a href="'.$address.'">View</a>';            
       
        //     return $view;
        // }     
        if(!empty($cases)){
        foreach($cases as $key => $case){
           
            
            $data->case_list[] = array(
                 'action'           => '<a href="'.route('Case-Details', ['id=' .$case['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'case_id'         => $case['id'],
                 'name'             => $case['first_name'].' '.$case['last_name'],
                 'mobile'           => $case['mobile'],
                 // 'email'            => $case['email'],
                 'location'            => $case['address'],
                 'status'            => $case['case_status'],
                 'additional_status' => $case['status'],
                 'updated'      => \Carbon\Carbon::parse(@$case['updated_at'])->format('d M Y h:i:s'),
                 'cibil'      => $case['cibil'],
                 'user_name'      => '<a href="'.route('Agent-Details', ['id=' .$case['created_by']]).'" target="_blank" class="tooltips" >'.$case['agents']['name'].'<span class="tooltiptext">'.$case['agents']['name'].', </br>'.$case['agents']['mobile'].',</br> '.$case['agents']['email'].', </br>'.$case['agents']['location'].'</br></span></a>',


                 // 'case_in_system'      => 'Case In System',
                 'profession'            => $case['occupation'],
                 'create_date_time'            => \Carbon\Carbon::parse(@$case['created_at'])->format('d M Y h:i:s'),
                 'employee_type'            => $case['employment_type'],
                 'degree'            => $case['highest_degree'],
                 'lender'            => $case['loan_period'],
                 'desired_loan_amount'            => $case['load_amount'],
                 'past_loan'            => $case['past_loans'],
                //  'monthly_salary'            => $case['monthly_salary'],
                //  'annual_income'            => $case['client_income'],
                            
                );
        }   
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->case_list);
        $data->recordsFiltered = count($data->case_list);
        }
        else
        {
            $data->case_list[] = array(
                'action'           => '',
                 'case_id'         => '',
                 'name'             => '',
                 'mobile'           => '',
                 // 'email'            => $case['email'],
                 'location'            => '',
                 'status'            => '',
                 'additional_status' => '',
                 'updated'      => '',
                 'cibil'      => '',
                 'user_name'      => '',


                 // 'case_in_system'      => 'Case In System',
                 'profession'            => '',
                 'create_date_time'            => '',
                 'employee_type'            => '',
                 'degree'            => '',
                 'lender'            => '',
                 'desired_loan_amount'            => '',
                 'past_loan'            => '',
                //  'monthly_salary'            => $case['monthly_salary'],
                //  'annual_income'            => $case['client_income'],
            );
        }
        return Response::json($data);

    }

    public function personal_cases(Request $request){
    //echo "<pre>";print_r('vijay');exit;
        $search = $request;
        try {

            $cases = Cases::where([["load_type", "=", "Personal"]])
                // ->select('id','first_name','last_name','mobile','status','address','updated_at','created_at','employment_type','occupation','loan_period','load_amount','total_loans','monthly_salary','client_income','past_loans','cibil','highest_degree')
                ->select('*')
                ->with('agents')
                ->when($search,function($query,$search){                    
                    if(!empty($search->user_id)) {                                       
                        $query->where('created_by',$search->user_id);
                     } 
                     if(!empty($search->location)) {                                       
                        $query->where('address', 'like','%'.$search->location.'%');
                    } 
//                    if(!empty($search->agentFilter)) {                                       
//                       $query->whereIn('id', $search->agentFilter);
//                    } 
//                    if(!empty($search->statusFilter)) {

//                        $query->whereIn('disabled', $search->statusFilter);;
//                    } 

//                    if(!empty($search->yearFilter)) {                      
//                      $query->whereDate('created_at','>=', $search->yearFilter);
//                    } 
//                     //print_r($query);exit;
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
            'agent_list' => array(),
            'filters' => $search->input()
        );

         
        function action($id){
                  
            //$address = route('agents.show', [$agent->id]);

            //$address = route('Agent-Details'); 
           // $view   = '<a href="'.$address.'">View</a>';            
       
            return $view;
        }     
    if(!empty($cases))
    {
        foreach($cases as $key => $case){
           //echo "<pre>";print_r($case);exit;
            
            $data->personal_list[] = array(
                 'action'           => '<a href="'.route('Case-Details', ['id=' .$case['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'case_id'         => $case['id'],
                 'name'             => $case['first_name'].' '.$case['last_name'],
                 'mobile'           => $case['mobile'],
                 // 'email'            => $case['email'],
                 'location'            => $case['address'],
                 'status'            => $case['case_status'],
                 'additional_status' => $case['status'],
                 'updated'      => \Carbon\Carbon::parse(@$case['updated_at'])->format('d M Y h:i:s'),
                //  'cibil'      => $case['cibil'],
                 'user_name'      => '<a href="'.route('Agent-Details', ['id=' .$case['created_by']]).'" target="_blank">'.$case['agents']['name'].'</a>',
                 // 'case_in_system'      => 'Case In System',
                //  'profession'            => $case['occupation'],
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
    }
    else
    {
        $data->case_list[] = array(
            'action'           => '',
                 'case_id'         => '',
                 'name'             => '',
                 'mobile'           => '',
                 // 'email'            => $case['email'],
                 'location'            => '',
                 'status'            => '',
                 'additional_status' => '',
                 'updated'      => '',
                //  'cibil'      => $case['cibil'],
                 'user_name'      => '',
                 // 'case_in_system'      => 'Case In System',
                //  'profession'            => $case['occupation'],
                 'create_date_time'            => '',
                  'employee_type'            => '',
                 // 'degree'            => $case['highest_degree'],
                 'lender'            => '',
                 'desired_loan_amount'            => '',
                 'past_loan'            => '',
                 'monthly_salary'            => '',
                 // 'annual_income'            => $case['client_income'],
        );
    }

        return Response::json($data);

    }


    public function bussiness_cases(Request $request){
    //echo "<pre>";print_r('vijay');exit;
        $search = $request;
        try {

            $cases = Cases::where([["load_type", "=", "Business"]])
                // ->select('id','first_name','last_name','mobile','status','address','updated_at','created_at','employment_type','occupation','loan_period','load_amount','total_loans','monthly_salary','client_income','cibil','highest_degree','past_loans')
                ->select('*')
                ->with('agents')
                ->when($search,function($query,$search){                    
                    if(!empty($search->user_id)) {                                       
                        $query->where('created_by',$search->user_id);
                     } 
                     if(!empty($search->location)) {                                       
                        $query->where('address', 'like','%'.$search->location.'%');
                    } 
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
            'agent_list' => array(),
            'filters' => $search->input()
        );

         
        function action($id){
                  
            //$address = route('agents.show', [$agent->id]);

            //$address = route('Agent-Details'); 
           // $view   = '<a href="'.$address.'">View</a>';            
       
            return $view;
        }     
        if(!empty($cases))
        {
        foreach($cases as $key => $case){
           //echo "<pre>";print_r($case);exit;
            
            $data->business_list[] = array(
                 'action'           => '<a href="'.route('Case-Details', ['id=' .$case['id']]).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>',
                 'case_id'         => $case['id'],
                 'name'             => $case['first_name'].' '.$case['last_name'],
                 'mobile'           => $case['mobile'],
                 // 'email'            => $case['email'],
                //  'location'            => $case['address'],
                 'status'            => $case['status'],
                 'updated'      => \Carbon\Carbon::parse(@$case['updated_at'])->format('d M Y'),
                 'cibil'      => $case['cibil'],
                 'user_name'      => '<a href="'.route('Agent-Details', ['id=' .$case['created_by']]).'" target="_blank">'.$case['agents']['name'].'</a>',
                 // 'case_in_system'      => 'Case In System',
                 'profession'            => $case['occupation'],
                 'create_date_time'            => \Carbon\Carbon::parse(@$case['created_at'])->format('d M Y h:i:s'),
                //  'employee_type'            => $case['employment_type'],
                 'degree'            => $case['highest_degree'],
                 
                 'past_loan'            => $case['past_loans'],
                 'tenure'            => $case['loan_period'],
                 'desired_loan_amount'            => $case['load_amount'],
                 
                 'monthly_salary'            => $case['monthly_salary'],
                 'annual_income'            => $case['client_income'],
                            
                );
        }   
        }
        else
        {
            $data->business_list[] = array(
                'action'           => '',
                'case_id'         => '',
                'name'             => '',
                'mobile'           => '',
                // 'email'            => $case['email'],
               //  'location'            => $case['address'],
                'status'            => '',
                'updated'      => '',
                'cibil'      => '',
                'user_name'      => '',
                // 'case_in_system'      => 'Case In System',
                'profession'            => '',
                'create_date_time'            => '',
               //  'employee_type'            => $case['employment_type'],
                'degree'            => '',
                
                'past_loan'            => '',
                'tenure'            => '',
                'desired_loan_amount'            => '',
                
                'monthly_salary'            => '',
                'annual_income'            => '',
                           
               );
        }
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->business_list);
        $data->recordsFiltered = count($data->business_list);

        return Response::json($data);

    }

    public function case_details($id=null, Request $request)
    {
        $user  = Auth::user();  

        $cases = $this->casesRepository->find($request->id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        
        $transaction = DB::table('agent_transaction')
                    ->where('agent_id', $request->id)
                    ->get()->toArray();
        $agent_details = DB::table('users')
                    ->where('id', $cases->created_by)
                    ->get()->first();

        $resi_status = DB::table('residential_statuses')
                    ->get()->toArray();
        $eligibility_data = DB::table('case_eligibility_status')
                    ->where('case_id', $request->id)
                    ->get()->first();
        $final_bank_approval = DB::table('case_final_bank_approval')
                    ->where('case_id', $request->id)
                    ->get()->first();
        $policy_details = DB::table('case_policy_details')
                    ->where('case_id', $request->id)
                    ->get()->first();
       
        $aadhar_card ='';
        $address_proof ='';
        $salary_doc ='';
        $statements_doc ='';

        $documents = DB::table('documents')
                    ->where('cases_id', $request->id)
                    ->get()->toArray();


        $document_type = DB::table('upload_document_type')
                    ->where('case_id', $request->id)
                    ->get()->toArray();


        $empoyeement_type = DB::table('employeement_type')
                    ->get()->toArray();
        $ownership_status = DB::table('business_premise_owner_status')
                    ->get()->toArray();
        $industry = DB::table('industries')->get()->toArray();

        $loan_purpose = DB::table('loan_purpose')->get()->toArray();

        $organistion_type = DB::table('organistion_type')->get()->toArray();

        $mode_of_salaries = DB::table('mode_of_salaries')->get()->toArray();

        $loans_products = DB::table('loans_products')->get()->toArray();

        $income_methods = DB::table('income_methods')->get()->toArray();

        $primary_accounts = DB::table('primary_accounts')->get()->toArray();

        $case_status = DB::table('case_status')->where(['is_active' => 1])->get()->toArray();

        $case_actions = DB::table('case_actions')->get()->toArray();

        $loan_types = DB::table('loan_type')->get()->toArray();

        $comments = DB::table('comments')
                    ->where('case_id', $request->id)
                    ->get()->toArray();

        //echo "<pre>";  print_r($comments);exit;
       
        //echo "<pre>"; print_r($eligibility_data);exit;
        //return view('agents.details', compact('agents','transaction','files','url','documents'));
        return view('cases.case_details', compact('cases','case_status','transaction','resi_status','eligibility_data','final_bank_approval','policy_details','aadhar_card','address_proof','salary_doc','statements_doc','empoyeement_type','ownership_status','document_type','documents','industry','loan_purpose','organistion_type','mode_of_salaries','loans_products','comments','income_methods','primary_accounts','case_actions','agent_details','loan_types','url'));
    }

    public function case_comments(Request $request)
    {
       //echo "<pre>"; print_r($request->all());exit;
        $user  = Auth::user(); 
        $cases = Cases::find($request->case_id);

        if (empty($cases)) {
            $values['msg'] = 'Customer Not Found!';
            $values['message'] = 'fail';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
        }       

        $request->user_id = $user->id;
        $comments = Comments::create(['user_id' => $user->id, 'case_id' => $request->case_id, 'user_comments' => $request->user_comments]);
        if($comments){
            $values['msg'] = 'Comment Sent successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Comment Not Sent!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit;
    }

    public function case_update_new(Request $request)
    {
       //echo "<pre>"; print_r($request->all());exit;
        $cases = Cases::find($request->id);
        
        if (empty($cases)) {
            $values['msg'] = 'Customer Not Found!';
            $values['message'] = 'fail';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
        }
        //$cases = $cases->update($request->all());


        if($cases->update($request->all())){
            $values['msg'] = 'Customer Details Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Customer Details Status Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit;
    }

    public function case_update_eligibility(Request $request)
    {   

        //echo "<pre>"; print_r($request->all());exit;
        $cases = Cases::find($request->case_id);

        if (empty($cases)) {
            $values['msg'] = 'Customer Not Found!';
            $values['message'] = 'fail';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
        }
        //$cases = $cases->update($request->all());
        //$request->status_date = date("Y-m-d");
        //echo '<pre>';print_r($request->all());exit; 

        if($cases->update($request->all())){
            $values['msg'] = 'Status Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Status Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit;
    
     }

      public function Case_Final_Bank_Approval(Request $request)
     {   
        $cases = Cases::find($request->case_id);

        if (empty($cases)) {
            $values['msg'] = 'Customer Not Found!';
            $values['message'] = 'fail';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
        }
        //$cases = $cases->update($request->all());


        if($cases->update($request->all())){
            $values['msg'] = 'Status Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Status Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit;
        
        //  $bank_approval = DB::table('case_final_bank_approval')
        //              ->where('case_id', $request->case_id)
        //              ->get()->first();
        //  //
       
        //  if (empty($bank_approval)) {
        //       $input = $request->all();
        //    if(CaseFinalBankApproval::create($input)){
        //        $values['msg'] = 'Final Loan Approval Saved successfully!';
        //          $values['message'] = 'success';
        //      }else{
        //          $values['msg'] = 'Final Loan Approval Not Saved!';
        //          $values['message'] = 'fail';

        //      }
        //      $successresult = json_encode($values);
        //      echo $successresult;
        //      exit;
        //  }       
      
        // $update = DB::table('case_final_bank_approval')
        //          ->where('case_id', $request->case_id)  // find your user by their email
        //          ->limit(1)  // optional - to ensure only one record is updated.
        //          ->update(array('loan_amount' => $request->loan_amount,'interest_rate' => $request->interest_rate,'tenure' => $request->tenure,'processing_fees' => $request->processing_fees));  // update the record in the DB.
      
        //  if($update){
        //      $values['msg'] = 'Final Loan Approval Updated successfully!';
        //      $values['message'] = 'success';
            
        //  }else{
        //      $values['msg'] = 'Final Loan Approval Not Updated!';
        //      $values['message'] = 'fail';
        //  }
        //  $successresult = json_encode($values);
        //  echo $successresult;
        //  exit;
    }

     public function Case_Privacy_Policy(Request $request)
    {   
        $case_policy_details = DB::table('case_policy_details')
                    ->where('case_id', $request->case_id)
                    ->get()->first();
     
       
        if (empty($case_policy_details)) {
             $input = $request->all();

           if(CasePolicyDetails::create($input)){
                $values['msg'] = 'Privacy Policy Saved successfully!';
                $values['message'] = 'success';
            }else{
                $values['msg'] = 'Privacy Policy Not Saved!';
                $values['message'] = 'fail';

            }
            $successresult = json_encode($values);
            echo $successresult;
            exit;
        }       
      
        $update = DB::table('case_policy_details')
                ->where('case_id', $request->case_id)  // find your user by their email
                ->limit(1)  // optional - to ensure only one record is updated.
                ->update(array('login_loan_amount' => $request->login_loan_amount,
                                'login_tenure' => $request->login_tenure,
                                'login_interest_rate' => $request->login_interest_rate,
                                'login_processing_fees' => $request->login_processing_fees,
                                'login_insurance_fees' => $request->login_insurance_fees,
                                'login_admin_other_fees' => $request->login_admin_other_fees,
                                'login_selected_lender' => $request->login_selected_lender,
                                'login_lender_name' => $request->login_lender_name,
                                'login_policy_number' => $request->login_policy_number,
                                'login_policy_name' => $request->login_policy_name,
                                'login_program_type' => $request->login_program_type,
                                'approval_loan_amount' => $request->approval_loan_amount,
                                'approval_tenure' => $request->approval_tenure,
                                'approval_interest_rate' => $request->approval_interest_rate,
                                'approval_processing_fees' => $request->approval_processing_fees,
                                'approval_admin_other_fees' => $request->approval_admin_other_fees,
                                'approval_selected_lender' => $request->approval_selected_lender,
                                'approval_lender_name' => $request->approval_lender_name,
                                'approval_policy_name' => $request->approval_policy_name,
                                'approval_policy_number' => $request->approval_policy_number,
                                'approval_program_type' => $request->approval_program_type,
                                'approval_insurance_fees' => $request->approval_insurance_fees,
                            )); 
      
        if($update){
            $values['msg'] = 'Privacy Policy Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Privacy Policy Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit;
    }


     public function Case_Document_type(Request $request)
    {   
        $document_data = DB::table('upload_document_type')
                    ->where('id', $request->id)
                    ->get()->first();        
      
        if (empty($document_data)) {
            $data = $request->input();
            if(!empty($data['status'])){
                $status= 'Yes';
            }else{
                $status= 'No';
            }
           // print_r($data);exit;
            $document_types = new UploadDocumentType();
            $document_types->status = $status;
            $document_types->comments = $data['comments'];
            $document_types->document_type = $data['document_type'].' - A';
            $document_types->case_id = $data['case_id'];
            $document_types->save(); 
          
            $values['msg'] = 'Document Type Saved successfully!';
            $values['message'] = 'success';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
            }  
 
       foreach ($request->id as $key => $value) 
        {    
             $update = DB::table('upload_document_type')
             ->where('id',$value)
             ->update([
                 'comments'=>$request->comments[$key]
             ]);
        } 
      
        if($update){
           
            $values['msg'] = 'Document Type Updated successfully!';
            $values['message'] = 'success';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
            
        }else{
             $values['msg'] = 'Document Type Not Updated!';
            $values['message'] = 'fail';
            $successresult = json_encode($values);
            echo $successresult;
            exit;
        }
        
    }

    public function caseStatusDocument(Request $request){
        $input = $request->all();
        $update = DB::table('upload_document_type')
                ->where('id', $request->id)
                ->update(array('status' => $request->status)); 
        if($update){
            $values['msg'] = 'Document Status Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Document Status Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }

    public function caseFlagDocument(Request $request){
        $input = $request->all();
        //print_r($input);exit;
        $update = DB::table('documents')
                ->where('id', $request->id)
                ->update(array('flag' => $request->status)); 
        if($update){
            $values['msg'] = 'Document Flag Updated successfully!';
            $values['message'] = 'success';
            
        }else{
            $values['msg'] = 'Document Flag Not Updated!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }


}
