<?php
class Session{
  
  private static $vars = array();
  public static $usuario = array();
  public static $id;
  
  public static function criar($usuario, $senha, $permissao){
    
    $query = "SELECT id AS uid FROM mb_usuarios_admin WHERE email = '".$usuario."' AND senha = '".md5($senha)."'";
    $db= Database::getConnection();
    $stmt= $db->query($query);
    if(!$stmt){
      print_r($db->errorInfo());
      return false;
    }
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$usuario){
      echo $query;
      exit("usuario ou senha incorreto.");
      return false;
    }
    $sid = md5(mt_rand());
    self::$usuario= $usuario;
    self::$id= $sid;
    $query = "INSERT INTO mb_sessoes (id, usuario, data_ini) VALUES ('".$sid."', '".$usuario['uid']."', '".date('Y-m-d h:i:s')."')";

    if(!$db->query($query)){
      
      print_r($db->errorInfo());
      return false;
    }
    setcookie('id_sessao', $sid, 0, "/meubonus/admin");    
    return true;
  }
  
  public static function encerrar(){
    
    setcookie('id_sessao', $sid, time() - 1, "/meubonus/admin");
    return true;
  }
  
  public static function getVar($nome){
   
    if(!isset(self::$vars[$nome]))
      return null;
      
    return self::$vars[$nome];
  }
  
  public static function setVar($nome, $valor){
    
    $db= Database::getConnection();
    $query = "INSERT INTO mb_vars_sessao (id_sessao, nome, valor) VALUES ('".self::$id."', '".$nome."', '".$valor."') ON DUPLICATE KEY UPDATE valor=".$valor;
    
    if(!$db->query($query)){  
      print_r($db->errorInfo());
      exit("");
      return false;
    }
    return true;
  }
  
  public static function verificar(){
    

    if(!isset($_COOKIE['id_sessao'])){

      return false;
    }
    $db= Database::getConnection();
    $sid = preg_replace("[^0-9A-Za-z]", "", $_COOKIE['id_sessao']);
    $query = "SELECT u.id AS uid, u.nome FROM mb_sessoes s INNER JOIN mb_usuarios_admin u ON s.usuario = u.id WHERE s.id = '".$sid."'";
    $stmt= $db->query($query);
    if(!$stmt){
      
      print_r($db->errorInfo());
      return false;
    }
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$usuario){
      
      echo "usuario nao encontrado.";
      return false;
    }    
    self::$usuario = $usuario;
    self::$id = $sid;
    $query = "SELECT nome, valor FROM mb_vars_sessao WHERE id_sessao = '".$sid."'";
    $stmt = $db->query($query);
    if(!$stmt){
      
      print_r($db->errorInfo());
      return false;
    }
    
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      
      self::$vars[$result['nome']] = $result['valor'];
    }                                            
    return true;
  }  
}
?>