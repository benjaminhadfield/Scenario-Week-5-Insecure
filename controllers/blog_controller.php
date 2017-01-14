<?php
session_start();

class BlogController {
  public function index() {
    $search_term = $_GET['search'];

    if (!$search_term) {
      $blogs = Blog::all();
    } else {
      $blogs = Blog::filter($search_term);
    }
    require_once('views/blog/index.php');
  }

  public function show() {
    if (!isset($_GET['id'])) {
      call('pages', 'error');
    } else {
      require_once('models/account.php');
      $blog = Blog::find($_GET['id']);
      $author = Account::getUser(intval($blog->author));
      require_once('views/blog/show.php');
    }
  }

  public function create() {
    require_once('controllers/utils/authentication/auth.php');
    require_once('models/account.php');

    if (!is_admin()) {
      call('account', 'login');
      return;
    }

    $errors = [];

    // htmlspecialchars to encode user input and prevent XSS attacks.
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $user_id = Account::getUser($_SESSION['user']->username)->id;

    if ($title && $content) {
      $created = Blog::create($title, $content, $user_id);
      if ($created) {
        $this->index();
        return;
      }
    } else if ($title || $content) {
      array_push($errors, 'Please fill out both the title and content fields.');
    }

    require_once('views/blog/create.php');
  }
}