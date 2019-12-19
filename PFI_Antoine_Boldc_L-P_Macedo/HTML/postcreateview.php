<div class="container">

  <form method = "post" action = "DOMAINLOGIC/createpost.dom.php">
    <input type="hidden" name="threadID" id="threadID" value="<?php echo $_GET["threadID"] ?>" required>
    <input type="hidden" name="threadTitle" id="threadTitle" value="<?php echo $_GET["threadTitle"] ?>" required>
    <input type="hidden" name="description" id="description" value="<?php echo $_GET["description"] ?>" required>

    <div class="form-group">
            <textarea class="form-control" rows="5" name="content" id="content" placeholder="Got something to say, punk?" required></textarea>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    
    <div class="btn-group">
      <button class="btn btn-success btn-lg mb-4" type="submit">Post that stuff!</button>
      <button class="btn btn-warning btn-lg mb-4" type="reset">Actually, nevermind!</button>
    </div>

    
  </form>

</div>
