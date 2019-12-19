<?php
include "../CLASSES/Media/media.php";
include "../CLASSES/THREAD/thread.php";
include __DIR__ . "/../UTILS/sessionhandler.php";
$title = $_POST["title"];
$threadid = $_POST["threadID"];

//UPLOADER UNE IMAGE
$target_dir = "../Medias/";
$media_file_type = pathinfo($_FILES['image']['name'] ,PATHINFO_EXTENSION);
// Valid file extensions
$img_extensions_arr = array("jpg","jpeg","png","gif");
if(in_array($media_file_type, $img_extensions_arr)){
  $type = "image";
}
else{
  echo "INVALID FILE TYPE";
  die();
}

//creation de l'url pour la DB
$url = $target_dir . basename($_FILES["image"]["name"]);
//s'assure que l'image a un url unique
if (file_exists($url)) {
    header("Location: ../error.php?ErrorMSG=image existe déja");
    die();
  }
//deplacement du fichier uploader vers le bon repertoire (Medias)
if(!move_uploaded_file($_FILES['image']['tmp_name'], $url))
    {
      header("Location: ../error.php?ErrorMSG=fuck ma vie" . $_FILES['image']['error']);
      die();
    }
$thread = new Thread();
$res = $thread->load_thread_by_id($threadid);
$authorID = $thread->get_authorID();
//ajouter a la bd
$image = Media::create_entry($url,$authorID,$title,$threadid, time());

header("Location: ../billboard.php");
die();