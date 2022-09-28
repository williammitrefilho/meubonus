<div class="header" id="main-header">
  <div class="usuario">
    <span class="boas-vindas">Olá, <?php echo Session::$usuario['nome']?></span>
    <a href="?c=index&op=logout" class="btn-logout">Sair</a>
  </div>
  <h2 class="nome empresa"><?php echo $empresa['nome']?></h2>
  <ul class="nav nav-pills">
  <?php foreach($paginas as $pagina){?>
    <li class="pagina" role="presentation">
      <a href="<?php echo URL::criar($pagina['link'])?>"><?php echo $pagina['nome']?></a>
    </li>
  <?php }?>
  </ul>
</div>