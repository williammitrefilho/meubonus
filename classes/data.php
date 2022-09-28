<?php
class Data{
  
  public static function getTS($data){
    
    $pts= explode("-", $data);
    return mktime(12, 0, 0, $pts[1], $pts[2], $pts[0]);
  }
}
?>