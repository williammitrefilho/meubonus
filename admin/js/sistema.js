function esconder(elem){
  
  if(!elem.attributes["style"]){
    elem.setAttribute("style", "display:none");
    return;
  }
    
  var params= elem.attributes["style"].value.split(";"), k=0;
  for(var i=0; i < params.length; i++){
    
    var pts= params[i].split(":");
    if(pts[0] == "display"){
      
      pts[1]= "none";
      params[i]= pts.join(":");
      elem.setAttribute("style", params.join(";"));
      return;
    }
  }
  params.push("display:none");
  elem.setAttribute("style", ""+params.join(";"));    
}

function mostrar(elem){
  
  if(!elem.attributes["style"])
    return;  
  
  var params= elem.attributes["style"].value.split(";");
  for(var i=0; i < params.length; i++){
    
    var pts= params[i].split(":");
    if(pts[0] == "display"){
      
      params.splice(i, 1);
      break;
    }
  }
  elem.setAttribute("style", ""+params.join(";"));    
}

function formatReal(numero){

  var num= Number(numero);
  if(num === NaN)
    return "NaN";

  num= num.toFixed(2);

  var pts= num.toString().split(".");
  if(pts.length < 2)
    return pts[0]+",00";

  while(pts[1].length < 2)
    pts[1] += "0";

  return pts[0]+","+pts[1];
}

function AutoInput(){
  
  this.input = document.createElement("input");
  this.div= document.createElement("div");
  $(this.div).addClass("auto-input");
  $(this.div).hide();
  $(this.divAjax).hide();
  $(this.divOpcoes).hide();
  this.opcaoFocada = -1;
  this.disponivel = false;
  
  this.divOpcoes = document.createElement("div");
  this.divAjax = document.createElement("div");
  
  $(this.divAjax).html("<img src='img/ajax.gif'>")
  $(this.divAjax).addClass("ajax");
  $(this.divOpcoes).addClass("opcoes");
  
  $(this.div).append(this.divAjax);
  $(this.div).append(this.divOpcoes);
   
  this.opcoes = [];
  this.opcaoSelecionada = null;
  
  var hthis = this;
  
  this.input.onkeyup = function(e){
  
    if(e.keyCode >= 37 && e.keyCode <= 40){
      
      console.log(hthis.disponivel);
      if(hthis.disponivel === true){

        for(var i=0; i < hthis.opcoes.length; i++){
          
          $(hthis.opcoes[i].div).removeClass("hover");
        }
        hthis.opcaoFocada ++        
        if(hthis.opcaoFocada == hthis.opcoes.length){
          
          hthis.opcaoFocada = 0;
        }
        $(hthis.opcoes[hthis.opcaoFocada].div).addClass("hover");
      }
      return true;
    }
    if(e.keyCode === 13){
      
      if(hthis.opcaoFocada > -1){
        
        hthis.opcoes[hthis.opcaoFocada].selecionada();
      }
      return true;
    }
    
    hthis.opcaoFocada = -1;
    hthis.disponivel = false;
    
    $(hthis.div).hide();
    hthis.opcaoSelecionada = null;
    if(this.value.length < 3){
      
      return false;        
    }
    $(hthis.div).show();
    $(hthis.divAjax).show();
    $(hthis.divOpcoes).hide();
    $.post("?c=index&op=usuarios&aj=sim", {qry:this.value}, function(dados){
      
      var dt = {};
      console.log(dados);
      try{
      
        dt = eval("("+dados+")");
      }
      catch(e){
        
        console.log("exception", e.message);
        return false;
      }
      if(dt.erro !== undefined){
        
        console.log("erro", dt.erro);
        return false;
      }
      if(dt.OK.length < 1){
        
        $(hthis.div).hide();
        return true;
      }
      hthis.opcaoFocada = -1;
      hthis.disponivel = true;
      hthis.setOpcoes(dt.OK);
      $(hthis.divAjax).hide();
      $(hthis.divOpcoes).show();      
    });          
  }
  this.selecionouOpcao = function(){};
}

