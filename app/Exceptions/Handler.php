<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // authantication exception
        if($exception instanceof TokenExpiredException){
            return response()->json(['error'=>['Expired time Exception']],Response::HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL);
        }elseif($exception instanceof TokenInvalidException){
            return response()->json(['error'=>['Invalid Token Exception']],Response::HTTP_UNAUTHORIZED);
        }elseif($exception instanceof JWTException ){
            return response()->json(['error'=>['There is a problem with token']],Response::HTTP_UNAUTHORIZED);
        }
        // get product not found exception
        if($request->expectsJson()){
            if($exception instanceof ModelNotFoundException){
                return response()->json([
                    'error'=>"model not found"
                ],404);
            }
            if($exception instanceof NotFoundHttpException){
                return response()->json([
                    'error'=>"Not found HTTP request"
                ],404);
            }

        }
       
        return parent::render($request, $exception);
    }
}
