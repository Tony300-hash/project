<?php
    include __DIR__ . "/../CLASSES/Media/media.php";
    include __DIR__ . "/../UTILS/sessionhandler.php";

    session_start();

    if(!validate_session()){
        header("Location: ../error.php?ErrorMSG=Not%20logged%20in!");
        die();
    }

    if(!isset($_POST["imageID"])){
        header("Location: ../error.php?ErrorMSG=Bad%20Requests!");
        die();
    }

    $image = new media();
    $image->load_image($_POST["imageID"]);

    //$post->set_content($_POST['content']);
    $image->delete();

    header("Location: ../billboard.php");
    die();