AutoInput.prototype.setOpcoes = function(opcoes){
  
  var hthis = this;
  while(this.opcoes.length > 0){
    
    var opc = this.opcoes.pop();
    this.divOpcoes.removeChild(opc.div);
  }
  for(var i=0; i < opcoes.length; i++){
    
    var obj = new Opcao(opcoes[i]);
    obj.selecionada = function(){
      
      hthis.input.value = this.nome;
      hthis.opcaoSelecionada = this;
      $(hthis.div).hide();
      hthis.selecionouOpcao(this);
    }
    obj.hovered = function(){
      
      hthis.opcaoFocada = -1;
      for(var i=0; i < hthis.opcoes.length; i++){
        
        $(hthis.opcoes[i].div).removeClass("hover");
      }
    }
              
    this.opcoes.push(obj);
    $(this.divOpcoes).append(obj.div);
  }
}

function Opcao(dados){
  
  var hthis = this;
  
  this.nome = dados.nome;
  this.id = dados.id;
  this.div = document.createElement("div");
  $(this.div).addClass("opcao");
  $(this.div).html("<span class='nome'>"+this.nome+"</span>");
  $(this.div).click(function(){
      
    hthis.selecionada();      
  });
  $(this.div).hover(function(){
    
    hthis.hovered();
  });
  this.selecionada = function(){};
  this.hovered = function(){};
}

function InputValor(){
  
  this.input= document.createElement("input");
  this.input.onkeydown = function(e){
    
    if((e.keyCode < 48 || e.keyCode > 57) && e.keyCode !== 8 && e.keyCode !== 9  && e.keyCode !== 46  && e.keyCode !== 16 && e.keyCode !== 17){
      e.preventDefault();    
    }
    if(e.keyCode === 8)
      return;    
  }
  this.input.onkeyup = function(e){

    var str = Number(this.value.replace(/[^0-9]/, "")).toString();
    while(str.length < 3){
      
      str = "0"+str;
    }
    console.log(str);
    this.value = str.substr(0, str.length - 2)+","+str.substr(str.length - 2, 2);        
  }
}

InputValor.prototype.limpar = function(){
  
  this.input.value = "";
}

Number.prototype.zeroPad= function(){
  
  var s= this.toString();
  while(s.length < 2){
    
    s= "0"+s;
  }
  return s;
}

Date.prototype.formatBR= function(){
  
  return this.getDate().zeroPad()+"/"+(this.getMonth() + 1).zeroPad()+"/"+this.getFullYear();
}

Date.prototype.formatUS= function(){
  
  return this.getFullYear()+"-"+(this.getMonth() + 1).zeroPad()+"-"+this.getDate().zeroPad();
}

function InputCalendario(){
  
  var hthis= this;
  this.input= document.createElement("input");
  this.input.onkeyup= function(e){
    
    e.preventDefault();
  }
  
  this.calendario= new Calendario();
  esconder(this.calendario.div);
  this.input.onblur= function(){
    
    esconder(hthis.calendario.div);
  }
  this.input.onfocus= function(){
    
    mostrar(hthis.calendario.div);
  }
  this.calendario.clickedDia= function(dia){
    
    hthis.input.value=dia.data.formatBR();
    esconder(this.div);
    hthis.selecionouDia(dia); 
  }
  this.selecionouDia = function(){};
}

InputCalendario.prototype.setNaoFuturo = function(naoFuturo){
  
  this.calendario.setNaoFuturo(naoFuturo);
}

