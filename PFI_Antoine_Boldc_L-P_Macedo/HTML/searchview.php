<?php
    include "CLASSES/THREAD/thread.php";
    include __DIR__ . "/../UTILS/sessionhandler.php";
    $thread = new Thread();
    $thread->load_thread_by_id($_GET["search"]);
    $thread_list = Thread::search_thread($_GET["search"]);
    $user_list = User::search_user($_GET["search"]);
?>

<h1 class="my-4">Search results:</h1>
<h2 class="my-4">Albums:</h2>
<?php
  foreach($thread_list as $thread){
    $thread->display_thread();
  }
?>
<h2 class="my-4">Users:</h2>
<?php
  foreach($user_list as $user){
    $user->display_user();
  }
?>
<h2 class="my-4">Images:</h2>
<?php
  $thread->display_images();
?>

