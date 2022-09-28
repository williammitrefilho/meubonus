<?php
class ModelIndex extends ModelBloco{

  public function getPaginas($permissao= 7){
    
    $db= Database::getConnection();
    $query = "SELECT * FROM mb_paginas WHERE status=1 AND permissao <= '".$permissao."' ORDER BY ordem";
    $stmt = $db->query($query);
    if(!$stmt){
      
      $this->erro = join(";", $db->errorInfo());
      return false;
    }
    $ret = array();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      
      $ret[] = $result;
    }
    return $ret;
  }  
}
?>