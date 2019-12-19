<div class="Container">
    <h4><?php echo $title?></h4>
    <?php 
        $ext = pathinfo($url ,PATHINFO_EXTENSION);

        
         echo "<img src='$url' alt='$title#$id'>";
        
    ?>
</div>