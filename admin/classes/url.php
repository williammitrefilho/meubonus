<?php
class URL{
  
  public static function criar($link){
    
    $pts = explode("/", $link);
    
    $url = "?c=".$pts[0]."&op=".$pts[1];
    return $url;
  }  
}
?>