// JavaScript Document
function Accept(){};
Accept.tipos = [
  
  "application/pdf"
]
function DetPagto(dados){
  
  var hthis = this;
  this.descricao = dados.descricao;
  this.valor = dados.valor;
  this.arquivo = 0;
  this.div = document.createElement("div");
  $(this.div).addClass("detpagto");
  $(this.div).html("<table><tr><td class='info'>"+this.descricao+"</td><td rowspan='2' class='c-excluir'></td></tr><tr><td class='valor'>"+formatReal(this.valor)+"</td></tr></table>");
  this.btnExcluir = document.createElement("span");
  $(this.btnExcluir).text("-");
  $(this.btnExcluir).addClass("btn-excluir");
  $(this.div).find('.c-excluir').append(this.btnExcluir);
  $(this.btnExcluir).click(function(){
    
    hthis.clickedExcluir();
  });
  this.clickedExcluir = function(){};
}

DetPagto.prototype.setArquivo = function(arq){
  
  this.arquivo = arq;
  $(this).find("table").html($(this).find("table").html()+"<tr class='r-arquivo'><td><a>Arquivo</a></td></tr>");
}

$(document).ready(function(){

  var total = 0, data="", arqs = [];
  $("#detspagto").hide();
  $("#c-btn-final").hide();
  
  var inUsuario = new AutoInput(), detsPagto = [], inValor = new InputValor(), inData = new InputCalendario();
  inData.setNaoFuturo(true);
  
  $("#c-in-valor").append(inValor.input);
  
  $("#c-in-data").append(inData.input);
  $("#c-in-data").append(inData.calendario.div);
  
  $("#btn-escolher-arq").click(function(){
    
    $("#in-arq").click();
  });
  inData.selecionouDia = function(dta){
    
    console.log(dta);
    data = dta.data.formatUS();
    $(inUsuario.input).focus();
  }
  
  $("#c-in-usuario").append(inUsuario.input);
  $("#c-in-usuario").append(inUsuario.div);
  inUsuario.selecionouOpcao = function(opcao){
    
    $("#in-usuario").val(opcao.id);
    $("#detspagto").show();
    $("#in-desc").focus();
  }
  $("#incluir-item").click(function(){
    
    var desc = $("#in-desc").val();
    var val = Number(inValor.input.value.replace(",", "."));
    var dtp = new DetPagto({descricao:desc, valor:val});
    if($("#in-arq")[0].files.length > 0){
      
     
      arqs.push($("#in-arq")[0].files[0]);
      dtp.setArquivo(arqs.length);
      console.log(arqs);
    }
    dtp.clickedExcluir = function(){
      
      $(this.div).remove();
      total -= this.valor;
      $("#in-desc").focus();
      $("#ph-valor-total").text(formatReal(total));
      detsPagto.splice(detsPagto.indexOf(dtp), 1);
      if(detsPagto.length < 1){
        
        $("#c-btn-final").hide();
      }
    }
    $("#c-btn-final").fadeIn();
    total += val;
    $("#ph-valor-total").text(formatReal(total));
    $(dtp.div).hide();
    $("#c-dets").append(dtp.div);
    detsPagto.push(dtp);
    $(dtp.div).fadeIn();
    $("#in-desc").val("");
    inValor.limpar();
    $("#in-desc").focus();
    $("#in-arq").val("");
    $("#in-arq, #ok-arq").hide();    
  });
  $("#erro-arq, #in-arq, #ok-arq").hide();
  $("#in-arq").change(function(){
    
    $("#erro-arq").hide();
    console.log(this.files[0].type);
    if(Accept.tipos.indexOf(this.files[0].type) < 0){
      
      $("#erro-arq").show();
      $(this).empty();
    }
    else{
      
      $("#ok-arq").show();
    }
  });
  $("#cadastrar-pagto").click(function(){
    
    var formData = new FormData();
    formData.append("usuario", inUsuario.opcaoSelecionada.id);
    formData.append("valor", formatReal(total).replace(",", ""));
    formData.append("data", data);
    
    var postdata = {usuario:inUsuario.opcaoSelecionada.id, valor:formatReal(total).replace(",", ""), data:data};
    var dets = [];
    for(var i=0; i < detsPagto.length; i++){
       
      dets.push({descricao:detsPagto[i].descricao, valor:formatReal(detsPagto[i].valor).replace(",", ""), arquivo:detsPagto[i].arquivo});
    }
    formData.append("dets", JSON.stringify(dets));
    for(var i=0; i < arqs.length; i++){
      
      formData.append("arquivo"+(i+1), arqs[i], arqs.name);
    }
    postdata.dets = JSON.stringify(dets);
    console.log(postdata);
    console.log(formData);
    /*
    $.post("?c=pagto&op=addpagto&aj=sim", postdata, function(dados){
      
      console.log(dados);
      var dt = {};
      try{
        
        dt = eval("("+dados+")");        
      }
      catch(e){
        
        console.log("erro", e.message);
        return false
      }
      if(dt.erro !== undefined){
        
        alert("erro:"+dt.erro);
        return false;
      }
      if(dt.OK !== undefined){
        
        window.location = "?c=pagto&op=index";
      }
    });
    */
    var xhr = new XMLHttpRequest();
    if(xhr.upload){
      
      xhr.upload.onprogress = function(e){
        
        if(e.lengthComputable){
          
          console.log(e.loaded, e.total);
        }
      }
    }
    xhr.onreadystatechange = function(){
      
      console.log(this.readyState, this.status);
      if(this.readyState == 4 && this.status == 200){
        
        console.log(this.responseText);
        var dt = {};
        try{
          
          dt = eval("("+this.responseText+")");
        }
        catch(e){
          
          console.log("exception", e.message);
          return false;
        }
        if(dt.erro !== undefined){
          
          console.log("erro", dt.erro);
          return false;
        }
        if(dt.OK !== undefined){
          
          window.location = "?c=pagto";
          return true;
        }
      }
    }
    xhr.open("POST", "?c=pagto&op=addPagto&aj=sim");
    xhr.send(formData);
  });
  $(inData.input).focus();  
});