<?php require_once 'controllers/utils/format/date.php'; ?>

<?php if ($blog) { ?>
  <div class="mb-4">
    <h1 class="mb-0"><?php echo $blog->title ?></h1>
    <small>Published at <strong><?php echo format_date($blog->created); ?></strong> by <strong><?php echo $author->username ?></strong></small>
  </div>
  <p><?php echo $blog->content ?></p>
<?php } else { ?>
  <p>This blog doesn't exist :(</p>
  <a href="?controller=blog&action=index">See All Blogs</a>
<?php } ?>

<a href="?controller=blog&action=index">Back</a>