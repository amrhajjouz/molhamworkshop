<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\{CreateRequest};
use App\Jobs\ImportDriveFile;

class FileController extends Controller
{

    /* 
     * @source determine upload type , if null that mean upload way is direct upload from computer 
    */
    public function create(CreateRequest $request)
    {
        $data = $request->validated();
        $source = $data['source']; 
        if (!$source) {
            $source = 'upload';
        }


        switch ($source) {
            case 'googleDrive':
                /* 
                 * dispatch job to continue importing method and pass required data  
                */

                 ImportDriveFile::dispatch([
                    'attachments' => $data['attachments'],
                    'access_token' => $data['accessToken'],
                    'fileable_type' => $data['fileable_type'],
                    'fileable_id' => $data['fileable_id'],
                ]);

                return response()->json(['status'=> true]);
                break;

            default:
                # code...
                break;
        }


        dd($request->all(), $data);
        //ToDo
        // 1-check if request has access token
        // 2-check if request type is drive
        // if($request->has('type') && $request->type == 'drive'){
        // Files::save_drive_files($request);
        // }

    }
}
