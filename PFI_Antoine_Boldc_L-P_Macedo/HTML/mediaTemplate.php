<div class="container">
  <div class="card-header text-left">
    <h4><?php 
    $str = substr($authorurl,3);
    echo "<img src='$str' alt='' height='15%' width='15%'>" . $author . " - " . $title . " - " . date("Y-m-d",$creation)?></h4>
  </div>
  <div class="card-body text-left">
    <?php
     $ext = pathinfo($url ,PATHINFO_EXTENSION);
     $string = substr($url,3);
     echo "<img src='$string' alt='$title#$id' height='100%' width='100%'>";
     ?>
  </div>

<?php 

  if(isset($_SESSION["userID"]) && $authorID == $_SESSION["userID"]){

    echo "<div class='card-footer text-left'>
    <button class='btn btn-secondary mb-2' data-toggle='collapse' data-target='#col$id'>Edit image</button>
    <div id='col$id' class='collapse'>

    


    <form method = 'post' action = 'DOMAINLOGIC/deleteimage.dom.php'>

      <input type='hidden' name='imageID' value='$id'>
      <button class='btn btn-danger mb-2' type='submit'>Delete image</button>

    </form>
    </div>
    </div>";

  }
  ?>

</div>



