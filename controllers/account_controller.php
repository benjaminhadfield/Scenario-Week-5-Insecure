<?php
session_start();

class AccountController {
  public function register() {
    if (isset($_SESSION['user'])) {
      call('pages', 'home');
      return;
    }

    $errors = [];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ($username && $password1 && $password2) {
      require_once('controllers/utils/form/validation.php');

      // server-side validation
      $passes_username_length = field_above_length($username, 3) && field_below_length($username, 10);
      $passes_password_length = field_above_length($password1, 6);
      $passes_password_match = fields_match($password1, $password2);
      // check username is free
      $passes_unique_username = !Account::getUser($username);

      if ($passes_username_length && $passes_password_length && $passes_password_match && $passes_unique_username) {
        // hash the password
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        // create user account
        $created = Account::register($username, $hashed_password);

        if ($created) {
          $this->login($username, $password1);
          call('pages', 'home');
          return;
        }

      } else {
        if (!$passes_username_length) { array_push($errors, 'Your username needs to be between 3 and 10 characters.'); }
        if (!$passes_password_length) { array_push($errors, 'Your password needs to be at least 6 characters long.'); }
        if (!$passes_password_match) { array_push($errors, 'Your passwords did not match.'); }
        if (!$passes_unique_username) { array_push($errors, 'The username <strong>' . $username . '</strong> is not available.'); }
      }
    }

    require_once('views/account/register.php');
  }

  public function login() {
    if (isset($_SESSION['user'])) {
      call('pages', 'home');
      return;
    }

    $errors = [];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {
      require_once('controllers/utils/form/validation.php');

      $has_username = field_exists($username);
      $has_password = field_exists($password);

      if ($has_username && $has_password) {
        // check user exists
        $user = Account::getUser($username);

        if ($user) {
          // check password is correct
          $verified = password_verify($password, $user->password);

          if ($verified) {
            // set session
            $_SESSION['user'] = (object) [
              'username' => $user->username,
              'is_admin' => $user->is_admin,
              'colour' => $user->colour
            ];

            // call self to get a refresh and activate $_SESSION
            call('pages', 'home');
            return;

          } else {
            array_push($errors, 'Incorrect username or password.');
          }
        } else {
          array_push($errors, 'No account belonging to <strong>' . $username .'</strong> exists :/ Check you entered your username correctly.');
        }
      } else {
        array_push($errors, 'Enter both your username and password to login.');
      }
    }

    require_once('views/account/login.php');
  }

  public function logout() {
    if (isset($_SESSION['user'])) {
      session_unset();
      session_destroy();
      call('pages', 'home');
    }
  }

  public function edit() {
    require_once('controllers/utils/form/validation.php');
    require_once('controllers/utils/authentication/auth.php');

    if (!is_authenticated()) {
      call('account', 'login');
      return;
    }

    $errors = [];

    $user = Account::getUser($_SESSION['user']->username);

    $username = $_POST['username'];
    $current_password = $_POST['current-password'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $colour = $_POST['colour'];

    if ($username) {
      $passes_username_length = field_above_length($username, 3) && field_below_length($username, 10);
      $passes_unique_username = !Account::getUser($username);

      if ($passes_username_length && $passes_unique_username) {
        $success = Account::updateUser($user->username, $username, null);

        if ($success) {
          $_SESSION['user']->username = $username;
          call('pages', 'home');
          return;
        }
      } else {
        if (!$passes_username_length) { array_push($errors, 'Your username needs to be betweeen 3 and 10 characters long.'); }
        if (!$passes_unique_username) { array_push($errors, 'The username ' . $username . ' is already registed to another account.'); }
      }
    }

    if ($current_password && $password1 && $password2) {
      $verified = password_verify($current_password, $user->password);
      echo 'verified: ' . $verified;
      if ($verified) {
        $passes_password_length = field_above_length($password1, 6);
        $passes_password_match = fields_match($password1, $password2);

        if ($passes_password_length && $passes_password_match) {
          // save new hashed password to DB.
          $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
          $success = Account::updateUser($user->username, null, $hashed_password);

          if ($success) {
            call('pages', 'home');
            return;
          }
        }

      } else {
        array_push($errors, 'Check you entered your password correctly and that your new password matches.');
      }
    }

    if ($colour) {
      $has_length = field_has_length($colour, 7);

      if ($has_length) {
        $success = Account::updateUser($user->username, null, null, $colour);
        if ($success) {
          $_SESSION['user']->colour = $colour;
          call('pages', 'home');
          return;
        }
      } else {
        array_push($errors, 'Enter a valid colour value (in form <strong>#rrggbb</strong>).');
      }
    }

    require_once('views/account/edit.php');
  }
}