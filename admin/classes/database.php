<?php
class Database{
  
  private static $db;
  private $connection;
  
  public static function getConnection(){
    
    if(self::$db == null){
      //echo "novo PDO<br>";
      self::$db= new PDO('mysql:host='.DB_HOST.';dbname='.DB_DBNAME.';port='.DB_PORT.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
      if(!self::$db){
        
        print_r(self::$db->errorInfo());
      }
    }
    return self::$db;
  }
}
?>