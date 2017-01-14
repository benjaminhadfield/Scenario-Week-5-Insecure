<?php
class PagesController {
  public function home() {
    $search_term = $_GET['search'];

    if (!$search_term) {
      require_once('views/pages/home.php');
    } else {
      call('blog', 'index');
    }

  }

  public function error() {
    require_once('views/pages/error.php');
  }
}