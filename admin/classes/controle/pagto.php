<?php
class ControlePagto extends ControleBloco{
	
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
  
  public function addPagto(){
    
    $pagto = array();
//    print_r($_FILES);
    if(!isset($_POST['data']) || !preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $_POST['data'])){
      
      echo json_encode(array("erro"=>"data invalida"));
      return false;
    }
    $pagto['data'] = $_POST['data'];
    if(!isset($_POST['usuario']) || (int)$_POST['usuario'] < 1){
      
      echo json_encode(array("erro"=>"usuario invalido"));
      return false;
    }
    $pagto['usuario'] = (int)$_POST['usuario'];
    if(!isset($_POST['valor']) || (int)$_POST['valor'] < 1){
      
      echo json_encode(array("erro"=>"valor invalido"));
      return false;
    }
    $pagto['valor'] = ((int)$_POST['valor'])/100.0;
    if(!isset($_POST['dets'])){
      
      echo json_encode(array("erro"=>"itens nao informados"));
      return false;
    }
    $dets = json_decode($_POST['dets']);
    if(count($dets) < 1){
      
      echo json_encode(array("erro"=>"detalhes invalidos"));
      return false;
    }
    $pagto['dets'] = array();
    foreach($dets as $det){
      
      if(!isset($det->valor) || (int)$det->valor < 1 || !isset($det->descricao)){
        
        echo json_encode(array("erro"=>"valor do det invalido"));
        return false;
      }
      $ndet = array("valor"=>((int)$det->valor)/100, "descricao"=>$det->descricao, "arquivo"=>"");
      if($det->arquivo > 0){
        
        $ndet["arquivo"] = array("tipo"=>$_FILES["arquivo".$det->arquivo]["type"], "conteudo"=>file_get_contents($_FILES["arquivo".$det->arquivo]["tmp_name"]), "nome"=>$_FILES['arquivo'.$det->arquivo]["name"]);
      } 
      $pagto['dets'][] = $ndet;
    }
    
    $mp = new ModelPagto();
    $pgt = $mp->addPagto($pagto);
    if(!$pgt){
      
      echo json_encode(array("erro"=>$mp->erro));
      return false;
    }
    echo json_encode(array("OK"=>$pgt));
    return true;
  }
  
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
}
?>