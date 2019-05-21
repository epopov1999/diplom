<?php
/**
 * @Класс обработки POST-запросов
 */

 class PostRoute extends Route
 {

    public function __construct(){
        parent::__construct();
        
        $action = $this->url[1];
 
        $post_id = $this->url[2] ?? false;
        $is_comment = in_array('comments',$this->url);
         
        if ($post_id && $is_comment){
            $this->addComment($post_id);
        } elseif($post_id || isset($this->url[2])){
            $this->editPost($post_id);
        } else{
           /// call_user_func(array($this, $action)); 
            //posts (create) or auth
           $this->$action();
        }
    }
     
    private function addComment($post_id){

        if (is_numeric($post_id)) {

            $post = $this->db->getPost($post_id);
            if ($post) {
                
                if ($this->isAdmin()) $author = 'admin';
                
                if (!isset($_POST['comment']) || $_POST['comment']==""){
                    $this->getResponse('HTTP/1.1 400 Creating error',[
                        'status'=>'false',
                        'message'=> ['comment'=>'is empty']
                    ]);
                } elseif (!$this->isAdmin() && (!isset($_POST['author']) || $_POST['author']=="")){
                    $this->getResponse('HTTP/1.1 400 Creating error',[
                        'status'=>'false',
                        'message'=> ['author'=>'is empty']
                    ]);
                } else {
                    $rating = $_POST['rating'] ?? null;
                    $this->db->addComment($post_id,$_POST['author'],$_POST['comment'],$rating);
                    $this->getResponse('HTTP/1.1 201 Successful creation',[
                       'status'=>true 
                    ]);
                }
            }
            
            $this->getResponse('HTTP/1.1 404 Post not found',[
                'status'=>'false',
                'message'=>'Post not found'
            ]);  

        } else {
            $this->getResponse('HTTP/1.1 404 Post not found',[
                'status'=>'false',
                'message'=>'Post not found'
            ]);
        }
    }
     

    private function editPost($post_id){
        $this->checkToken();
        $post = $this->db->getPost($post_id);
        if($post){
            $error = [];
            $post_by_title = $this->db->getPostByTitle($_POST['title']);
            if ($post_by_title && $post_by_title[0]['id']!=$post_id) {
               $this->getResponse('HTTP/1.1 400 Editing error',[
                    'status'=>'false',
                    'message'=>['title'=>'already exists']
                ]);
            }
            $image = '';
            Image::remove($post['image']);
            if(!$_FILES['image']['error']){
                $image = Image::add();
            } 

            $this->db->editPost($post_id,$_POST['title'],$_POST['anons'],$_POST['text'],$image);
            $post = $this->db->getPost($post_id);
            
            $this->getResponse('HTTP/1.1 201 Successful creation',[
                'status'=>true,
                'post'=>[
                    'title'=>$post['title'],
                    'datatime'=>date('H:i d.m.Y',strtotime($post['date'])),
                    'anons'=>$post['anons'],
                    'text'=>$post['text'],
                    'image'=>$post['image']
                ]
            ]);

        } 
        $this->getResponse('HTTP/1.1 404 Post not found',[
            'status'=>'false',
            'message'=>'Post not found'
        ]);
        
    }
     
    private function auth(){
        if(isset($_POST['login']) && isset($_POST['password'])){
            $token = $this->db->authorization($_POST['login'], $_POST['password']);
            if($token){
                $this->getResponse('HTTP/1.1 200 Successful authorization', 
                ['status' => 'true',
                    'token' => $token,
                ]);
            }
            else{
                $this->getResponse('HTTP/1.1 401 Invalid authorization data',
                ['status' => 'false',
                    'message' => 'Invalid authorization data',
                ]);
            }
        } else {
            $this->getResponse('HTTP/1.1 401 Invalid authorization data',
                ['status' => 'false',
                    'message' => 'Invalid authorization data',
                ]);
        }
    }
     
    private function posts(){ //create post
        $this->checkToken();
        $error = [];
        if (isset($_POST['title']) && isset($_POST['anons']) && isset($_POST['text']) && !empty($_FILES)){
            if ($this->db->getPostByTitle($_POST['title'])) $error ['title'] = 'already exists';
            try{
                if(empty($error)) $image = Image::add();
            } catch(Exception $e){
                $error['image']=$e->getMessage();
            }
            if (empty($error)){
                
                try{
                    $post_id = $this->db->createPost($_POST['title'],$_POST['anons'],$_POST['text'],$image);
                
                    if ($post_id) {
                        $this->getResponse('HTTP/1.1 201 Successful creation',[
                            //status boolean для валидации теста
                            'status'=>true,
                            'post_id'=> $post_id
                        ]);
                    } 
                    
                } catch (Exception $e){
                    $this->getResponse('HTTP/1.1 400 Creating error',[
                        //status boolean для валидации теста
                        'status'=>false,
                        'message'=> $e->getMessage()
                    ]);
                }
                
                
            } else{
                $this->getResponse('HTTP/1.1 400 Creating error',[
                    'status'=>'false',
                    'message'=>$error
                ]);
            }
            
        } else {
            if(!isset($_POST['title'])) $error['title'] = 'is empty';
            if(!isset($_POST['title'])) $error['anons'] = 'is empty';
            if(!isset($_POST['title'])) $error['text'] = 'is empty';
            $this->getResponse('HTTP/1.1 400 Creating error',[
                'status'=>'false',
                'message'=> $error
            ]);
        }
    }

     

 }