<?php
class ControleConta extends ControleBloco{
	
	public function index(){



	}

	public function consultaExtrato(){

		if(!isset($_GET['tipo_conta']) || (int)$_GET['tipo_conta'] < 1){

			echo json_encode(["erro"=>"conta invalida"]);
			return false;
		}
		Renderer::addScript("jquery-1.12.1.min");
		if(isset($_GET['dias']) && $_GET['dias'] != ""){

			if((int)$_GET['dias'] < 1){

				echo json_encode(["erro"=>"numero de dias invalido"]);
				return false;
			}
			$data_fin= date("Y-m-d");
			$data_ini= date("Y-m-d", time() - (int)$_GET['dias']*86400);
			$mc= new ModelConta();
			$extrato= $mc->getExtrato(Session::$usuario['uid'], (int)$_GET['tipo_conta'], $data_ini, $data_fin);
			if($extrato === false){

				echo json_encode(["erro"=>$mc->erro]);
				return false;
			}
			$this->_addDado("extrato", $extrato);
			return true;
		}
		if(isset($_GET['data_ini']) && isset($_GET['data_fin'])){

			if(!preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $_GET['data_ini'])){

				echo "data inicial invalida.";
				return false;
			}
			if(!preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $_GET['data_fin'])){

				echo "data final invalida.";
				return false;
			}
			$mc= new ModelConta();
			$extrato= $mc->getExtrato(Session::$usuario['uid'], (int)$_GET['tipo_conta'], $_GET['data_ini'], $_GET['data_fin']);
			if($extrato === false){

				echo json_encode(["erro"=>$mc->erro]);
				return false;
			}
			$this->_addDado("extrato", $extrato);
			return true;
		}
	}

	public function extrato(){

		if(!isset($_GET['tipo_conta']) || (int)$_GET['tipo_conta'] < 1){

			echo json_encode(["erro"=>"conta invalida"]);
			return false;
		}
		if(isset($_GET['dias'])){

			if((int)$_GET['dias'] < 1){

				echo json_encode(["erro"=>"numero de dias invalido"]);
				return false;
			}
			$data_fin= date("Y-m-d");
			$data_ini= date("Y-m-d", time() - (int)$_GET['dias']*86400);
			$mc= new ModelConta();
			$extrato= $mc->getExtrato(Session::$usuario['uid'], (int)$_GET['tipo_conta'], $data_ini, $data_fin);
			if($extrato === false){

				echo json_encode(["erro"=>$mc->erro]);
				return false;
			}
			echo json_encode($extrato);
			return true;
		}
	}

	public function resumo(){

		$mc= new ModelConta();
		$resumo= $mc->getResumo(Session::$usuario['uid']);
		$this->_addDado("resumo", $resumo);
	}

	public function ultimos(){

		if(!isset($_GET['tipo_conta']) || (int)$_GET['tipo_conta'] < 1){

			echo json_encode(["erro"=>"conta invalida"]);
			return false;
		}
		$mc= new ModelConta();
		$extrato= $mc->getUltimos(Session::$usuario['uid'], (int)$_GET['tipo_conta']);
		if($extrato === false){

			echo json_encode(["erro"=>$mc->erro]);
			return false;
		}
		echo json_encode($extrato);
		return true;	
	}
}
?>