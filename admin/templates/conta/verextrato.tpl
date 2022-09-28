<div class="nome-pagina">
    <h3>Extrato</h3>
</div>
<div class="middle">
	<a class="voltar" onclick= "window.history.back()">Voltar</a>
	<?php if($extrato){?>
	<div class="container-extrato">
		<table class="tabela-extrato">
			<tr>
				<td>Data</td>
				<td>Registro</td>
				<td>Valor</td>
				<td>Saldo</td>
			</tr>
      <tr class='destaque'>
        <td class="data"><?php echo $data_ini?></td>
        <td><span class="texto">Saldo Inicial</span></td>
        <td></td>
				<td class="valor <?php echo ($extrato['saldo_ini'] < 0 ? 'neg' : 'pos')?>"><?php echo Valor::formatReal($extrato['saldo_ini']);?></td>
      </tr>
			<?php foreach($extrato['registros'] as $linha){?>
			<tr>
				<td class="data"><?php echo $linha['data']?></td>
				<td><span class="texto"><?php echo $linha['nome']?></span><span class="obs"><?php echo $linha['obs']?></span></td>
				<td class="valor <?php echo ($linha['valor'] < 0 ? 'neg' : 'pos')?>">
					<?php echo $linha['valor'] != '' ? Valor::formatReal($linha['valor']) : '';?>
				</td>
				<td class="valor <?php echo ($linha['saldo'] < 0 ? 'neg' : 'pos')?>"><?php echo Valor::formatReal($linha['saldo']);?></td>
			</tr>
			<?php }?>
      <tr class='destaque'>
        <td class="data"><?php echo $data_fin?></td>
        <td><span class="texto">Saldo</span></td>
        <td></td>
				<td class="valor <?php echo ($extrato['saldo'] < 0 ? 'neg' : 'pos')?>"><?php echo Valor::formatReal($extrato['saldo']);?></td>
      </tr>
		</table>
		<script type="text/javascript">
			$(".data").each(function(){

				var pts= $(this).text().split("-");
				$(this).text(pts[2]+"/"+pts[1]);
			});
		</script>
	</div>
	<?php }?>
	<a class="voltar" onclick= "window.history.back()">Voltar</a>
</div>