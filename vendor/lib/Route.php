<?php
/**
 * базовый класс для всех типов http запросов

class Route
{
    protected $url;

    public function __construct(){
        $this->url = explode('/', $_GET['url']);
    }

//    public function getResponse($header,$response){
//        header($header);
//        echo json_encode($response);
//        exit;
//    }
//
//    public function checkToken(){
//        $headers = getallheaders();
////        if(isset($headers['authorization'])){
//            if(!isset($headers['authorization']) || !$this->db->checkToken(str_replace('Bearer ','', $headers['authorization']))){
//
//                    $this->getResponse('HTTP/1.1 401 Unauthorized', [
//                        'message' => 'Unauthorized'
//                    ]);
//                } 
//
////        }
//        
//    }
//    
//    public function isAdmin(){
//        $headers = getallheaders();
//
//        if(!isset($headers['authorization']) || !$this->db->checkToken(str_replace('Bearer ','', $headers['authorization']))){
//            return false;
//        } 
//        return true;
//    }
}