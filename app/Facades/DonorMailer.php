<?php

namespace App\Facades;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SendGrid\Mail\Mail as SendGridMail;
use App\Models\Donor;

class DonorMailer

{
    protected static $from = ['mail' => "noreply@molhamteam.com", 'name' => "Molham Team"];
    
    public static function sendResetPasswordCode ($donorName, $donorEmail, $passwordResetCode)
    {
        $email = new SendGridMail(); 
        $email->setFrom(self::$from['mail'], self::$from['name']);
        $email->addTo($donorEmail, $donorName, ["donor_name" => $donorName, "reset_password_code" => $passwordResetCode]);
        $email->setTemplateId("d-226493e1e63345faaf7e3ec9f48770b6");
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        
        $response = $sendgrid->send($email);
        // chack if response has errors and send to system error logs
        return ($response->statusCode() == 202) ? true : false;
    }
    
    public static function sendEmailVerification ($donorName, $donorEmail, $emailVerificationToken)
    {
        $email = new SendGridMail(); 
        $email->setFrom(self::$from['mail'], self::$from['name']);
        $email->addTo($donorEmail, $donorName, ["donor_name" => $donorName, "email_verification_link" => 'https://molham-next.vercel.app/verifyemail/' . $emailVerificationToken]);
        $email->setTemplateId("d-407b7e1ce71e4cdaa6724427dd073b60");
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        
        $response = $sendgrid->send($email);
        // chack if response has errors and send to system error logs
        return ($response->statusCode() == 202) ? true : false;
    }
}