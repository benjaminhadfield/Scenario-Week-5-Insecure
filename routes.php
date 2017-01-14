<?php

function call($controller, $action) {
  // require file matching controller name
  require_once('controllers/' . $controller . '_controller.php');

  // create a new instance of the controller
  switch($controller) {
    case 'pages':
      $controller = new PagesController();
      break;
    case 'blog':
      require_once('models/blog.php');
      $controller = new BlogController();
      break;
    case 'account':
      require_once('models/account.php');
      $controller = new AccountController();
      break;
    case 'admin':
      $controller = new AdminController();
      break;
  }

  // call the action
  $controller->{ $action }();
}

// list of controllers and their actions
// these are our allowed values
$controllers = array(
  'pages' => ['home', 'error'],
  'blog' => ['index', 'show', 'create'],
  'account' => ['register', 'login', 'logout', 'edit'],
  'admin' => ['stats'],
);

// check the requested controller and action are both valid
if (array_key_exists($controller, $controllers)) {
  if (in_array($action, $controllers[$controller])) {
    call($controller, $action);
  } else {
    call('pages', 'error');
  }
} else {
  call('pages', 'error');
}
