<?php

class Response
{
    public static function send($response) {
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}