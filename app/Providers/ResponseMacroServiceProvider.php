<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Use the same response format for any APIs
        // How to use ? In API controller response()->error($message) or response->success($data)

        Response::macro('success', function ($data, $message = 'success') {

            return Response::json([
                'message' => $message,
                'errors' => false,
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($message = '', $code = '', $status = 400) {
            if (!$message) {
                $message = "Error";
            }

            return Response::json([
                'errors'  => true,
                'code'    => $code,
                'message' => $message,
            ], $status);
        });

        // No content
        Response::macro('noContent', function ($status = 204) {
            return Response::json([], $status);
        });
    }
}
