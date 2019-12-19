<?php

include_once __DIR__ . "/threadTDG.php";
include_once __DIR__ . "/../POSTS/post.php";
include_once __DIR__ . "/../Media/media.php";

class Thread{

    private $id;
    private $title;
    private $posts;
    //description
    private $description;
    //liste images
    private $images;
    //autheur id
    private $authorID;
    public function __construct(){
      $this->posts = array();
      $this->images = array();
    }

    //getters
    public function get_id(){
        return $this->id;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_posts(){
        return $this->posts;
    }
    public function get_Description()
    {
        return $this->description;
    }
    public function get_authorID()
    {
        return $this->authorID;
    }

    //setters
    public function set_id($id){
        $this->id = $id;
    }

    public function set_title($title){
        $this->title = $title;
    }

    public function set_posts($posts){
        $this->posts = $posts;
    }
    public function set_description($description){
        $this->description = $description;
    }
    public function set_authorID($authorID)
    {
        $this->authorID = $authorID;
    }

    /*
        Quality of Life methods (Dans la langue de shakespear (ou QOLM pour les intimes))
    */
    public function load_thread_by_id($id){
        $TDG = new ThreadTDG();
        $res = $TDG->get_by_ID($id);

        if(!$res){
            return false;
        }

        $this->id = $res["id"];
        $this->title = $res["title"];
        $this->authorID = $res["authorID"];
        $this->description = $res["descriptions"];
        return true;
    }

    public function load_thread_by_title($title){
        $TDG = new ThreadTDG();
        $res = $TDG->get_by_title($title);

        if(!$res){
            return false;
        }

        $this->id = $res["id"];
        $this->title = $res["title"];
        $this->description = $res["descriptions"];
        $this->authorID = $res["authorID"];
        return true;
    }


    public function add_thread($title,$authorID,$description){
        $TDG = new ThreadTDG();
        $res = $TDG->add_thread($title,$authorID, $description);
        $TDG = null;
        if(!$res)
        {
            return false;
        }
        return true;
    }

    public function display_thread(){
        $title = $this->title;
        $id = $this->id;
        $description = $this->description;
        $authorID = $this->authorID;
        echo "<div class='card bg-dark mb-4'>";
        echo "<div class='card-header text-left '><a href='displaythread.php?threadID=$id&threadTitle=$title&description=$description'><h5>$title</h5></a>";
        echo "</div>";
        echo "</div>";
    }

    /*
    Post related functions
    */
    public function load_posts(){
        $res = Post::create_post_list($this->id);

        if(!$res)
        {
            return false;
        }

        $this->posts = $res;
    }

    public function display_posts(){
        if(empty($this->posts)){
            $this->load_posts();
        }

        if(empty($this->posts))
        {
            echo "<h3 class='mb-4'>No Post found in this thread</h3>";
        }
        else{

            foreach($this->posts as $posts => $post){
                $post->display();
              }
        }
    }
    public function load_images(){
        $res = Media::create_image_list($this->id);

        if(!$res)
        {
            return false;
        }
        $this->images = $res;
    }
    //function pour afficher les images
    public function display_images(){
        if(empty($this->images)){
            $this->load_images();
        }
        foreach($this->images as $images => $image){
            $image->display();
        }
    }
    /*
    STATIC FUNCTIONS
    */
    private static function list_all_threads(){
        $TDG = new ThreadTDG();
        $res = $TDG->get_all_threads();
        $TDG = null;
        if(!$res)
        {
          return $res;
        }
        return $res;
    }

    public static function create_thread_list(){
        $TDG_res = Thread::list_all_threads();
        $thread_list = array();

        foreach($TDG_res as $r){
            $thread = new Thread();
            $thread->set_id($r["id"]);
            $thread->set_title($r["title"]);
            $thread->set_description($r["descriptions"]);
            $thread->set_authorID($r["authorID"]);
            array_push($thread_list, $thread);
        }

        return $thread_list;
    }

    public static function search_thread($title){
        $TDG = new ThreadTDG();
        $res = $TDG->search_thread_title_like($title);
        $thread_list = array();

        foreach($res as $r){
            $thread = new Thread();
            $thread->set_id($r["id"]);
            $thread->set_title($r["title"]);
            array_push($thread_list, $thread);
        }
        
        return $thread_list;
    }

}
