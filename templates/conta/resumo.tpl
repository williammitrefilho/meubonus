<div class="container-contas">
<?php foreach($resumo as $conta){?>
	<div class="conta">
		<a id="conta-<?php echo $conta['tipo']?>" class="ref-conta link">
			<span class="nome"><?php echo $conta['nome'].":"?></span><span class="saldo"><?php echo Valor::formatReal($conta['saldo'])?></span>
		</a>
		<div class="container-mini-extrato">
			<div class="container-ajax">
				<img src="img/ajax.gif">
			</div>
			<div class="c-mini-extrato">
				<div class="mini-extrato">
				</div>
				<span class="clicavel ver-extrato-completo">Ver extrato completo</span>
			</div>
		</div>
	</div>
<?php }?>
	<div class="sombra">
		<div class="container-form-extrato">
			<span class="titulo">Ver extrato completo</span>
			<span class="btn-fechar" id="btn-fechar-form-extrato">X</span>
			<form action="?c=conta&op=consultaExtrato" id="form-extrato">
				<div class="container-btns">
					<span class="subtitulo">Últimos lançamentos:</span>
					<a class="inv" id="ver-90-dias"><span class="btn-consulta">90 dias</span></a>
					<a class="inv" id="ver-120-dias"><span class="btn-consulta">120 dias</span></a>
				</div>
				<div class="container-in-datas">
					<input type="hidden" name="tipo_conta" id="in-tipo-conta">
					<input type="hidden" name="c" value="conta">
					<input type="hidden" name="op" value="consultaExtrato">
					<span class="subtitulo">Por data:</span>
					<div class="input" id="in-data-ini">
						<span class="label">De:</span>
						<span class="texto" id="t-data-ini"></span>
						<input type="hidden" id="data-ini" name="data_ini">
					</div>
					<div class="input" id="in-data-fin">
						<span class="label">Até:</span>
						<span class="texto" id="t-data-fin"></span>
						<input type="hidden" id="data-fin" name="data_fin">
					</div>
					<div class="btn-enviar" id="btn-enviar-consulta">Consultar</div>
				</div>
			</form>
		</div>
	</div>
	<div class="container-calendario" id="container-calendario"></div>
</div>