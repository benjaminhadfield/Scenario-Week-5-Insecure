<section class="container">

  <h1>Create an article</h1>

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
      <label for="title">Title</label>
      <input id="title" class="form-control" name="title" type="text" value="<?php echo $_POST['title'] ?>">
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea id="content" class="form-control" name="content">
        <?php echo $_POST['content'] ?></textarea>
    </div>

    <a href="?controller=blog&action=index" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Create</button>
  </form>
</section>