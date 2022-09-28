<?php
class ModelPagto extends ModelBloco{
	
  
  public function getArquivo($codigo){
    
    $db= Database::getConnection();
    
    $query = "SELECT a.tipo, a.conteudo FROM mb_arquivos a INNER JOIN mb_detpagto dp ON dp.arquivo = a.id INNER JOIN mb_pagtos p ON p.id = dp.pagto WHERE a.id = '".$codigo."' AND p.usuario = '".Session::$usuario['uid']."'";
    $stmt= $db->query($query);
    if(!$stmt){
      
      $this->erro = join(";", $db->errorInfo());
      return false;
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;     
  }
  public function getPagtos($params){
    
    $db= Database::getConnection();
    
    $query = "SELECT * FROM mb_pagtos WHERE usuario = '".Session::$usuario['uid']."' AND data >= '".$params['data_ini']."' AND data <= '".$params['data_fin']."';";

    $stmt= $db->query($query);
    if(!$stmt){
      
      $this->erro = join(";", $db->errorInfo());
      return false;
    }
    $ret = array();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      
      $result['dets'] = array();
      $ret[$result['id']] = $result;
    }
    $query = "SELECT dp.* FROM mb_detpagto dp INNER JOIN mb_pagtos p ON p.id = dp.pagto WHERE p.usuario = '".Session::$usuario['uid']."' AND p.data >= '".$params['data_ini']."' AND p.data <= '".$params['data_fin']."';";
    
    $stmt= $db->query($query);
    if(!$stmt){
      
      $this->erro = join(";", $db->errorInfo());
      return false;
    }
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      
      $ret[$result['pagto']]['dets'][] = $result;
    }
    return $ret;    
  } 
}
?>