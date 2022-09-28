<?php
class ControleIndex extends ControleBloco{
  
  public function acesso(){
    
    if( isset($_POST['usuario']) && isset($_POST['senha']) ){
      $usuario= preg_replace("/[^A-Za-z0-9@\._\-]/", "", $_POST['usuario']);
      $senha= preg_replace("/[^A-Za-z0-9]/", "", $_POST['senha']);
      $this->_addDado("erro", "");
      if(!Session::criar($usuario, $senha, 1)){
//        header("location:op.php?c=index&op=acesso");
        $this->_addDado("erro", "Usuario ou senha incorreto.");
        return false;
      }
      header("location:?c=index");
    }    
  }
  
  public function header(){

    $mi = new ModelIndex();
    $paginas = $mi->getPaginas(Session::$usuario['permissao']);
    $this->_addDado('paginas', $paginas);
    
    Renderer::addScript("jquery-1.12.1.min");
    Renderer::addScript("janelas-consulta");
    Renderer::addScript("index-header");
  }
  
  public function index(){

    Renderer::addScript("jquery-1.12.1.min");
    Renderer::addScript("janelas-consulta");
    Renderer::addScript("index");
  }
  public function logout(){
    
    Session::encerrar();
    header("location:?c=index&op=acesso");
  }
  
  public function nao_encontrado(){
  
  }
}
?>