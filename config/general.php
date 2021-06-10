<?php

return [

    // amount of least acceptable sponsor used in Helper Facades AssignToSponsor function

    'least_sponsore_amount' => 10,



    /* 
     * this array retrive what exists locales in site 
    */
    'available_locales' => [
        "ar", //Arabic
        "en", //English
        "fr", //French
        "de", //Germany , 
        "tr", //Turkey
        "es" //Spain
    ],




    // Google Drive
    'google_drive_api_key' => env("GOOGLE_DRIVE_API_KEY", '')


];





