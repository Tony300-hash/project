<?php
  session_start();
  include "./UTILS/cookiemanager.php";

  if(!isset($_GET["threadTitle"])){
    header("Location: error.php?ErrorMSG=Bad%20Request!");
    die();
  }

  //manage favorite thread cookies
  manage_fav_cookies();

  $title=$_GET["threadTitle"];

  $content = array();
  array_push($content, "postlistview.php");
  array_push($content, "postcreateview.php");

  require_once __DIR__ . "/HTML/masterpage.php";
?>
