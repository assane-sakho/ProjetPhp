<?php

namespace App\Helpers;

class FileHelper
{
    public static function getFileName($file_name,  $studentFullName)
    {
        $realName = [
            "cv" => "CV",
            "cover_letter" => "Lettre de motivation",
            "report_card_0" => "Relevé de notes n°0",
            "report_card_1" => "Relevé de notes n°1",
            "report_card_2" => "Relevé de notes n°2",
            "vle_screenshot" => "Imprime écran ENT"
        ];

        $tmpList = explode('/', $file_name);

        $file = explode('.', $tmpList[count($tmpList)-1]);

        $fileName =  $studentFullName .  ' - ' . $realName[$file[0]];
        $ext = '.' . $file[1];

        $currentFileName =  $fileName . $ext;
        return $currentFileName;
    }
}