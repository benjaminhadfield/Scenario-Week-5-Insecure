<?php
class AdminController {
  public function stats() {
    if (isset($_SESSION['user'])) {
      require_once('views/admin/view_stats.php');
    } else {
      call('pages', 'home');
    }
  }
}