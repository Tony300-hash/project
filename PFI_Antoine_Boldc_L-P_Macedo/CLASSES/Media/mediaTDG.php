<?php

include_once __DIR__ . "/../../UTILS/connector.php";

class mediaTDG extends DBAO{

    private $tableName;
    private static $instance = null;

    public function __construct(){
        Parent::__construct();
        $this->tableName = "media";
    }

    public static function get_instance(){
        if(is_null(self::$instance)){
            self::$instance = new mediaTDG();
        }
        return self::$instance;    
    }

    public function add_media($url,$authorID,$title, $albumid, $creation){
        
        try{
            $conn = $this->connect();
            $tableName = $this->tableName;
            $query = "INSERT INTO $tableName (urls,authorID,albumid, title,  creation) VALUES (:URLs,:authorID,:albumid,:title,  :creation)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':URLs', $url);
            $stmt->bindParam(':authorID',$authorID);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':albumid',$albumid);
            $stmt->bindParam(':creation',$creation);
            $stmt->execute();
            $resp = true;
        }

        catch(PDOException $e)
        {
            $resp =  false;
        }
        //fermeture de connection PDO
        $conn = null;
        return $resp;
    }

    public function get_all_media(){

        try{
            $conn = $this->connect();
            $query = "SELECT * FROM " . $this->tableName;
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
        }

        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
        //fermeture de connection PDO
        $conn = null;
        return $result;
    }

    public function get_by_id($id){

        try{
            $conn = $this->connect();
            $query = "SELECT * FROM ". $this->tableName ." WHERE id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
        }

        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        //fermeture de connection PDO
        $conn = null;
        return $result;
    }
    public function get_by_threadid($threadid){

        try{
            $conn = $this->connect();
            $query = "SELECT * FROM ". $this->tableName ." WHERE albumid=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $threadid);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
        }

        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        //fermeture de connection PDO
        $conn = null;
        return $result;
    }

    public function get_by_url($url){

        try{
            $conn = $this->connect();
            $query = "SELECT * FROM ". $this->tableName ." WHERE URL=:url";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':url', $url);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();
        }

        catch(PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
        //fermeture de connection PDO
        $conn = null;
        return $result;
    }
    public function delete_media($id){
        try{
            $conn = $this->connect();
            $tableName = $this->tableName;
            $query = "DELETE FROM $tableName WHERE id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resp = true;
        }

        catch(PDOException $e)
        {
            $resp = false;
        }
        //fermeture de connection PDO
        $conn = null;
        return $resp;
    }
    public function search_media_title_like($title){
        try{
            $conn = $this->connect();
            $tableName = $this->tableName;
            $query = "SELECT * FROM $tableName WHERE title LIKE :title";
            $stmt = $conn->prepare($query);
            $title = '%' . $title . '%';
            $stmt->bindParam(':title', $title);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
        }

        catch(PDOException $e)
        {
            return false;
        }
        //fermeture de connection PDO
        $conn = null;
        return $result;
    }
}