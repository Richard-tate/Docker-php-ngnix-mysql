<?php

namespace App\Controllers\Errors;

use Framework\Controller;

class ErrorController extends Controller
{
    /**
     *  constructor function
     *
     *  @return void
     */
    public function __construct(  )
    {
        parent::__construct();
    }

    /**
     *  404 page controller
     *
     * @param string $Message
     * @return void
     */

    public static function notFound(string $Message = "Resource Not Found"): void
    {
        http_response_code(404);

        loadView('errors/error', [
            'status' => '404',
            'message' => $Message,
        ]);
    }

    /**
     *  403 page controller
     *  @param string $message
     *  @return void
     */

    public static function unauthorized(string $message = "You Must Be Signed in To See This Page" ): void
    {
        http_response_code(403);

        loadView('errors/error', [
            'status' => '403',
            'message' => $message,
        ]);
    }
}