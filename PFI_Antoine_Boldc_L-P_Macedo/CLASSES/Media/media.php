<?php

include_once __DIR__ . "/mediaTDG.php";

class Media{

    private $id;
    private $url;
    private $authorID;
    private $title;
    private $albumid;
    private $creation;

    public function __construct(){
        /*
        $this->id = $id;
        $this->URL = $URL;
        $this->authorID = $authorID;
        $this->title = $title;
        $this->albumid = $albumid;
        $this->creation = $creation;
        */
    }

    public function display(){
        $id = $this->id;
        $url = $this->url;
        $authorID = $this->authorID;
        $author = User::get_username_by_ID($authorID);
        $authorurl = User::get_url_by_ID($authorID);
        $title = $this->title;
        $albumid = $this->albumid;
        $creation = $this->creation;
        include "HTML/mediaTemplate.php";
    }

    public static function create_entry($url,$authorID, $title, $albumid, $creation){
        $TDG = mediaTDG::get_instance();
        $res = $TDG->add_media($url,$authorID, $title,$albumid,$creation);
        return $res;
    }

    public function delete(){
        $TDG = new MediaTDG();
        $res = $TDG->delete_media($this->id);
        $TDG = null;
        return $res;
    }

    public function load_image($id){
        $TDG = new mediaTDG();
        $res =$TDG->get_by_id($id);
        $TDG = null;
        $this->set_ID($res["id"]);
        $this->set_url($res["urls"]);
        $this->set_authorID($res["authorID"]);
        $this->set_title($res["title"]);
        $this->set_albumid($res["albumid"]);
        $this->set_creation($res["creation"]);
        return $res;
    }
    //setters
    public function set_ID($id)
    {
        $this->id = $id;
    }
    public function set_url($url)
    {
        $this->url = $url;
    }
    public function set_authorID($authorID)
    {
        $this->authorID = $authorID;
    }
    public function set_title($title)
    {
        $this->title = $title;
    }
    public function set_albumid($albumid)
    {
        $this->albumid = $albumid;
    }
    public function set_creation($creation)
    {
        $this->creation = $creation;
    }

    public static function fetch_image_by_threadID($threadid){
        $TDG = new MediaTDG();
        $res = $TDG->get_by_threadid($threadid);
        $TDG = null;
        return $res;
    }
    public static function create_image_list($threadid){
        $info_array = Media::fetch_image_by_threadID($threadid);
        $image_list = array();
        
        foreach($info_array as $ia){
            $temp_image = new Media();
            $temp_image->set_ID($ia["id"]);
            $temp_image->set_url($ia["urls"]);
            $temp_image->set_authorID($ia["authorID"]);
            $temp_image->set_title($ia["title"]);
            $temp_image->set_albumid($ia["albumid"]);
            $temp_image->set_creation($ia["creation"]);
            array_push($image_list,$temp_image);
        }

        return $image_list;
    }


    /*
    public static function get_all_media(){
        $TDG = mediaTDG::get_instance();
        $res = $TDG->get_all_media();

        $obj_list = self::arr_to_obj($res);

        return $obj_list;
    }

    public static function arr_to_obj($arr){
        $obj_arr = array();
        foreach($arr as $k){
            $temp_m = new Media($k["id"],$k["URL"],$k["authorID"], $k["title"], $k["albumid"],$k["creation"]);
            array_push($obj_arr, $temp_m);
        }
        return $obj_arr;
    }
    */
    public static function search_media($title){
        $TDG = new mediaTDG();
        $res = $TDG->search_media_title_like($title);
        $media_list = array();

        foreach($res as $r){
            $media = new Media();
            $media->set_ID($r["id"]);
            $media->set_title($r["title"]);
            array_push($media_list, $media);
        }
        
        return $media_list;
    }
    public function display_media(){
        $title = $this->title;      
        echo "<div class='card bg-dark mb-4'>";
        echo "<div class='card-header text-left '><h5>$title</h5></a>";
        echo "</div>";
        echo "</div>";
    }
}