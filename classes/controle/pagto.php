<?php
class ControlePagto extends ControleBloco{
	
  
  public function arquivo(){
    
    if(!isset($_GET['codigo']) || (int)$_GET['codigo'] < 1){
      
      $this->_addDado("erro", "arquivo nao encontrado.");
    }
    $mp = new ModelPagto();
    $arquivo = $mp->getArquivo((int)$_GET['codigo']);
    if($arquivo === false){
      
      $this->_addDado("erro", "erro".$mp->erro);
      return false;
    }
    if(!$arquivo ){
      
      $this->_addDado("erro", "arquivo nao encontrado");
      return false;
    }
    Renderer::disable(true);
    header("Content-type:".$arquivo['tipo']);
    echo $arquivo['conteudo'];
    
    return true;
  }
  
	public function index(){

    $params = array();
    $erro = "";
    $dias = 7;
    $data_ini = "";
    $data_fin = date("Y-m-d");
    if(isset($_GET['dias']) && (int)$_GET['dias'] > 1){
      
      $dias = (int)$_GET['dias'];
    }
    $data_ini = date("Y-m-d", time() - $dias*86400);
    $params['data_ini'] = $data_ini;
    $params['data_fin'] = $data_fin;
    
    $mp= new ModelPagto();
    $pagtos = $mp->getPagtos($params);
    if($pagtos === false){
      
      $erro = $mp->erro;
      $this->_addDado("erro", $erro);
      return false;
    }
    $this->_addDado("erro", $erro);
    $this->_addDado("pagtos", $pagtos);
    $this->_addDado("dias", $dias);
    
    Renderer::addScript("jquery-1.12.1.min");
    Renderer::addScript("sistema");
    Renderer::addScript("index-pagto");
    
    return true;        
	}
  
  public function novo(){
    
    Renderer::addScript("jquery-1.12.1.min");
    Renderer::addScript("sistema");
    Renderer::addScript("novo");    
  }
}
?>