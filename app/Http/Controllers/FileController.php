<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\{CreateRequest};
use App\Jobs\{ImportDriveFile, importTrelloFiles};
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

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
                $this->saveGoogleDriveFiles($request);
                // ImportDriveFile::dispatch([
                //     'attachments' => $data['attachments'],
                //     'access_token' => $data['accessToken'],
                //     'fileable_type' => $data['fileable_type'],
                //     'fileable_id' => $data['fileable_id'],
                // ]);
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
        $this->attachments = $data['attachments'];
        $this->access_token = $data['accessToken'];
        $this->fileable_type = $data['fileable_type'];
        $this->fileable_id = $data['fileable_id'];
        $file_data = null;
        $api_key = config('services.trello.key');
        $headers = ['Accept' => 'application/json', 'Authorization' => "Bearer $this->access_token"];
        $client = new Client();
        foreach ($this->attachments  as $attachment) {
            $url = "https://api.trello.com/1/cards/" . $attachment['cardId'] . "/attachments/" . $attachment['id'] . "?key=" . $api_key . "&token=" . $this->access_token;
            $response = $client->request('GET', $url, ['headers' => $headers, 'decode_content' => true]);
            $data = json_decode($response->getBody()->getContents());
            if ($data && isset($data->url)) {
                $data->url = $data->url . "?signature=signature&token=$this->access_token&key=$api_key";
                $res =  $client->request('GET', $data->url, ['headers' => $headers, 'decode_content' => true, 'timeout' => 200 /* econd*/]);
                $file_data = $res->getBody()->getContents();
                $extension  = mime2ext($attachment['mimeType']);
                if (!$extension) {
                } //TODO
                do {
                    $reference = Str::random(100) ;
                } while (File::where('reference', $reference)->exists());
                $file_name = $reference . '.' . $extension;
                Storage::put('files/' . $file_name, $file_data);
                File::create([
                    'fileable_type' => $this->fileable_type,
                    'fileable_id' => $this->fileable_id,
                    'name' => $attachment['name'],
                    'extension' => $extension,
                    'reference' => $file_name,
                    'size' => $data->bytes / 1024,
                    'upload_completed' => file_exists(storage_path('files/' . $file_name))
                ]);
            }
        }
    }

    private function saveGoogleDriveFiles($request)
    {
        $data = $request->all();

        $this->attachments = $data['attachments'];
        $this->access_token = $data['accessToken'];
        $this->fileable_type = $data['fileable_type'];
        $this->fileable_id = $data['fileable_id'];

        $file_data = null;
        $api_key = config('general.google_drive_api_key');
        $headers = [
            'Accept' => 'gzip',
            'Accept-Encoding' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ];
        $client = new Client(['verify' => false ]);
        foreach ($this->attachments  as $attachment) {
            try {
                $url = "https://www.googleapis.com/drive/v2/files/" . $attachment['id'] . "?key=" . $api_key;
                $response = $client->request('GET', $url, ['headers' => $headers, 'decode_content' => true]);
                $data = json_decode($response->getBody()->getContents());
                
                if ($data && isset($data->downloadUrl)) {
                    $res =  $client->request('GET', $data->downloadUrl, ['headers' => $headers, 'decode_content' => true, 'timeout' => 200 /*second*/]);
                    $file_data = $res->getBody()->getContents();
                    $extension  = mime2ext($attachment['mimeType']);
                    if (!$extension) {/*TODO*/}
                    do {$reference = Str::random(100);} while (File::where('reference', $reference)->exists());
                    $file_name = $reference . '.' . $extension;
                    Storage::disk('local')->put('files/' . $file_name, $file_data);
                    File::create([
                        'fileable_type' => $this->fileable_type,
                        'fileable_id' => $this->fileable_id,
                        'name' => $attachment['name'],
                        'extension' => $extension,
                        'reference' => $reference , 
                        'size' => filesize(storage_path('app/files/' . $file_name)) /1024 , 
                        'upload_completed' => file_exists(storage_path('app/files/' . $file_name))
                    ]);
                }
            } catch (Exception $e) {
                echo "\n error : " . $e->getMessage();
                continue;
            }
        }
    }
}
