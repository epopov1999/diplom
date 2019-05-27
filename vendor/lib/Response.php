<?php
/**
* класс отвечающий за формирование ответа 
*/
class Response
{
    //отправляем ответ в json формате
    public static function send($status, $data) {
        $response = ['status' => $status, 'data' => $data];
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}