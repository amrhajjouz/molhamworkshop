<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\{CreateRequest};
use App\Jobs\{ImportDriveFile, importTrelloFiles};
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterventionImage;

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

            case "local":
                $this->saveLocalFile($request);
                break;

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
                $this->saveTrelloFiles($request);
                // importTrelloFiles::dispatch([
                //     'attachments' => $data['attachments'],
                //     'access_token' => $data['accessToken'],
                //     'fileable_type' => $data['fileable_type'],
                //     'fileable_id' => $data['fileable_id'],
                // ]);
                break;

            default:
                return response()->json(['msg' => 'upload method does not exists']);
                break;
        }
    }




    private function saveLocalFile($request)
    {
        $data = $request->validated();
        do {
            $reference = Str::random(100);
        } while (File::where('reference', $reference)->exists());

        $file = $request->file('file');
        if (!$file) throw new Exception('missed data');

        Storage::disk('local')->put('images/' . $reference . '.jpg', file_get_contents($file));
        $fileModel = File::create(['size' => $file->getSize(), 'fileable_type' => $data['fileable_type'], 'fileable_id' => $data['fileable_id'], 'name' => $file->getClientOriginalName(), 'extension' => $file->extension()]);

        return response()->json(null);
    }

    private function saveTrelloFiles($request)
    {
        $data = $request->all();

        importTrelloFiles::dispatch([
            'attachments' => $data['attachments'],
            'access_token' => $data['accessToken'],
            'fileable_type' => $data['fileable_type'],
            'fileable_id' => $data['fileable_id'],
        ]);
    }
}
