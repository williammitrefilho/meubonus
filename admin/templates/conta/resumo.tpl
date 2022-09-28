<div class="container-contas">
<?php foreach($resumo as $conta){?>
	<div class="conta">
		<div id="conta-<?php echo $conta['id']?>" class="ref-conta">
			<span class="nome"><?php echo $conta['nome']." (".$conta['tnome']."):"?></span>
			<span class="saldo"><?php echo Valor::formatReal($conta['saldo'])?></span>
		</div>
    <span class="botao registro">Incluir registro</span>
    <a href="?c=conta&op=verextrato&conta=<?php echo $conta['id']?>&dias=180">Ver extrato</a>
	</div>
<?php }?>
</div>
<div class="sombra" id="sombra">
	<div class="container-form" id="container-form-registro">
		<form id="form-registro">
			<span class="btn-fechar" id="btn-fechar-form">X</span>
			<span class="titulo">Incluir registro</span>
			<span class="texto">Colaborador:<span id="nome-colaborador"></span></span>
			<table>
        <tr>
          <td>
            <span class="texto">Rubrica:</span>
          </td>
          <td>
    				<select class="select" name="rubrica">
    					<?php foreach($rubricas as $ru){?>
    					<option value="<?php echo $ru['id']?>"><?php echo $ru['nome']?></option>
    					<?php }?>
    				</select>    			
          </td>
        </tr>
        <tr>
          <td>
      			<span class="texto">Tipo:</span>
          </td>
          <td>
    				<select class="select" name="tipo">
    					<option>--</option>
    					<option value="1">Crédito</option>
    					<option value="2">Débito</option>
    				</select>
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto">Valor:</span>
          </td>
          <td>
            <input type="tel" id="in-valor" name="valor" placeholder="0,00">
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto">Obs:</span>
          </td>
          <td>
            <input type="text" id="in-obs" name="obs">
          </td>
        </tr>
        <tr>
          <td colspan = "2">
            <button class="btn-enviar" id="btn-enviar">Registrar</button>
          </td>
        </tr>
      </table>
		</form>
	</div>
</div>
<div class="sombra" id="sombra2">
	<img class="ajax" src="img/ajax.gif">
</div>