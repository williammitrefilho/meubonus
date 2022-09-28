<?php
class ModelConta extends ModelBloco{
	
	public function getResumo($usuario){

		$db= Database::getConnection();
		$query= "SELECT c.tipo, c.saldo, tc.nome FROM mb_contas c INNER JOIN mb_tipos_conta tc ON tc.id= c.tipo WHERE c.usuario= '".$usuario."';";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$ret= array();
		while($result= $stmt->fetch(PDO::FETCH_ASSOC)){

			$ret[] = $result;
		}
		return $ret;
	}

	public function getExtrato($usuario, $conta, $data_ini, $data_fin){

		$db= Database::getConnection();
		$query= "SELECT r.data, ru.nome, r.valor, r.obs FROM mb_registros r INNER JOIN mb_rubricas ru ON ru.id= r.rubrica INNER JOIN mb_contas c ON c.id= r.conta WHERE c.tipo='".$conta."' AND c.usuario='".$usuario."' AND data >='".$data_ini."' AND data<='".$data_fin."' ORDER BY r.data ASC, r.valor DESC";
//		echo $query;
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$ret= array();
		$soma=0;
		while($result= $stmt->fetch(PDO::FETCH_ASSOC)){

			$ret[] = $result;
			$soma += $result['valor'];
		}
		$query= "SELECT saldo - (SELECT ROUND(IFNULL(SUM(r.valor), 0), 2) FROM mb_registros r INNER JOIN mb_contas c ON c.id= r.conta WHERE c.tipo='".$conta."' AND c.usuario='".$usuario."' AND r.data > '".$data_fin."') AS saldo FROM mb_contas WHERE usuario= '".$usuario."' AND tipo='".$conta."';";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$saldo= $stmt->fetch(PDO::FETCH_ASSOC);
		$saldoIni= $saldo["saldo"] - $soma;
		$extrato= [["data"=>$data_ini, "nome"=>"Saldo Anterior", "saldo"=>$saldoIni]];
		foreach($ret as $registro){

			$saldoIni += $registro['valor'];
			$extrato[] = ["data"=>$registro["data"], "nome"=>$registro["nome"], "valor"=>$registro["valor"], "saldo"=>$saldoIni, "obs"=>$registro["obs"]];
		}

		return $extrato;
	}
	public function getUltimos($usuario, $conta){

		$db= Database::getConnection();
		$query= "SELECT r.data, ru.nome, r.valor, r.obs FROM mb_registros r INNER JOIN mb_rubricas ru ON ru.id= r.rubrica INNER JOIN mb_contas c ON c.id= r.conta WHERE c.tipo='".$conta."' AND c.usuario='".$usuario."' ORDER BY r.data DESC LIMIT 3";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$ret= array();
		$soma=0;
		while($result= $stmt->fetch(PDO::FETCH_ASSOC)){

			$ret[] = $result;
			$soma += $result['valor'];
		}
		$query= "SELECT saldo FROM mb_contas WHERE usuario= '".$usuario."' AND tipo='".$conta."';";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$saldo= $stmt->fetch(PDO::FETCH_ASSOC);
		$saldoIni= $saldo["saldo"] - $soma;
		$extrato= [["data"=>$ret[i], "nome"=>"Saldo Anterior", "saldo"=>$saldoIni]];
		for($i = count($ret); $i > 0; $i--){

			$saldoIni += $ret[$i]['valor'];
			$extrato[] = ["data"=>$ret[$i]["data"], "nome"=>$ret[$i]["nome"], "valor"=>$ret[$i]["valor"], "saldo"=>$saldoIni];
		}
		return $extrato;
	}
}
?>