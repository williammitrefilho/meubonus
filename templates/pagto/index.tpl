<?php echo Renderer::renderBloco('index/header');?>
<div class="main">
  <!--<div class="nome-pagina">
    <h3>Index</h3>
  </div>-->
  <div class="middle">
    <span class='subtitulo'>Pagamentos - Últimos:</span>
    <span class="ind-dias <?php echo ($dias == 15 ? "selecionado" : "")?>"><a href="?c=pagto&dias=15">15 dias</a></span>
    <span class="ind-dias <?php echo ($dias == 30 ? "selecionado" : "")?>"><a href="?c=pagto&dias=30">30 dias</a></span>
    <span class="ind-dias <?php echo ($dias == 60 ? "selecionado" : "")?>"><a href="?c=pagto&dias=60">60 dias</a></span>    
    <?php if($erro !== ""){?>
    <span class="erro"><?php echo $erro?></span>
    <?php }?>
  	<?php if(count($pagtos) < 1){?>
    <span class="mensagem">Nenhum pagamento encontrado.</span>
    <?php }?>
    <?php foreach($pagtos as $pagto){?>
    <div class="pagto">
      <span class="data"><?php echo $pagto['data']?></span>
      <table class="dets">
      <?php foreach($pagto['dets'] as $det){?>
        <tr>
          <td><?php echo ($det['arquivo'] > 0 ? "<a href='?c=pagto&op=arquivo&codigo=".$det['arquivo']."'>".$det['descricao']."</a>" : $det['descricao'])?></td>
          <td><span class="valor"><?php echo $det['valor']?></span></td>
        </tr>
      <?php }?>
        <tr class = "total">
          <td>Total</td><td><span class="valor total"><?php echo $pagto['valor']?></span></td>
        </tr>
      </table>
    </div>
    <?php }?>
  </div>    
</div>
<?php echo Renderer::renderBloco('index/footer');?>