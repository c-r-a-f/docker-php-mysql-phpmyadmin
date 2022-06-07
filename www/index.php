<?php

define('DSN', 'mysql:host=mysql_host;charset=utf8mb4;');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'test');

function db_connect(){
  date_default_timezone_set('Asia/Tokyo');
  try{
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
    $now = new DateTime();
    $mins = $now->getOffset() / 60;
    $sgn = ($mins < 0 ? -1 : 1);
    $mins = abs($mins);
    $hrs = floor($mins / 60);
    $mins -= $hrs * 60;
    $offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
    $pdo->exec("SET time_zone='$offset';");
    return $pdo;
  } catch (PDOException $e) {
    var_dump($e);
    die();
  }
}

$pdo = db_connect();
echo $pdo->query('SHOW DATABASES')->fetchColumn();

