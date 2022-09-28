<?php
class ControleBloco{
  
  private $session;
  private $_renders = array();
  private $_dados = array();
  private $_titulo_pagina = "";
  
  public function _addDado($nome, $dado){
    
    $this->_dados[$nome] = $dado;
  }
  public function _addErro($erro){
    
    if(!isset($this->_dados['erro']))
      $this->_dados['erro'] = array();
    
    $this->_dados['erro'][] = $erro;
  }  
  public function _getDados(){
    
    return $this->_dados;
  }
  public function _getRenders(){
    
    return $this->_renders;
  }
  public function _getTitulo(){
    
    return $this->_titulo_pagina;
  }
  public function nao_encontrado(){
    echo "pagina nao encontrada!";
  }  
  public function _render($template){
    
    $this->_renders[] = $template;
  }
  public function _setTitulo($titulo){
    
    $this->_titulo_pagina = $titulo;
  }
}

class ModelBloco{
 
}
?>