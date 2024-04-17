<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AppBaseController;
use App\Models\UploadDocumentType;
use App\Models\Documents;
use App\Models\Cases;
use App\Repositories\CasesRepository;

class FileHandlerController extends AppBaseController
{
    public function uploadFile (Request $request)
    {
        Log::info("Called " . __FUNCTION__ . " ", [$request] );
        try {
            $fileData = $request->file("attachment");
            if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
                return response()->json([
                    "error" => 1,
                    "message" => "Unauthorized.",
                    "show_message" => true
                ], 401);
            }
            if (!$request->hasFile("attachment")) {
                return response()->json(
                    [
                        "error" => 1,
                        "message" => "Attachment not found",
                        "show_message" => true
                    ]
                );
            }
            $filePath = "registered_users/documents";
            $disk = Storage::disk("s3");
            //$storage = $disk->put($filePath, $fileData, 'private');
            $storage = $disk->put($filePath, $fileData, array('ACL'=> 'public-read'));
            $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                'Bucket'                     => env("AWS_BUCKET"),
                'Key'                        => $storage,
                //'ResponseContentDisposition' => 'attachment;'//for download
            ]);
            $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+10 minutes');
            //$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+15 seconds');

            $generate_url = $request->getUri();
            return response()->json([
                "error" => 0,
                "message" => "File uploaded successfully.",
                "show_message" => false,
                "data" => [
                    "file" => $storage,
                    "public_path" =>  $generate_url->__toString()
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }

    }

    public function uploadFileNew(Request $request)
    {
        Log::info("Called " . __FUNCTION__ . " ", [$request] );
        try {
            $fileData = $request->file("attachment");
            if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
                return response()->json([
                    "error" => 1,
                    "message" => "Unauthorized.",
                    "show_message" => true
                ], 401);
            }
            // if (!$user = JWTAuth::parseToken()->authenticate()) {
            //     return response()->json([
            //         "error" => 1,
            //         "message" => "User Unauthorized",
            //         "show_message" => true
            //     ], 401);
            // }
            if($request->user_id){

                if (!$request->hasFile("attachment")) {
                    return response()->json(
                        [
                            "error" => 1,
                            "message" => "Attachment not found",
                            "show_message" => true
                        ]
                    ); 
                }
                $filePath = "agents/$request->user_id/";
                $disk = Storage::disk("s3");
                $storage = $disk->put($filePath, $fileData, array('ACL'=> 'public-read'));
                //$storage = $disk->put($filePath, $fileData, 'private');
                $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                    'Bucket'                     => env("AWS_BUCKET"),
                    'Key'                        => $storage,
                    //'ResponseContentDisposition' => 'attachment;'//for download
                ]);
                $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+5 minutes');
                //$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+15 seconds');

                $generate_url = $request->getUri();
                return response()->json([
                    "error" => 0,
                    "message" => "File uploaded successfully.",
                    "show_message" => false,
                    "data" => [
                        "file" => $storage,
                        "public_path" =>  $generate_url->__toString()
                    ]
                ]);

            }
            
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }

    }

    public function uploadDocuments(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        Log::info("Called " . __FUNCTION__ . " ", [$request]);
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Unauthorized",
                    "show_message" => true
                ], 401);
            }
            if (!$request->hasFile("attachment")) {
                return response()->json(
                    [
                        "error" => 1,
                        "message" => "Attachment not found",
                        "show_message" => true
                    ]
                );
            }
            $fileData = $request->file("attachment");
            $filePath = "registered_users/documents/cases/". $request->case_id;
            $disk = Storage::disk("s3");
            //$storage = $disk->put($filePath, $fileData, 'private');
            $storage = $disk->put($filePath, $fileData, array('ACL'=> 'public-read'));
            $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                'Bucket'                     => env("AWS_BUCKET"),
                'Key'                        => $storage,
                //'ResponseContentDisposition' => 'attachment;'//for download
            ]);
            $awsrequest = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+10 minutes');
            //$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+15 seconds');
            $generate_url = $awsrequest->getUri();
            Log::info('file url', [$generate_url->__toString()]);
            try {
                $documents = new Documents();
                $documents->document_url = $generate_url->__toString();
                $documents->document_type = $request->type;
                $documents->agent_id = $user->id;
                $documents->cases_id = $request->case_id;
                $documents->name = $fileData->getClientOriginalName();
                $documents->save();
            } catch (\Exception $e) {
                Log::error('Message', [$e]);
            }

            return response()->json([
                "error" => 0,
                "message" => "File uploaded successfully.",
                "show_message" => false,
                "data" => [
                    "file" => $storage,
                    "public_path" =>  $generate_url->__toString(),
                    "file_name" => $fileData->getClientOriginalName(),
                    "name" => $fileData->getClientOriginalName(),
                    "id" => $documents->id
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function uploadDocumentsNew(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        //Log::info("Called " . __FUNCTION__ . " ", [$request]);
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Unauthorized",
                    "show_message" => true
                ], 401);
            }
            if (!$request->hasFile("attachment")) {
                return response()->json(
                    [
                        "error" => 1,
                        "message" => "Attachment not found",
                        "show_message" => true
                    ]
                );
            }
            //print_r($request->all());exit;
            $fileData = $request->file("attachment");
            $filePath = "cases/$request->case_id";
            //$filePath = "registered_users/documents/cases/". $request->case_id;
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
            //print_r($storage);exit;
            $generate_url = $awsrequest->getUri();
            //Log::info('file url', [$generate_url->__toString()]);
            try {
                $documents = new Documents();
                $documents->document_url = $storage;
                $documents->document_type = $request->type;
                $documents->agent_id = $user->id;
                $documents->cases_id = $request->case_id;
                $documents->name = $fileData->getClientOriginalName();
                $documents->save();


                // $document_types = new UploadDocumentType();
                // $document_types->status = "Yes";
                // $document_types->comments = "You Can Upload Document";
                // $document_types->document_type = $request->type;
                // $document_types->case_id = $request->case_id;
                // $document_types->save();     


                $cases = $this->casesRepository->find($request->case_id);
                $cases->case_status = "New - Submit Application";
				//$cases->status = "Not Selected";
                $cases->save();
            } catch (\Exception $e) {
                Log::error('Message', [$e]);
            }

            return response()->json([
                "error" => 0,
                "message" => "File uploaded successfully.",
                "show_message" => false,
                "data" => [
                    "file" => $storage,
                    "public_path" =>  $generate_url->__toString(),
                    "file_name" => $fileData->getClientOriginalName(),
                    "name" => $fileData->getClientOriginalName(),
                    "id" => $documents->id
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function uploadDocuments_old(Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        Log::info("Called " . __FUNCTION__ . " ", [$request]);
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Unauthorized",
                    "show_message" => true
                ], 401);
            }
            if (!$request->hasFile("attachment")) {
                return response()->json(
                    [
                        "error" => 1,
                        "message" => "Attachment not found",
                        "show_message" => true
                    ]
                );
            }
            $fileData = $request->file('attachment');
            $name = time() . $fileData->getClientOriginalName();
            $filePath = "cases/$request->case_id/" . $name;
            $disk = Storage::disk("s3");
            $storage = $disk->put($filePath, file_get_contents($fileData));
//            Storage::disk('s3')->put($filePath, file_get_contents($file));

//            $fileData = $request->file("attachment");
//            $filePath = "registered_users/documents/cases/". $request->case_id;
//            $disk = Storage::disk("s3");
//            $storage = $disk->put($filePath, $fileData, 'private');
            $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                'Bucket'                     => env("AWS_BUCKET"),
                'Key'                        => $storage,
                //'ResponseContentDisposition' => 'attachment;'//for download
            ]);
            $awsrequest = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+10 minutes');
            //$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+15 seconds');
            $generate_url = $awsrequest->getUri();
            Log::info('file url', [$generate_url->__toString()]);
            try {
                $documents = new Documents();
                $documents->document_url = $generate_url->__toString();
                $documents->document_type = $request->type;
                $documents->agent_id = $user->id;
                $documents->cases_id = $request->case_id;
                $documents->name = $name;//$fileData->getClientOriginalName();
                $documents->save();
            } catch (\Exception $e) {
                Log::error('Message', [$e]);
            }

            return response()->json([
                "error" => 0,
                "message" => "File uploaded successfully.",
                "show_message" => false,
                "data" => [
                    "file" => $storage,
                    "public_path" =>  $generate_url->__toString(),
                    "file_name" => $fileData->getClientOriginalName(),
                    "name" => $fileData->getClientOriginalName(),
                    "id" => $documents->id
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => 1,
                "message" => "Error Occurred: " . $e->getMessage(),
                "show_message" => true
            ]);
        }
    }

    public function deleteDocument ($id, Request $request)
    {
        if ($request->header("verify-myself") != env("API_VERIFY_TOKEN")) {
            return response()->json([
                "error" => 1,
                "message" => "Unauthorized.",
                "show_message" => true
            ], 401);
        }
        Log::info("Called " . __FUNCTION__ . " ", [$request]);
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    "error" => 1,
                    "message" => "User Unauthorized",
                    "show_message" => true
                ], 401);
            }
            $documents = Documents::find($id);
            if (!isset($documents) && !isset($documents->id)) {
                return response()->json([
                    "error" => 1,
                    "message" => "Document not found",
                    "show_message" => true
                ]);
            } else {
                $documents->delete();
                return response()->json([
                    "error" => 0,
                    "message" => "Document deleted successfully",
                    "show_message" => true
                ]);
            }

        } catch (\Exception $e) {

        }
    }
}
