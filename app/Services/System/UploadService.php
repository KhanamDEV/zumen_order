<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 21/05/2022
 * Time: 13:38
 */


namespace App\Services\System;


use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function uploadAjax(){
        try {
            if (request()->has('file')){
                $randomKey = bin2hex(random_bytes(3));
                $file = request()->file('file');
                //1048576,2 = 1mb
                $maxUpload = env('MAX_UPLOAD', 25) * 1048576;
                if ($file->getSize() > $maxUpload) return ResponseHelpers::serverErrorResponse([], '', __('message.response.max_size'));
                $explodeOriginalNam = explode(".", $file->getClientOriginalName());
                $name = $file->getClientOriginalName();
                $path = $explodeOriginalNam[0].$randomKey.'.'.$file->getClientOriginalExtension();
                if (!Storage::disk('public')->put($path, $file->getContent())){
                    return ResponseHelpers::serverErrorResponse([], '', __('message.response.internal_server_error'));
                }
                return ResponseHelpers::showResponse(['name' => $name, 'path' => "/uploads/$path", 'preview' => asset("/uploads/$path")], '', __('message.response.success'));
            }
            return ResponseHelpers::serverErrorResponse([], '', __('message.response.internal_server_error'));
        } catch (\Exception $e){
            return ResponseHelpers::serverErrorResponse([], '', __('message.response.internal_server_error'));
        }
    }

    public function upload($file){
        $randomKey = bin2hex(random_bytes(3));
        if ($file->getSize() > 5242880) return false;
        $explodeOriginalNam = explode(".", $file->getClientOriginalName());
        $path = $explodeOriginalNam[0].$randomKey.'.'.$file->getClientOriginalExtension();
        if (!Storage::disk('public')->put($path, $file->getContent())) return  false;
        return "/uploads/$path";
    }
}
