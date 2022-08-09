<?php
/**
 * Created by PhpStorm
 * User: Kha Nam
 * Date: 20/05/2022
 * Time: 20:27
 */


namespace App\Helpers;


class Helpers
{
    public static function getUrlUploadFile($file){
        return asset($file);
    }

    public static function getStatusUser($type = 'all'){
        $status = [
            1 => 'アクティブ',
            0 => '非活性'
        ];
        return $type === 'all' ? $status : $status[$type];
    }
}
