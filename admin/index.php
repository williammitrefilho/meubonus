<?php
  require "cfg/config.php";
  require "classes/database.php";     
  require "classes/session.php";
  require "classes/render.php";
  require "classes/data.php";
  require "classes/bloco.php";  
  require "classes/url.php";
  require "classes/valor.php"; 
    
  if(!isset($_GET['c'])){    
    $classe = "index";
  }
  else{
    $classe = strtolower(preg_replace("[^A-Za-z0-9]", "", $_GET["c"]));
  }
  if(!isset($_GET['op'])){    
    $metodo = "index";
  }
  else{
    $metodo = strtolower(preg_replace("[^A-Za-z0-9]", "", $_GET["op"]));
  }
  if(!Session::verificar()){
    if($classe != "index" || $metodo != "acesso"){

      header("location:?c=index&op=acesso");
      exit("sessao nao verificada");
    }
  }
  
  Renderer::renderBloco($classe."/".$metodo);
  if(!isset($_GET['aj']) || $_GET['aj'] !== "sim"){
    echo Renderer::getOutput();
  }
?>