<?php
    include "./UTILS/cookiemanager.php";
    session_start();

    manage_fav_cookies();
    sort_fav_cookies();

    var_dump($_COOKIE);

?>
