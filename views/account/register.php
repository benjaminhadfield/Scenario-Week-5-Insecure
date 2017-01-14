
<section class="container">
  <h1>Register</h1>

  <?php if ($errors) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <?php foreach($errors as $error) { ?>
        <p class="mb-0"><?php echo $error; ?></p>
      <?php } ?>
    </div>
  <?php }?>

  <form method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input id="username" class="form-control" name="username" type="text" min="3" max="10" value="<?php echo $_POST['username'] ?>">
    </div>

    <div class="form-group">
      <label for="password1">Password</label>
      <input id="password1" class="form-control" name="password1" type="password" min="6">
    </div>

    <div class="form-group">
      <label for="password2">Confirm Password</label>
      <input id="password2" class="form-control" name="password2" type="password" min="6">
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</section>