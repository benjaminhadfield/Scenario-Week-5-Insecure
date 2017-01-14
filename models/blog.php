<?php
class Blog {
  public $id;
  public $author;
  public $title;
  public $content;
  public $created;

  public function __construct($id, $author, $title, $content, $created) {
    $this->id = $id;
    $this->author = $author;
    $this->title = $title;
    $this->content = $content;
    $this->created = $created;
  }

  public static function all() {
    $list = [];
    $db = Db::getInstance();
    $req = $db->query('SELECT * FROM blog ORDER BY created DESC;');

    // populate list from DB results
    foreach($req->fetchAll() as $blog) {
      $list[] = new Blog($blog['id'], $blog['author'], $blog['title'], $blog['content'], $blog['created']);
    }

    return $list;
  }

  public static function filter($query) {
    $list = [];
    $db = Db::getInstance();
    // validate
    $query = strval($query);
    // make an insecure SQL statement using the unencoded query value
    echo 'SELECT * FROM blog WHERE title LIKE \'%'. $query .'%\' ORDER BY created DESC;';
    $req = $db->query('SELECT * FROM blog WHERE title LIKE \'%'. $query .'%\' ORDER BY created DESC;');

    // populate list from DB results
    foreach($req->fetchAll() as $blog) {
      $list[] = new Blog($blog['id'], $blog['author'], $blog['title'], $blog['content'], $blog['created']);
    }

    return $list;
  }

  public static function find($id) {
    $db = Db::getInstance();
    // validate
    $id = intval($id);
    // make an insecure SQL statement using the unencoded query value
    $req = $db->query('SELECT * FROM blog WHERE id = ' . $id);
    $blog = $req->fetch();

    if ($blog) {
      return new Blog($blog['id'], $blog['author'], $blog['title'], $blog['content'], $blog['created']);
    } else {
      return false;
    }
  }

  public static function create($title, $content, $user_id) {
    $db = Db::getInstance();

    $title = strval($title);
    $content = strval($content);
    $user_id = intval($user_id);

    // Don't encode the content or title values, opening door to SQL injection and XSS attacks.
    $req = $db->query('INSERT INTO blog (title, content, author) VALUES (\'' . $title . '\', \'' . $content . '\', \'' . $user_id . '\');');

    $success = $req->execute();

    return $success;
  }
}
