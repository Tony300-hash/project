<?php
  include "../CLASSES/USER/user.php";
  include "../UTILS/formvalidator.php";
  include __DIR__ . "/../UTILS/sessionhandler.php";
  include __DIR__ . "/../CLASSES/Media/media.php";

  session_start();

  if(!validate_session()){
    header("Location: ../error.php?ErrorMSG=Not%20logged%20in!");
    die();
  }

  $email = $_POST["email"];
  $username = $_POST["username"];
  //verification des parametres
  if(empty($email) && empty($username)){
    header("Location: ../error.php?ErrorMSG=invalid email or username");
    die();
  }

  if(!empty($email) && Validator::validate_email($email)){
    $newmail = $email;
  }
  else{
    $newmail = $_SESSION["userEmail"];
  }

  if(!empty($username)){
    $newname = $username;
  }
  else{
    $newname = $_SESSION["userName"];
  }
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
    //ajouter a la bd
    Media::create_entry($url,$_SESSION["userID"] ,$username, -1, time());
  

  $user = new User();
  if(!$user->update_user_info($_SESSION["userEmail"], $newmail, $newname, $url)){
    header("Location: ../error.php?ErrorMSG=invalid%20request");
    die();
  }

  header("Location: ../billboard.php");
  die();

?>
