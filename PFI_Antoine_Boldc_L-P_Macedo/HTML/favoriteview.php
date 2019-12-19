
<h3 class="my-4">Favorites</h3>
<?php

    $favs = sort_fav_cookies();

    foreach($favs as $k => $v){
        $thread = new thread();
        $thread->load_thread_by_id($k);
        $thread->display_thread();
    }

    var_dump($_COOKIE);

?>