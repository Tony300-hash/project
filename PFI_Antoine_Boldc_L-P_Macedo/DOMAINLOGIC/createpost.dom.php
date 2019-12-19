<?php
    include __DIR__ . "/../CLASSES/POSTS/post.php";
    include __DIR__ . "/../UTILS/sessionhandler.php";

    session_start();

    if(!validate_session()){
        header("Location: ../error.php?ErrorMSG=not%20logged%20in!");
        die();
    }

    if(!isset($_POST["content"]) || !isset($_POST["threadID"]) || !isset($_POST["threadTitle"])){
      header("Location: ../error.php?ErrorMSG=Bad%20Request");
      die();
    }

    $threadTitle = $_POST["threadTitle"];
    //variables needed to create a post
    $authorID = $_SESSION["userID"];
    $threadID = $_POST["threadID"];
    $content = $_POST["content"];
    $description = $POST["description"];
    $post = new Post();

    if(!$post->add_post($authorID, $threadID, $content)){
      header("Location: ../error.php?ErrorMSG=Bad%20Request");
      die();
    }

    header("Location: ../displayThread.php?threadID=$threadID&threadTitle=$threadTitle&description=$description");
    die();

 ?>
