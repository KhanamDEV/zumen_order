<?php

namespace App\Helpers;

use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class ResponseHelpers
{
    public static function showResponse($data = [], $format = 'json', $message = null){
        $response = [
            "meta" => [
                'status' => 200,
                'message' => !empty($message) ? $message : __('messages.response.success'),
            ],
            'response' => !empty($data) ? $data : (!$data ? $data : [])
        ];

        if ($format == 'json') {
            return response()->json($response, $response['meta']['status']);
        } else {
            return $response;
        }
    }


    public static function notFoundResponse($message = null, $format = 'json')
    {
        $response = [
            "meta" => [
                'status' => 404,
                'message' => !empty($message) ? $message : __('messages.response.resource_not_found')
            ],
            'response' => (object)[]
        ];

        if ($format == 'json') {
            return response()->json($response, $response['meta']['status']);
        } else {
            return $response;
        }
    }

    public static function authenticateErrorResponse($message = null, $format = 'json')
    {

        $response = [
            "meta" => [
                'status' => 401,
                'message' => !empty($message) ? $message : __('messages.response.unauthenticated_error')
            ],
            'response' => (object)[]
        ];

        if ($format == 'json') {
            return response()->json($response, $response['meta']['status']);
        } else {
            return $response;
        }
    }


    public static function serverErrorResponse($data = [], $format = 'json', $message = null)
    {
        $response = [
            "meta" => [
                'status' => 500,
                'message' => !empty($message) ? $message : __('messages.response.internal_server_error')
            ],
            'response' => !empty($data) ? $data : (!$data ? $data : null)
        ];

        if ($format == 'json') {
            return response()->json($response, $response['meta']['status']);
        } else {
            return $response;
        }
    }

    public static function messageSlack($_data){
        Notification::route('slack', env('SLACK_WEBHOOK'))
            ->notify(new SlackNotification(@json_encode($_data)));
    }
}
