<?php

namespace App\Facades;

use App\Models\{Cases, Donor, Place, Sponsorship, Student, Sponsor};
use Exception;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Models\File;

class Files
{


    /*
     * Mohamd
     * Google Drive
     */

    public static function  save_drive_files($data)
    {

        try {

            $attachments = $data->attachments;

            $imported_files = [];

            $file_data = null;

            $api_key = config('general.google_drive_api_key');

            $access_token = $data->accessToken;

            
            
            $headers = [
                'Accept' => 'gzip',
                'Accept-Encoding' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token,
                
            ];
            
            $client = new Client();
            foreach ($attachments  as $attachment) {
                // $url = "https://www.googleapis.com/drive/v2/files/178nfdrYjZ8P-Tc6e9cHQFGK_UyirhmoI?key=". $api_key;
                $url = "https://www.googleapis.com/drive/v2/files/" . $attachment['id'] . "?key=" . $api_key;
                
                $response = $client->request('GET', $url, [
                    'headers'        => $headers,
                    'decode_content' => true,
                    ]);
                    
                    $data = json_decode($response->getBody()->getContents());
                    if ($data && isset($data->downloadUrl)) {
                        
                        $res =  $client->request('GET', $data->downloadUrl, [
                            'headers'        => $headers,
                            'decode_content' => true,
                            ]);
                            // $res =  $client->request('GET', $data->downloadUrl);
                            
                            $file_data = $res->getBody()->getContents();
                            
                            dd($data);
                            $file = file_put_contents(storage_path($attachment['name']), $file_data);
                            $imported_files[] = $attachment;
                            
                            
                            dd($attachment);
                        }
                    }
                    
                    
                    
                    
                    
                    
                    dd($file_data, $imported_files);
                    // dd($data);
                } catch (Exception $e) {
            dd($e->getMessage(), json_decode($e->getMessage()));
        }
        // $res = $client->request('GET', 'https://api.github.com/user', [
        // 'auth' => ['user', 'pass']
        // ]);
        // echo $res->getStatusCode();

        dd($request);
    }
}
