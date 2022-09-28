<?php echo Renderer::renderBloco('index/header');?>
<div class="main">
  <!--<div class="nome-pagina">
    <h3>Index</h3>
  </div>-->
  <div class="middle">
    <span class='subtitulo'>Pagamentos - Últimos <span class="ind-dias"><?php echo $dias;?></span> dias</span>
    <a class="link-tipo" href="?c=pagto&op=novo">Novo pagamento <span class="sinal-add">+</span></a>
    <?php if($erro !== ""){?>
    <span class="erro"><?php echo $erro?></span>
    <?php }?>
  	<?php if(count($pagtos) < 1){?>
    <span class="mensagem">Nenhum pagamento encontrado.</span>
    <?php }?>
    <?php foreach($pagtos as $pagto){?>
    <div class="pagto">
      <span class="nome"><?php echo $pagto['nome']?></span>
      <span class="data"><?php echo $pagto['data']?></span>
      <span class="valor"><?php echo $pagto['valor']?></span>
      <div class="dets">
      <?php foreach($pagto['dets'] as $det){?>
        <span class="det"><?php echo ($det['arquivo'] ? "<a href='?c=pagto&op=arquivo&codigo=".$det['arquivo']."'>".$det['descricao']."</a>" : $det['descricao'])?> <span class="valor"><?php echo $det['valor']?></span></span> |
      <?php }?>
      </div>
    </div>
    <?php }?>
  </div>    
</div>
<?php echo Renderer::renderBloco('index/footer');?>