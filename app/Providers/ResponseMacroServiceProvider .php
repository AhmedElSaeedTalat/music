<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('streamed', function($type, $size, $name, $callback) {
            $start = 0;
            $length = $size;
            $status = 200;
            $headers = [
                'Content-Type' => $type,
                'Content-Length' => $size,
                'Accept-Ranges' => 'bytes'
            ];
            if (false !== $range = Request::server('HTTP_RANGE', false)) {
                list($param, $range) = explode('=', $range);
                if (strtolower(trim($param)) !== 'bytes') {
                    header('HTTP/1.1 400 Invalid Request');
                    exit;
                }
                list($from, $to) = explode('-', $range);
                if ($from === '') {
                    $end = $size - 1;
                    $start = $end - intval($from);
                } elseif ($to === '') {
                    $start = intval($from);
                    $end = $size - 1;
                } else {
                    $start = intval($from);
                    $end = intval($to);
                }
                if ($end >= $length) {
                    $end = $length - 1;
                }
                $length = $end - $start + 1;
                $status = 206;
                $headers['Content-Range'] = sprintf('bytes %d-%d/%d', $start, $end, $size);
                $headers['Content-Length'] = $length;
            }
            return Response::stream(function() use ($start, $length, $callback) {
                call_user_func($callback, $start, $length);
            }, $status, $headers);
        });

    }
}