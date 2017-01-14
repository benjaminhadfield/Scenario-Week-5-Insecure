<section class="container">

  <h1>Edit Profile</h1>

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
      <label for="username">Change Username</label>
      <input id="username" class="form-control" name="username" type="text" min="3" max="10" value="<?php echo $_POST['username'] ?>">
    </div>

    <hr>

    <div class="form-group">
      <label for="current-password">Current Password</label>
      <input id="current-password" class="form-control" name="current-password" type="password" min="6">

      <label for="password1">New Password</label>
      <input id="password1" class="form-control" name="password1" type="password" min="6">

      <label for="password2">Confirm New Password</label>
      <input id="password2" class="form-control" name="password2" type="password" min="6">
    </div>

    <hr>

    <div class="form-group">
      <label for="colour">Profile Colour</label>
      <input id="colour" class="form-control" name="colour" type="color" value="<?php echo $_SESSION['user']->colour ?>" style="height: 50px">
    </div>

    <a href="?controller=pages&action=home" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </form>
</section>