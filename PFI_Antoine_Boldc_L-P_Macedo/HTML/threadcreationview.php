<div class="container border">
  <h3 class="my-4">Create thread </h3>
  <form method = "post" action = "./DOMAINLOGIC/threadcreate.dom.php">
      <div class="form-group">
          <input type="text" class="form-control" name="threadcreationtitre" id="threadcreationtitre" placeholder="Title" required><br>
          <input type="text" class="form-control" name="threadcreationdesc" id="threadcreationdesc" placeholder="Descripton" required><br>
          <div class="valid-feedback">Valid.</div>
      </div>
      <button class="btn btn-success btn-lg mb-4" type="submit">Create Thread</button>
  </form>
</div>
