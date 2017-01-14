<?php
class Account {
  public $id;
  public $username;
  public $password;
  public $is_admin;

  public function __construct($id, $username, $password, $colour = '#0276D8', $is_admin = false) {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->is_admin = $is_admin;
    $this->colour = $colour;
  }

  public static function register($username, $password) {
    $db = Db::getInstance();
    $username = strval($username);
    $password = strval($password);

    $req = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password);');
    $req->bindValue(':username', $username);
    $req->bindValue(':password', $password);
    $success = $req->execute();

    return $success;
  }

  public static function updateUser($user_id, $new_username = null, $new_password = null, $new_colour = null) {
    $db = Db::getInstance();

    // check user exists
    $user = Account::getUser($user_id);

    if ($user && ($new_username || $new_password || $new_colour)) {
      $new_values = [];
      $sql = 'UPDATE users SET ';
      if ($new_username) { array_push($new_values, 'username=:username'); }
      if ($new_password) { array_push($new_values, 'password=:password'); }
      if ($new_colour) { array_push($new_values, 'colour=:colour'); }

      $sql .= implode(',', $new_values) . ' WHERE id=:id;';

      $req = $db->prepare($sql);

      $req->bindParam(':id', $user->id, PDO::PARAM_INT);

      if ($new_username) { $req->bindValue(':username', $new_username); }
      if ($new_password) { $req->bindValue(':password', $new_password); }
      if ($new_colour) { $req->bindValue(':colour', $new_colour); }

      $success = $req->execute();
      return $success;
    }

    return false;
  }

  public static function getUser($id) {
    $db = Db::getInstance();

    if (gettype($id) == 'string') {
      $username = strval($id);
      $req = $db->prepare('SELECT * FROM users WHERE username = :username;');
      $req->bindValue(':username', $username);
    } else {
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM users WHERE id = :id');
      $req->bindValue(':id', $id);
    }

    $req->execute();
    $user = $req->fetch();

    if ($user) {
      return new Account($user['id'], $user['username'], $user['password'], $user['colour'], $user['is_admin']);
    } else {
      return false;
    }
  }
}