function Calendario(){
  
  var hthis= this;
  this.naoFuturo = true;
  this.div= document.createElement("div");
  this.div.onmousedown= function(e){
    
    e.preventDefault();
  }
  this.div.setAttribute("class", "calendario");
  
  this.divHeader= document.createElement("div");
  this.divHeader.setAttribute("class", "header");
  this.div.appendChild(this.divHeader);
  
  this.btnMenos= document.createElement("span");
  this.btnMenos.innerHTML= "<";
  this.btnMenos.setAttribute("class", "btn menos");
  this.divHeader.appendChild(this.btnMenos);
  this.btnMenos.onclick= function(){
    
    hthis.setMes(hthis.mes - 1, hthis.ano);
  }
  
  this.spanNome= document.createElement("span");
  this.spanNome.setAttribute("class", "nome mes");
  this.divHeader.appendChild(this.spanNome);
  
  this.btnMais= document.createElement("span");
  this.btnMais.innerHTML= ">";
  this.btnMais.setAttribute("class", "btn mais");
  this.divHeader.appendChild(this.btnMais);
  this.btnMais.onclick= function(){
    
    hthis.setMes(hthis.mes + 1, hthis.ano);
  }
  
  this.divDias= document.createElement("div");
  this.divDias.setAttribute("class", "dias");
  this.div.appendChild(this.divDias);
  
  this.divAjax= document.createElement("div");
  this.divAjax.setAttribute("class", "ajax");
  this.div.appendChild(this.divAjax);
  esconder(this.divAjax);
  
  this.hoje= new Date();

  this.mes= this.hoje.getMonth();
  this.ano= this.hoje.getFullYear();
  this.setMes(this.hoje.getMonth(), this.hoje.getFullYear());
  
  this.clickedDia= function(){}; 
}

Calendario.prototype.setMes= function(mes, ano){

  var hthis= this;
  while(this.divDias.childNodes.length > 0){
  
    this.divDias.removeChild(this.divDias.childNodes[0]);  
  }
  var amanha= new Date(ano, mes+1, 0),
      primeiroDia= new Date(ano, mes, 1);

  var dia1= 1, dia2= amanha.getDate(), diaSemana= primeiroDia.getDay();
  
  this.mes= primeiroDia.getMonth();
  this.ano= primeiroDia.getFullYear();
  
  this.spanNome.innerHTML= Calendario.mes[this.mes]+"/"+this.ano;
  
  for(var i=1-diaSemana; i <= amanha.getDate(); i++){
    
    var dia= new DiaCalendario(i, this.mes, this.ano);
    console.log(this.naoFuturo);
    if(this.naoFuturo){
//      console.log(this.ano, this.hoje.getFullYear(), this.mes, this.hoje.getMonth())
      if(this.ano >= this.hoje.getFullYear()){
        
        if(this.mes >= this.hoje.getMonth()){
          
          if(this.mes == this.hoje.getMonth() && this.ano == this.hoje.getFullYear()){
          
            if(i > this.hoje.getDate()){
              
              dia.desativado();
            }
          }
          else{
            
            dia.desativado();
          }
        }
      }
    }
    if(i < 1)
      dia.desativado();
    
    dia.clicked= function(){
      
      hthis.clickedDia(this);
    }
    this.divDias.appendChild(dia.div);        
  }
}

Calendario.prototype.setNaoFuturo = function(naoFuturo){
  
  this.naoFuturo = naoFuturo;  
} 

function DiaCalendario(dia, mes, ano, ativado){
  
  var hthis= this;
  this.div= document.createElement("div");

  this.data= new Date(ano, mes, dia);
  var hoje= new Date();

  if(hoje.formatUS() == this.data.formatUS())
    this.div.setAttribute("class", "dia hoje");
  else
    this.div.setAttribute("class", "dia");
     
  this.div.innerHTML= this.data.getDate();
  this.div.onmousedown= function(e){
    
    e.preventDefault();
  }
  if(ativado !== false)
    this.div.onclick= function(){
      
      hthis.clicked();
    }
  else
    this.setAttribute("class", "dia desativado");
}

DiaCalendario.prototype.desativado= function(){
  
  this.div.setAttribute("class", "dia desativado");
  this.div.onclick= function(){};
}

Calendario.mes= [
"Janeiro",
"Fevereiro",
"Março",
"Abril",
"Maio",
"Junho",
"Julho",
"Agosto",
"Setembro",
"Outubro",
"Novembro",
"Dezembro"
];

function InData(data){
  
  if(data)
    this.data= new Date(data);
  else
    this.data= new Date();
  
  this.div= document.createElement("div");
  this.div.setAttribute("class", "indata");
  
  this.mesAtual= this.data.getMonth();
  console.log(this.mesAtual);
  
}

function DataInData(data){
  
  this.data= new Date(data);
  this.div= document.createElement("div")
}