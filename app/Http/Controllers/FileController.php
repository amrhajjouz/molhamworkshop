<?php

namespace App\Http\Controllers;

use App\Facades\Files;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\File\{CreateRequest, UpdateRequest};
use App\Jobs\ImportDriveFile;
use App\Common\Base\BaseController;

class FileController extends BaseController
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

                return $this->_response(true);
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
