<header id="user-bar" class="mb-4 py-2 bg-silver">
  <div class="container-fluid">
    <p class="m-0 row">
      <?php if (isset($_SESSION['user'])) { ?>
        <span class="col">Welcome back <strong><?php echo $_SESSION['user']->username ?></strong>!</span>
        <span class="col text-right">
          <a class="mr-4" href="?controller=account&action=edit">Edit profile</a>
          <a href="?controller=account&action=logout">Logout</a>
        </span>
      <?php } else { ?>
        <span class="col">
          <a href="?controller=account&action=login">Login</a> or <a href="?controller=account&action=register">Register</a> to get started.
        </span>
      <?php } ?>
    </p>
  </div>
</header>