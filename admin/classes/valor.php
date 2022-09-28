<?php
class Valor{

  public static function formatReal($valor){
    
    $pts = explode(".", $valor);

    if(count($pts) < 2)
      return $pts[0].",00";
    while(strlen($pts[1]) < 2)
      $pts[1] .= "0";  
    if(strlen($pts[1]) > 2)
      $pts[1] = substr($pts[1], 0, 2);
      
    return $pts[0].",".$pts[1];  
  }
}
?>