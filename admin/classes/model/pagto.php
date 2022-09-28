<?php
class ModelPagto extends ModelBloco{
	
	public function addPagto($pagto){
    
    $db= Database::getConnection();
    $query = "INSERT INTO mb_pagtos (data, usuario, valor) VALUES ('".$pagto['data']."', '".$pagto['usuario']."', '".$pagto['valor']."');";
    if(!$db->query($query)){
      
      $this->erro = join(";", $db->errorInfo());
      return false;
    }
    $idp = $db->lastInsertId();
    $params=  array();
    $arqs=  array();
    $qarqs = "";
    $narqs = 0;
    $aparams = array();
    foreach($pagto['dets'] as $det){
      
      if($det['arquivo'] != ""){
      
        $qarqs .= "('2', '".$det['arquivo']['tipo']."', ?, ?),";
        $aparams[] = $det['arquivo']['conteudo'];
        $aparams[] = $det['arquivo']['nome'];
        $narqs ++;
      }
    }

    if($narqs > 0){
      
      $qarqs = "INSERT INTO mb_arquivos (local, tipo, conteudo, nome) VALUES ".rtrim($qarqs, ",");
      $stmt = $db->prepare($qarqs);
      if(!$stmt->execute($aparams)){
        
        $this->erro = join(";", $db->errorInfo()).join($stmt->errorInfo());
        return false;  
      }
      $idarq = $db->lastInsertId();
//      echo "idarq:".$idarq." - lastinsert:".$db->lastInsertId()." - narqs:".$narqs."\n";
    }

    $query = "INSERT INTO mb_detpagto (pagto, descricao, valor, arquivo) VALUES ";
    
    foreach($pagto['dets'] as $det){
      
      $params[] = $det['descricao'];
      $query .= "('".$idp."', ?, '".$det['valor']."', ".($det['arquivo'] != "" ? "'".$idarq++."'" : "NULL")."),";
    }
    
    $query = rtrim($query, ",");
//    echo $query;
    $stmt = $db->prepare($query);
    if(!$stmt->execute($params)){
      
      $this->erro = join(";", $db->errorInfo()).join($stmt->errorInfo());
      return false;
    }
    return $idp;
  }
  
  public function getArquivo($codigo){
    
    $db= Database::getConnection();
    
    $query = "SELECT tipo, conteudo FROM mb_arquivos WHERE id = '".$codigo."'";
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
    
    $query = "SELECT p.*, u.nome FROM mb_pagtos p INNER JOIN mb_usuarios u ON u.id = p.usuario WHERE data >= '".$params['data_ini']."' AND data <= '".$params['data_fin']."';";

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
    $query = "SELECT dp.* FROM mb_detpagto dp INNER JOIN mb_pagtos p ON p.id = dp.pagto WHERE p.data >= '".$params['data_ini']."' AND p.data <= '".$params['data_fin']."';";
    
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