<?php

if (getenv('ENV') == 'PRODUCTION') {

  class Db
  {
    private static $instance = NULL;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
      if(!isset(self::$instance)) {
        try {
          $DB_PASSWORD = getenv('DB_PASSWORD');
          $DB_USERNAME = getenv('DB_USERNAME');

          $conn = new PDO("mysql:host=eu-cdbr-azure-north-e.cloudapp.net;dbname=comp205p_ae_secure;", $DB_USERNAME, $DB_PASSWORD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          self::$instance = $conn;

        } catch (PDOException $e) {
          echo("<strong>Error connecting to MySQL.</strong><br>");
          die(print_r($e));
        }
      }
      return self::$instance;
    }
  }

} else {

  // Singleton pattern
  class Db
  {
    private static $instance = NULL;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO('mysql:host=localhost;dbname=ucl_scenario_week_5_secure', 'ucl_sw_5_admin', 'FCQYxUFDWNrCtBYr', $pdo_options);
      }
      return self::$instance;
    }
  }
}
