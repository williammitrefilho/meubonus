<?php
class ModelIndex extends ModelBloco{

  public function getPaginas(){
    
    $db= Database::getConnection();
    $query = "SELECT * FROM mb_paginas_admin WHERE status=1 ORDER BY ordem";
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
  public function getUsuarios($qry){
    
    $db = Database::getConnection();
    
    $query = "SELECT id, nome FROM mb_usuarios WHERE nome LIKE ?";
    $stmt= $db->prepare($query);
    if(!$stmt){
      
      $this->erro = "PREPARE:".join(";", $db->errorInfo());
      return false;
    }
    if(!$stmt->execute(array("%".$qry."%"))){
      
      $this->erro = "EXEC".join(";", $db->errorInfo());
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