<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use GuzzleHttp\Client;
use App\Models\File;

class importTrelloFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     *  attachments is array has data that we want to import it from Trello 
     * @token is user Trello access token to access files as that user
     * fileable_type instance type
     * fileable_id instance id
     */

    public $attachments;
    public $access_token;
    public $fileable_type;
    public $fileable_id;

    public function __construct($data)
    {
        $this->attachments = $data['attachments'];
        $this->access_token = $data['access_token'];
        $this->fileable_type = $data['fileable_type'];
        $this->fileable_id = $data['fileable_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files_count  = 0;
        $file_data = null;

        /* 
         * api key for Trello ,  exists in config to connect to Trello as client
         * required params  
        */

        $api_key = config('services.trello.key');


        /* 
         * we have to set header accept application/json
        */

        $headers = [
            'Accept' => 'application/json',
        ];

        /* 
         * instanciate new guzzle client 
        */

        $client = new Client();

        foreach ($this->attachments  as $attachment) {
            try {

                /* 
                 * Trello end point to retrieve file and get download url
                 * we have to pass token as query parameter & this token taked from client 
                */ 
            
                $url = "https://api.trello.com/1/cards/" .$attachment['cardId'] . "/attachments/" . $attachment['id'] . "?key=" . $api_key . "&token=".$this->access_token;


                
                $response = $client->request('GET', $url, [
                    'headers'        => $headers,
                    'decode_content' => true,
                ]);

                $data = json_decode($response->getBody()->getContents());

                /* 
                 * if first response success , will return link to download url
                 * so we take download link and request it for download 
                */

                if ($data && isset($data->url)) {

                    /*
                    * request Trello after get download url and get file
                    */
                    $res =  $client->request('GET', $data->url, [
                        'headers'        => $headers,
                        'decode_content' => true,
                        'timeout' => 200 //second
                    ]);


                    $file_data = $res->getBody()->getContents();

                    /* 
                     * mime2ext() custom helper function exists in Generic file
                     * it take file mime type and return extension  or null
                    */
                    $extension  = mime2ext($attachment['mimeType']);

                    /* 
                     * if extension = null we log mimetype to add it to  mime2ext()
                    */

                    if (!$extension) {
                        echo "\n this mime type does not exists : " . $attachment['mimeType'];
                    }

                    /* 
                     * generate random string and check if exists we generate it another time because reference is unique field 
                     * $file_name to save file in storage in this name , not in model
                    */
                    $reference = Str::random(10);

                    /*
                    * generate reference for file model and sure to be unique
                    */

                    do {
                        $reference = Str::random(10);
                    } while (File::where('reference', $reference)->exists());



                    $file_name = $reference . '.' . $extension;

                    /*
                    * Put response in file to save it
                    */
                    $file = file_put_contents(storage_path('app/public/' . $file_name), $file_data);

                   
                    /* 
                     * create file model after import file to storage 
                    */

                    $created_file = File::create([
                        'fileable_type' => $this->fileable_type,
                        'fileable_id' => $this->fileable_id,
                        'name' => $attachment['name'],
                        'extension' => $extension,
                        'reference' => $reference
                    ]);

                    /*
                    * increase file count to use it in log or any where else 
                    */

                    $files_count++;

                    echo " \n file imported id = " . $created_file->id;
                }
            } catch (Exception $e) {
                echo "\n error : " . $e->getMessage();
                continue;
            }
        }


        echo " \n total imported files :  " . $files_count;
        echo " \n finish importing \n";

        return true;
    }
}
