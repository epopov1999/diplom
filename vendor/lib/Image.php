<?php
/**
 * класс для работы с изображениями
 */
class Image
{
    private static $path = ROOT.'images/';
    private static $allowTypes = ['image/png','image/jpg','image/jpeg'];
    private static $allowSize = 2*1024;

    public static function add($image_key) {

        $tempName = $_FILES[$image_key]['tmp_name'];
        $realName = $_FILES[$image_key]['name'];

        $nameFile = time().'_'.$realName;
        if (is_uploaded_file($tempName)) {
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo,$tempName);
            if (in_array($mimeType,self::$allowTypes)) {
                $size = getimagesize($tempName)[2];
                if ($size <= self::$allowSize) {
                    if(move_uploaded_file($tempName, self::$path.$nameFile)){
                        return $nameFile;
                    } throw new Exception("Ошибка при загрузке файла");
                } throw new Exception("Файл слишком большой");
            } throw new Exception("Неверный формат файла");
        } throw new Exception("Файл не загружен");
    }

    public static function remove($src) {
        if ($src != ""){
            $src = self::$path.$src;
            if(file_exists($src)) {
                unlink($src);
            }
        }
    }

}