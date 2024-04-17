<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\NotificationsRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateNotificationsRequest;
use App\Http\Requests\UpdateNotificationsRequest;
use App\Models\Notifications;
use App\Models\User;
use App\Models\Cases;
use App\Models\Agents as UserAgents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Arr;

class NotificationsController extends AppBaseController
{
    /** @var  NotificationsRepository */
    private $notificationsRepository;

    public function __construct(NotificationsRepository $notificationsRepo)
    {
        $this->notificationsRepository = $notificationsRepo;
    }

    /**
     * Display a listing of the Products.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {   
        $agents = UserAgents::where([["user_type", "=", "agent"]])->get();  
        return view('notifications.global_notification')->with('agents', $agents);
    }

    public function list(Request $request){
       
        try {

            $notifications = Notifications::whereNotNull("notifications")->orderBy('id', 'DESC')->get()->toArray();
                    
        } catch (\Throwable $th) {
        
            dd($th);
        }
       

        $data = (object) array(
            'draw'            => 1,
            'recordsTotal'    => 0,
            'recordsFiltered' => 0,
            'notification_list' => array()
        );         
           

        foreach($notifications as $key => $notification){
            $agent_id = explode(',',$notification['agent_id']);
            $agent_name = array();
            //print_r($agent_id);
            foreach ($agent_id as $key => $value) {
               $agents = UserAgents::where('id',$value)->first();  

               $agent_name[] = $agents['name'];            
            }
            $agents = implode(',', $agent_name);
            $data->notification_list[] = array(                 
                 'notifications'             => $notification['notifications'],
                 'loan'             => $notification['loan'],
                 'case_registered'             => $notification['case_registered'],
                 'agents'             => $agents
                );
        }   
       
        //echo '<pre>';print_r($data);exit; 
        $data->recordsTotal = count($data->notification_list);
        $data->recordsFiltered = count($data->notification_list);

        return Response::json($data);

    }

    public function store(Request $request){
        $input = $request->all();
       //echo "<pre>"; print_r($input);exit;
        if(!empty($request->agent_id)){
            $agent_id = implode(',', $request->agent_id);
            $input['agent_id'] = $agent_id;
        }
        
        if($record = $this->notificationsRepository->create($input)){                       
            
            $notifications = $record->notifications;
            $agents = $record->agent_id;
            $loans = $record->loan;
            $case_registered = $record->case_registered;

            $values['msg'] = 'Notification Sent successfully!';
            $values['message'] = 'success';
            $this->sendNotification($notifications,$agents,$loans,$case_registered);

            
            
        }else{
            $values['msg'] = 'Notification Not Sent!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }

    //======================Push Notiication===================================       
   

    public function sendNotification($notifications=null,$agents=null,$loans=null,$case_registered=null)
    {

        if(empty($agents) && empty($loans) && empty($case_registered)){
            $firebaseToken = User::whereNotNull('firebase_token')->pluck('firebase_token')->all();
        }        

        if(!empty($agents)){
            $firebaseToken = User::whereIn('id',array($agents))->whereNotNull('firebase_token')->pluck('firebase_token')->all();
        }

        if(!empty($loans)){
            //echo "<pre>";print_r($loans);exit;
            if($loans == '0-50'){
                $cases = Cases::select('created_by')->whereBetween('load_amount', ['0', '5000000'])->get()->toArray();
            }
            if($loans == '50-75'){
                $cases = Cases::select('created_by')->whereBetween('load_amount', ['5000000', '7500000'])->get()->toArray();
            }
            if($loans == '75-1'){
                $cases = Cases::select('created_by')->whereBetween('load_amount', ['7500000', '10000000'])->get()->toArray();
            }
            if($loans == '1+'){
                $cases = Cases::select('created_by')->where('load_amount','>','10000000')->get()->toArray();
            } 
            $agent_id = array();
            foreach ($cases as $key => $value) {
                $agent_id[] = $value['created_by'];
            }
            $unique_agent_id = array_unique($agent_id);

            
            $firebaseToken = User::whereIn('id',array($unique_agent_id))->whereNotNull('firebase_token')->pluck('firebase_token')->all();
        }

        if(!empty($case_registered)){

            $month_case_registered = Cases::select('created_by')->whereMonth('created_at', Carbon::now()->month)->get()->toArray();
            $agent_id = array();
            foreach ($month_case_registered as $key => $value) {
                $agent_id[] = $value['created_by'];
            }
            //$unique_agent_id = array_unique($agent_id);
            $vals = array_count_values($agent_id);
            $final_agent_id = array();
            foreach ($vals as $key => $value) {
                if($value < '5'){
                    $final_agent_id[]=$key;
                }
                if(($value > '5') && ($value < '10')){
                    $final_agent_id[]=$key;
                }
                if($value > '10'){
                    $final_agent_id[]=$key;
                }
            }             
            $firebaseToken = User::whereIn('id',array($final_agent_id))->whereNotNull('firebase_token')->pluck('firebase_token')->all();
        }        

        $SERVER_API_KEY = 'AAAA2x1UOoA:APA91bGKg4o2INoDLDYs3EVGoZt6qP_J4VI-cOS7jvJ2dBuWgoSlMm1tWvNbr-4dJz0GQtfCbiOpyullAXYWQikjd3Xrfb9ZSHWg6nP99PPJYBzW0DDwaJxoJMj5PNcDHek5kDWDmmCb';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Push Notification',
                "body" => $notifications,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);
    }
    
}
