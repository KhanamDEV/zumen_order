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
}
