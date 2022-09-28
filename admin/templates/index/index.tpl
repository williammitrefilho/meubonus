<?php echo Renderer::renderBloco('index/header');?>
<div class="main">
  <!--<div class="nome-pagina">
    <h3>Index</h3>
  </div>-->
  <div class="middle">
  	<?php echo Renderer::renderBloco('conta/resumo');?>
  </div>    
</div>
<?php echo Renderer::renderBloco('index/footer');?>