<?php
    include "../CLASSES/THREAD/thread.php";
    include __DIR__ . "/../UTILS/sessionhandler.php";

    session_start();

    if(!validate_session()){
      header("Location: ../error.php?ErrorMSG=Not%20logged%20in!");
      die();
    }

    $title = $_POST["threadcreationtitre"];
    //modification du post pour ajouter description
    $description = $_POST["threadcreationdesc"];
    if(empty("$title")){
      header("Location: ../error.php?ErrorMSG=bad%20request!1");
      die();
    }
    if(empty("$description")){
      header("Location: ../error.php?ErrorMSG=bad%20request!2");
      die();
    }
    $thread = new thread();
    if(!$thread->add_thread($title,$_SESSION["userID"], $description)){
      header("Location: ../error.php?ErrorMSG=Bad%20request!3");
      die();
    }

    $thread->load_thread_by_title($title);
    $threadID = $thread->get_id();
    $description = $thread->get_description();
    header("Location: ../displaythread.php?threadID=$threadID&threadTitle=$title&description=$description");
    die();

?>
