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

class DriveController extends Controller
{
    private $drive;
    public function __construct(Google_Client $client)
    {
        $this->middleware(function ($request, $next) use ($client) {
            $accessToken = [
                'access_token' => auth()->user()->token ?? 'ya29.a0AfH6SMCpYK2qhyiHFSZTAV0hZ1rJlCA_K-Xc2coNnzBWt1Y0ywFZunEU5JYAWRp7A9vwusxYf19DeQH0qKd1nYYIa7pORzhq_ePg4oMCIepYgun_5piPqj0KAz0PSJfoE85Q_HvGgOT8JKiA6ej8401F_ftf-A',
                'created' => auth()->user()->created_at->timestamp,
                'expires_in' => auth()->user()->expires_in,
                'refresh_token' => auth()->user()->refresh_token ?? 'ya29.a0AfH6SMCZL2bBUIGLzmPzKVXmflykgTPLVEMF8CHymIG…zqeeihXA0hlVjyB2QMFNX6GGMYuXZNH1E-HnV6TjHPvwlkpSg'
            ];

            $client->setAccessToken($accessToken);
            $client->setClientId('120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com');
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                }
                // auth()->user()->update([
                    //     'token' => $client->getAccessToken()['access_token'],
                    //     'expires_in' => $client->getAccessToken()['expires_in'],
                    //     'created_at' => $client->getAccessToken()['created'],
                    // ]);
                }
                
                // $client->refreshToken(auth()->user()->refresh_token);
                $this->drive = new Google_Service_Drive($client);
                // dd($client , $this->drive);
            return $next($request);
        });
    }

    public function getDrive()
    {
      

        // $this->ListFolders('root');
    }
    
    public function ListFolders(Request $request , $id = 'root')
    {   

        $access_token = "ya29.a0AfH6SMDGuItsEAeBfe6vPCcHWP9Et0kH2i7J7xdRUxy9qy0tXq6rqAvzi6GXcOVH_dDRHPKkbNwIf3jbGcF4zVGF1ezgte7B47JoAhmPIRrkrYQFY8IZFDVEJp79EbezOqxEoDrTThccQlyXdAUAIBeVDA0ViA";
        return Files::save_drive_file($request , $access_token);

        // $url = "https://www.googleapis.com/drive/v2/files/1HtyyXalQTua0S02Hw1sfJ1vQGONlZ1w4?key=AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";
        // $url = "https://www.googleapis.com/drive/v2/files/1M9YNC-jWUZ5l0g2ml4FnnMJzua0L3b47?key=AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY&alt=media&source=downloadUrl";
        $url = "https://www.googleapis.com/drive/v2/files/178nfdrYjZ8P-Tc6e9cHQFGK_UyirhmoI?key=AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";
// 1J9WMWIsbU1xluUVZkWZxstCr7wyeIvL-
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer ya29.a0AfH6SMDGuItsEAeBfe6vPCcHWP9Et0kH2i7J7xdRUxy9qy0tXq6rqAvzi6GXcOVH_dDRHPKkbNwIf3jbGcF4zVGF1ezgte7B47JoAhmPIRrkrYQFY8IZFDVEJp79EbezOqxEoDrTThccQlyXdAUAIBeVDA0ViA",
            );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        // var_dump($resp);

        $resp = json_decode($resp);
        // dd(fopen($resp->downloadUrl , 'r+'));
        // dd($resp);
        if($resp->downloadUrl){

            $curl = curl_init($resp->downloadUrl);
            curl_setopt($curl, CURLOPT_URL, $resp->downloadUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
                // "Accept: application/json",
                "Authorization: Bearer ya29.a0AfH6SMDGuItsEAeBfe6vPCcHWP9Et0kH2i7J7xdRUxy9qy0tXq6rqAvzi6GXcOVH_dDRHPKkbNwIf3jbGcF4zVGF1ezgte7B47JoAhmPIRrkrYQFY8IZFDVEJp79EbezOqxEoDrTThccQlyXdAUAIBeVDA0ViA",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
            var_dump($resp);

            $file = file_put_contents(storage_path('data.csv') , $resp);
            $resp = json_decode($resp);
            dd($resp , 
            $file
            // file_get_contents($resp , true) 
        );
            
            dd($resp);


            dd(1);
        }
        
        dd(0);

        $authorization = "Authorization: Bearer 080042cad6356ad5dc0a720c18b53b8e53d4c274";

        $headers = [
            'Authorization: Bearer ya29.a0AfH6SMCpYK2qhyiHFSZTAV0hZ1rJlCA_K-Xc2coNnzBWt1Y0ywFZunEU5JYAWRp7A9vwusxYf19DeQH0qKd1nYYIa7pORzhq_ePg4oMCIepYgun_5piPqj0KAz0PSJfoE85Q_HvGgOT8JKiA6ej8401F_ftf-A'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/drive/v2/files/1HtyyXalQTua0S02Hw1sfJ1vQGONlZ1w4?key=AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY' . 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);
        curl_close($ch);

        dd($output);




        $query = "mimeType='application/vnd.google-apps.folder' and '" . $id . "' in parents and trashed=false";
        $optParams = [
            'fields' => 'files(id, name)',
            'q' => $query
        ];
        
        $results = $this->drive->files->listFiles($optParams);
        dd($results );

        if (count($results->getFiles()) == 0) {
            print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
                dump($file->getName(), $file->getID());
            }
        }
    }

    function uploadFile(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('upload');
        } else {
            $this->createFile($request->file('file'));
        }
    }

    function createStorageFile($storage_path)
    {
        $this->createFile($storage_path);
    }

    function createFile($file, $parent_id = null)
    {
        $name = gettype($file) === 'object' ? $file->getClientOriginalName() : $file;
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parent' => $parent_id ? $parent_id : 'root'
        ]);

        $content = gettype($file) === 'object' ?  File::get($file) : Storage::get($file);
        $mimeType = gettype($file) === 'object' ? File::mimeType($file) : Storage::mimeType($file);

        $file = $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        dd($file->id);
    }

    function deleteFileOrFolder($id)
    {
        try {
            $this->drive->files->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }

    function createFolder($folder_name)
    {
        $folder_meta = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'mimeType' => 'application/vnd.google-apps.folder'
        ));
        $folder = $this->drive->files->create($folder_meta, array(
            'fields' => 'id'
        ));
        return $folder->id;
    }
}
