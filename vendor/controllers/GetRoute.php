<?php
/**
 * @Класс обработки GET-запросов
 */

 class GetRoute extends Route
 {

    public function __construct(){
        parent::__construct();
        $url = $this->url;
        if(isset($url[2])){
            if($url[2]=='search') {
                $this->search();
                return true;
            }
            $this->getPost($url[2]);
        }
        $this->getPosts();
    }
     
    private function getPosts(){
        $posts = $this->db->getPosts();
        foreach($posts as &$post){
            $post['datatime']=date('H:i d.m.Y',strtotime($post['date']));
            unset($post['date']);
            unset($post['id']);
            unset($post['sum_rating']);
        }
        $this->getResponse('HTTP/1.1 200 List posts',[
            'status'=>true,
            'posts'=>$posts
        ]);
    }
     
     private function getPost($id){
         $post = $this->db->getPost($id);
         if($post){
            $post['datatime']=$post['date'];
            unset($post['id']);
            unset($post['sum_rating']);
            unset($post['date']);
             $comments = $this->db->getComments($id);
          
            foreach($comments as $comment){
                $comment['datatime'] = date('H:i d.m.Y',strtotime($comment['datatime']));
            }
               $post['comments'] = $comments;
            $this->getResponse('HTTP/1.1 200 View post',$post);
         }
         $this->getResponse('HTTP/1.1 404 Post not found',[
            'status'=>'false',
            'message'=>'Post not found'
        ]);
     }
     
     private function search(){
         $this->getPosts();
     }
}