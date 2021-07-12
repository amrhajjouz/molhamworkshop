<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\{CreateRequest};
use App\Jobs\{ImportDriveFile, importTrelloFiles};

class FileController extends Controller
{

    /* 
     * @source determine upload type , if null that mean upload way is direct upload from computer 
     * anailavle source until now are : trello && googleDrive
    */
    public function create(CreateRequest $request)
    {
        /*
        * take validated date and save in $data variable
        */
        $data = $request->validated();

        $source = $data['source'];
        
        if (!$source) $source = 'upload';

        switch ($source) {
            case 'googleDrive':

                /* 
                 * dispatch job to continue importing method and pass required data to job
                */
                ImportDriveFile::dispatch([
                    'attachments' => $data['attachments'],
                    'access_token' => $data['accessToken'],
                    'fileable_type' => $data['fileable_type'],
                    'fileable_id' => $data['fileable_id'],
                ]);
                return response()->json(['status' => true]);
                break;
                /* 
                 * dispatch job to continue importing files from Trello and pass required data to job
                */
            case "trello":
                importTrelloFiles::dispatch([
                    'attachments' => $data['attachments'],
                    'access_token' => $data['accessToken'],
                    'fileable_type' => $data['fileable_type'],
                    'fileable_id' => $data['fileable_id'],
                ]);
                break;
            default:
            return response()->json(['msg'=> 'upload method does not exists']);
                break;
        }
    }
}
