<?php
/**
 * класс для работы с изображениями
 */
class Image
{
    private static $path = ROOT.'sources/images/';
    private static $allowTypes = ['image/png','image/jpg','image/jpeg'];
    private static $allowSize = 2*1024;

    public static function add() {
        $tempName = $_FILES['image']['tmp_name'];
        $realName = $_FILES['image']['name'];

        $nameFile = time().'_'.$realName;
        if (is_uploaded_file($tempName)) {
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo,$tempName);
            if (in_array($mimeType,self::$allowTypes)) {
                $size = getimagesize($tempName)[2];
                if ($size <= self::$allowSize) {
                    if(move_uploaded_file($tempName,self::$path.$nameFile)){
                        return $nameFile;
                    }else{
                        throw new Exception("uploading file error");
                    }
                } else{
                    throw new Exception("invalid file size");
                }
            } else{
                throw new Exception("invalid file format");
            }
        } else{
            throw new Exception("file not uploaded");
        }
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