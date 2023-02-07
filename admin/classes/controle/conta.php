<?php
class ControleConta extends ControleBloco{
	
	public function index(){



	}

	public function incluirRegistro(){

//    print_r($_POST);
		if(!isset($_POST['conta']) || (int)$_POST['conta'] < 1){

			echo json_encode(array("erro"=>"conta invalida"));
			return false;
		}
		if(!isset($_POST['valor'])){

			echo json_encode(array("erro"=>"valor invalido"));
			return false;
		}
		if(!isset($_POST['rubrica']) || (int)$_POST['rubrica'] < 1){

			echo json_encode(array("erro"=>"rubrica invalida"));
			return false;
		}
/*		if(!isset($_GET['data']) || !preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $_GET['data'])){

			echo json_encode(array("erro"=>"data invalida"));
			return false;
		}*/
		$obs= "";
		if(!isset($_POST["tipo"]) || (int)$_POST['tipo'] < 1){

			echo json_encode(array("erro"=>"tipo invalido"));
			return false;
		}
		if(isset($_POST['obs'])){
			$obs = $_POST['obs'];
		}
		$valor= "";
		if((int)$_POST['tipo'] == 1){
			$valor= $_POST['valor']/100;
		}
		else if((int)$_POST['tipo'] == 2){

			$valor= -$_POST['valor']/100;
		}

//		return true;

		$mc= new ModelConta();
		$idr= $mc->incluirRegistro(date("Y-m-d"), (int)$_POST['conta'], (int)$_POST['rubrica'], $valor, $obs);
		if(!$idr){

			echo json_encode(array("erro"=>$mc->erro));
			return false;
		}
		echo json_encode(array("registro"=>$idr));
		return true;
	}

	public function saldos(){

		if(!isset($_GET['usuario']) || (int)$_GET['usuario'] < 1){

			echo json_encode(["erro"=>"usuario invalido"]);
			return false;
		}
		$mc= new ModelConta();
		$saldos= $mc->getSaldos((int)$_GET['usuario']);
		if(!$saldos){

			echo json_encode(array("erro"=>$mc->erro));
			return false;
		}
		echo json_encode($saldos);
		return true;
	}

	public function resumo(){

		$mc= new ModelConta();
		$resumo= $mc->getResumo(Session::$usuario['uid']);
		$dados= $mc->getDadosForm();
		
		$this->_addDado("tipos_conta", $dados["tipos_conta"]);
		$this->_addDado("rubricas", $dados["rubricas"]);
		$this->_addDado("colaboradores", $dados["colaboradores"]);
		$this->_addDado("resumo", $resumo);
	}

	public function verExtrato(){
    
    $erro = "";
    $data_ini = "";
    $data_fin = "";

    if(!isset($_GET['conta']) || (int)$_GET['conta'] < 1){
      
      $erro = "conta invalida.";
    }
    
    if(!isset($_GET['dias']) || (int)$_GET['dias'] < 1){
      
      if(!isset($_GET['data_ini']) || !preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $_GET['data_ini'])){
        
        $erro = "data inicial invalida.";
      }
      else if(!isset($_GET['data_fin']) || !preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $_GET['data_fin'])){
        
        $erro = "data final invalida.";        
      }
      $data_ini = $_GET['data_ini'];
      $data_fin = $_GET['data_fin'];
    } else{
      
      $data_fin = date("Y-m-d");
      $data_ini = date("Y-m-d", time() - (int)$_GET['dias']*86400);
    }
    
    $mc = new ModelConta();
    $extrato = $mc->getExtrato((int)$_GET['conta'], $data_ini, $data_fin);
    if($extrato === false){
      
      $erro = $mc->erro;
      return false;
    }
    $this->_addDado("erro", $erro);
    $this->_addDado("extrato", $extrato);
    $this->_addDado("data_ini", $data_ini);
    $this->_addDado("data_fin", $data_fin);
    Renderer::addScript("jquery-1.12.1.min");
    
    if(isset($_GET['aj']) && $_GET['aj'] == 'sim'){
      
      if($erro != ""){
        
        echo json_encode(array("erro"=>$erro));
      }
      else{
        
        echo json_encode(array("OK"=>$extrato)); 
      }
    } 
  }
}
?>
