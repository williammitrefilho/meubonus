<div class="nome-pagina">
    <h3>Extrato</h3>
</div>
<div class="middle">
	<a class="voltar" onclick= "window.history.back()">Voltar</a>
	<?php if($extrato){?>
	<div class="container-extrato">
		<table class="extrato">
			<tr>
				<td>Data</td>
				<td>Registro</td>
				<td>Valor</td>
				<td>Saldo</td>
			</tr>
			<?php foreach($extrato as $linha){?>
			<tr>
				<td class="data"><?php echo $linha['data']?></td>
				<td><span class="texto"><?php echo $linha['nome']?></span><span class="obs"><?php echo $linha['obs']?></span></td>
				<td class="valor <?php echo ($linha['valor'] < 0 ? 'neg' : 'pos')?>">
					<?php echo $linha['valor'] != '' ? Valor::formatReal($linha['valor']) : '';?>
				</td>
				<td class="valor <?php echo ($linha['saldo'] < 0 ? 'neg' : 'pos')?>"><?php echo Valor::formatReal($linha['saldo']);?></td>
			</tr>
			<?php }?>
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