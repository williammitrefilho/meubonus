<?php
class ModelConta extends ModelBloco{
	
	public function incluirRegistro($data, $conta, $rubrica, $valor, $obs){

		$db= Database::getConnection();
		$query= "SELECT id, saldo FROM mb_contas WHERE id='".$conta."'";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$ret= $stmt->fetch(PDO::FETCH_ASSOC);
		if(!$ret){

			$this->erro= "conta invalida";
			return false;
		}
		$saldo= $ret['saldo'] + $valor;

		$query= "INSERT INTO mb_registros (data_lancado, data, conta, rubrica, valor, obs) VALUES ('".date("Y-m-d H:i:s")."', '".$data."', '".$ret['id']."', '".$rubrica."', '".$valor."', ?)";
		$stmt = $db->prepare($query);

		if(!$stmt->execute([$obs])){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$idr= $db->lastInsertId();
		$query= "UPDATE mb_contas SET saldo= '".$saldo."' WHERE id= '".$ret['id']."'";
		if(!$db->query($query)){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		return $idr;
	}

	public function getDadosForm(){

		$db= Database::getConnection();
		$query= "SELECT * FROM mb_rubricas";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		$ret= array("rubricas"=>array(), "tipos_conta"=>array(), "colaboradores"=>array());
		while($result= $stmt->fetch(PDO::FETCH_ASSOC)){

			$ret["rubricas"][] = $result;
		}

		$query= "SELECT * FROM mb_tipos_conta";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		while($result= $stmt->fetch(PDO::FETCH_ASSOC)){

			$ret["tipos_conta"][] = $result;
		}

		$query= "SELECT id, nome FROM mb_usuarios";
		$stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
		while($result= $stmt->fetch(PDO::FETCH_ASSOC)){

			$ret["colaboradores"][] = $result;
		}
		return $ret;
	}
  
  public function getExtrato($cta, $data_ini, $data_fin){
    
    $db = Database::getConnection();
    $query = "SELECT saldo FROM mb_contas WHERE id = '".$cta."'";
    $stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
    $conta = $stmt->fetch(PDO::FETCH_ASSOC);
    $conta['id'] = $cta;
    if(!$conta){
      
      $this->erro = "conta nao encontrada.";
      return false;
    }
    $query = "SELECT r.*, ru.nome FROM mb_registros r INNER JOIN mb_rubricas ru ON ru.id = r.rubrica WHERE r.conta = '".$conta['id']."' AND r.data >= '".$data_ini."' AND r.data <= '".$data_fin."' ORDER BY r.data, valor DESC;";
//    echo $query;
    $stmt= $db->query($query);
		if(!$stmt){

			$this->erro= join(";", $db->errorInfo());
			return false;
		}
    $ret = array("registros"=>array());
    $soma = 0;
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      
      $ret['registros'][] = $result;
      $soma += $result['valor'];
    }
    $ret['saldo_ini'] = $conta['saldo'] - $soma;
    $ret['saldo'] = $conta['saldo'];
    $saldo = $ret['saldo_ini'];
    for($i = 0; $i < count($ret['registros']); $i++){
      
      $saldo += $ret['registros'][$i]['valor'];
      $ret['registros'][$i]['saldo'] = $saldo; 
    }
    return $ret;    
  }

	public function getResumo($usuario){

		$db= Database::getConnection();
		$query= "SELECT c.id, u.id AS uid, u.nome, t.nome AS tnome, c.saldo FROM mb_contas c INNER JOIN mb_usuarios u ON u.id= c.usuario INNER JOIN mb_tipos_conta t ON t.id = c.tipo ORDER BY u.nome, c.tipo";
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

	public function getSaldos($usuario){

		$db= Database::getConnection();
		$query= "SELECT c.id, c.saldo, tc.nome FROM mb_contas c INNER JOIN mb_tipos_conta tc ON tc.id= c.tipo WHERE c.usuario='".$usuario."'";

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
}
?>
