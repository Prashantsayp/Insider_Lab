<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\MediaNotificationsRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateMediaNotificationsRequest;
use App\Http\Requests\UpdateMediaNotificationsRequest;
use App\Models\MediaNotifications;
use App\Models\Documents;
use App\Models\User;
use App\Models\Cases;
use App\Models\Agents as UserAgents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Arr;


class MediaNotificationsController extends AppBaseController
{
    /** @var  NotificationsRepository */
    private $medianotificationsRepository;

    public function __construct(MediaNotificationsRepository $medianotificationsRepo)
    {
        $this->medianotificationsRepository = $medianotificationsRepo;
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
        return view('notifications.global_media');
    }

    public function list(Request $request){
       
        try {

            $notifications = MediaNotifications::where('deleted','=','No')->orderBy('id', 'DESC')->get()->toArray();
                    
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

            $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
            $files = Storage::disk('s3')->files("notifiaction_media/".$notification['id']);
            $files = array_reverse($files);
            if(!empty($files)){
                $media = '<a target="_blank" href="'.$url.$files[0].'"><img src="'.$url.$files[0].'" alt="Global Media" width="100" height="50"></a>';
            }else{
                 $media = 'Not Available';
            }           
            
            $data->notification_list[] = array(                 
                 'notifications'     => $media,
                 'notes'             => sprintf($notification['notes']),
                 'text'             => $notification['text_link'],
                 'tag'             => $notification['tag'],
                 'send'             => $notification['send'],
                 'status'             => $notification['active'],
                 'action'           => '<a data-attr="'.$notification['id'].'" data-toggle="modal" id="delete-model"><i class="fa fa-trash" aria-hidden="true" style="color: red;font-size:x-large"></i></a><a data-attr="'.$notification['id'].'" status="'.$notification['active'].'" data-toggle="modal" id="disabled-model" style="font-size:x-large"><i class="fa fa-ban" aria-hidden="true"></i></a>',
                );
        }   
       
       
        $data->recordsTotal = count($data->notification_list);
        $data->recordsFiltered = count($data->notification_list);

        return Response::json($data);

    }

    public function store(Request $request){
        $input = $request->all();
       //echo "<pre>"; print_r($input);exit;
      

        if($records = $this->medianotificationsRepository->create($input)){
            if(!empty($records->media)){
                $fileData = $request->file("media");
                $filePath = "notifiaction_media/$records->id";
                $disk = Storage::disk("s3");
                //$storage = $disk->put($filePath, $fileData, 'public');
                $storage = $disk->put($filePath, $fileData, array('ACL'=> 'public-read'));
                $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                    'Bucket'                     => env("AWS_BUCKET"),
                    'Key'                        => $storage,
                    //'ResponseContentDisposition' => 'attachment;'//for download
                ]);
                $awsrequest = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+10 minutes');
                //$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+15 seconds');
                $generate_url = $awsrequest->getUri();
            }
            $text_link = $records->text_link;
            $notes = $records->notes;
            $tag = $records->tag;
            $send = $records->send;
            $values['msg'] = 'Media Notification Sent successfully!';
            $values['message'] = 'success';
            $this->sendMediaNotification($text_link,$notes,$tag,$send);
            
            
        }else{
            $values['msg'] = 'Media Notification Not Sent!';
            $values['message'] = 'fail';
        }
        $successresult = json_encode($values);
        echo $successresult;
        exit; 
    }

    public function destroy(Request $request)
    {
     
      $id= $request->id;      
      $notifications = MediaNotifications::find($id); 
      $notifications->deleted = 'Yes';
      if($notifications->save()){            
            return back()->with('success','Media Notification Deleted successfully!');
      }else{
            return redirect()->route('Notifications-Media')->with('error','Media Notification Not Deleted Successfully!');
      }
        //return Response()->json($bank_details);
    }
    public function disabled(Request $request)
    {
     
      $id= $request->id;      
      $notifications = MediaNotifications::find($id); 

      if($request->active = 'No'){
            $notifications->active = 'Yes';
      }
      if($request->active = 'Yes'){
           $notifications->active = 'No';
      }
      
      if($notifications->save()){            
            return back()->with('success','Media Notification Disabled successfully!');
      }else{
            return redirect()->route('Notifications-Media')->with('error','Media Notification Not Disabled Successfully!');
      }
        //return Response()->json($bank_details);
    }

    //======================Push Notiication===================================        
    

    public function sendMediaNotification($text_link=null,$notes=null,$tag=null,$send=null)
    {
        if($send == 'Yes'){

            $firebaseToken = User::whereNotNull('firebase_token')->pluck('firebase_token')->all();

            $SERVER_API_KEY = 'AAAA2x1UOoA:APA91bGKg4o2INoDLDYs3EVGoZt6qP_J4VI-cOS7jvJ2dBuWgoSlMm1tWvNbr-4dJz0GQtfCbiOpyullAXYWQikjd3Xrfb9ZSHWg6nP99PPJYBzW0DDwaJxoJMj5PNcDHek5kDWDmmCb';
      
            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => 'Media Notification',
                    "body" => $notes.' / '.$text_link.' / '.$tag,  
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
      
            //dd($response);
            $values['msg'] = 'Media Notification Sent successfully!';
            $values['message'] = 'success';
            $successresult = json_encode($values);
            echo $successresult;
            exit;

        }
        
    }
    
}
