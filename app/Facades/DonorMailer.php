<?php

namespace App\Facades;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SendGrid\Mail\Mail as SendGridMail;
use App\Models\Donor;

class DonorMailer

{
    protected static $from = ['mail' => "noreply@molhamteam.com", 'name' => "Molham Team"];
    
    public static function sendResetPasswordLink (Donor $donor, $code)
    {
        $email = new SendGridMail(); 
        $email->setFrom(self::$from['mail'], self::$from['name']);
        $email->addTo($donor->email, $donor->name, ["donor_name" => $donor->name, "password_reset_link" => 'https://molham-next.vercel.app/resetpassword/' . $code]);
        $email->setTemplateId("d-226493e1e63345faaf7e3ec9f48770b6");
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        
        $response = $sendgrid->send($email);
        // chack if response has errors and send to system error logs
        return ($response->statusCode() == 202) ? true : false;
    }
}