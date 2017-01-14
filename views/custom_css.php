<?php session_start();

require_once('controllers/utils/authentication/auth.php');

if (is_authenticated()) { ?>
<style type="text/css">
  #user-bar a,
  #user-bar a:link,
  #user-bar a:visited,
  #user-bar a:hover,
  #user-bar a:active,
  #user-bar a:focus {
    color: <?php echo $_SESSION['user']->colour ?> !important;
  }

  button,
  button:active,
  button:focus {
    background-color: <?php echo $_SESSION['user']->colour ?> !important;
  }

  .pc-bg {
    background-color: <?php echo $_SESSION['user']->colour ?> !important;
  }

  .pc-text {
    color: <?php echo $_SESSION['user']->colour ?> !important;
  }
</style>
<?php } ?>
