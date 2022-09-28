<?php
class ControleIndex extends ControleBloco{
  
  public function acesso(){
    
    if( isset($_POST['usuario']) && isset($_POST['senha']) ){
      $usuario= preg_replace("/[^A-Za-z0-9@\._]/", "", $_POST['usuario']);
      $senha= preg_replace("/[^A-Za-z0-9]/", "", $_POST['senha']);
      
      if(!Session::criar($usuario, $senha, 7)){
        print_r($_POST);
        exit("erro");
//        header("location:op.php?c=index&op=acesso");
        return false;
      }
      header("location:?c=index");
    }    
  }
  
  public function header(){

    $mi = new ModelIndex();
    $paginas = $mi->getPaginas(Session::$usuario['permissao']);
    $this->_addDado('paginas', $paginas);
  }
  
  public function index(){

    Renderer::addScript("jquery-1.12.1.min");
    Renderer::addScript("index");
  }
  public function logout(){
    
    Session::encerrar();
    header("location:?c=index&op=acesso");
  }
  
  public function nao_encontrado(){
  
  }
  public function usuarios(){
    
    $mi = new ModelIndex();
    $qry = $_POST["qry"];
//    print_r($_POST);
    $usuarios = $mi->getUsuarios($qry);
    if(!$usuarios){
      
      echo json_encode(array("erro"=>$mi->erro));
      return false;
    }
    echo json_encode(array("OK"=>$usuarios));
  }
}
?>