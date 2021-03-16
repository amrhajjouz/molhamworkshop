<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        
        $this->reportable(function (Throwable $e) {
            //

        });
    }




    public function render($request, Throwable $exception) {


    // if ($exception instanceof APIException || $exception instanceof ModelNotFoundException ) {

    //     $errors = array();

    //     if( is_array( json_decode($exception->getMessage()) ) ){
    //         foreach( json_decode($exception->getMessage()) as $key=>$value){
    //         $errors[] = [
    //         'status' =>false ,
    //         'error' => $value ,
    //         ];
    //     }

    //     } else {
    //         $errors = [
    //             'status' =>false ,
    //             'error' => $exception->getMessage()
    //         ];
    //     }

    //     return response()->json($errors)->setStatusCode(500);

    // }


    return parent::render($request, $exception);
    }

    
}
