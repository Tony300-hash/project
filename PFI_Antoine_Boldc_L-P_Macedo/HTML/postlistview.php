<?php
    include "CLASSES/THREAD/thread.php";
    include __DIR__ . "/../UTILS/sessionhandler.php";
    $thread = new Thread();
    $thread->load_thread_by_id($_GET["threadID"]);
    $thread->load_posts();
?>

<h3 class="mb-4"><?php echo $_GET["threadTitle"]; ?></h3>
<h2 class="mb-4"><?php echo $_GET["description"]; ?></h2>
<?php 
$thread->display_images();
if(validate_session()&& $thread->get_authorID() == $_SESSION["userID"])
{
    ?>
    <div class="container">

     <form method = "post" action = "DOMAINLOGIC/createimage.dom.php" enctype="multipart/form-data">
      <input type="hidden" name="threadID" id="threadID" value="<?php echo $_GET["threadID"] ?>" required>
      

      <div class="form-group">
                    <label for="title">Titre:</label>
                    <input type="text" class="form-control" name="title" id="title"><br>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
        <div class="form-group">
                  <label for="Media">Image</label>
                  <input type="file" class="form-control" name="image" id="image"><br>
                  <div class="valid-feedback">Valid.</div>
                  <div class="invalid-feedback">Please fill out this field.</div>
                </div>
      <div class="btn-group">
        <button class="btn btn-success btn-lg mb-4" type="submit">Post that stuff!</button>
      </div>

    
     </form>

    </div>
<?php }$thread->display_posts(); ?>
