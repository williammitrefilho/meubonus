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

function Conta(id, nome, btn, btnr){

  this.id= id;
  this.nome = nome.replace(":", "");
  this.btn = btn;
  this.btnr= btnr;

  var that= this;

  this.btnr.onclick= function(){

      $("#container-form-registro").show();
      $("#sombra").fadeIn();
      $("#nome-colaborador").text(that.nome);
      $(".select").first().focus();
      Conta.selecionada= that.id;
      console.log(Conta.selecionada);
  };
}

$(document).ready(function(){

  var colaboradores= [];
  $("#in-valor").keyup(function(){

    var v= Number($(this).val().replace(/[^0-9]/, "")).toString();
    while(v.length < 3){

      v = "0"+v;
    }
    console.log(v.substr(0, v.length-2), ",", v.substr(v.length-2,2));
    $(this).val(v.substr(0, v.length-2)+","+v.substr(v.length-2,2));
  });
  $(".conta").each(function(){

    var dt= [$(this).find(".ref-conta").attr("id").replace("conta-",""), $(this).find(".ref-conta .nome").text(), $(this).find(".ref-conta")[0], $(this).find(".botao.registro")[0]];
    colaboradores.push(new Conta(dt[0], dt[1], dt[2], dt[3]));
  });
  console.log(colaboradores);

  $("#sombra").hide();
  $("#sombra2").hide();

  $("#container-form-registro").hide();
  $("#btn-fechar-form").click(function(){

    $("#sombra").fadeOut();
  });
  $(".container-mini-extrato").hide();
  $("#form-registro").submit(function(e){

    e.preventDefault();
    if(!Conta.selecionada){

      alert("nenhuma conta selecionada");
      return false;
    }
    $("#sombra2").show();
    var formData= new FormData($("#form-registro")[0]);
    formData.append("conta", Conta.selecionada);
    formData.append("valor", $("#in-valor").val().replace(",", ""));
    console.log(formData); 
    $.ajax({
      url: '?c=conta&op=incluirRegistro&aj=sim',
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(data){
//        alert("Registro incluido com sucesso");
//        window.location.reload();
        $("#sombra2").hide();
        $("#sombra").hide();
        console.log(data);
        var dt = {};
        try{
          
          dt = eval("("+data+")");
        }
        catch(e){
          
          console.log("erro", e.message);
        }
        console.log(dt);
        
        if(dt.erro !== undefined){
          
          alert("erro:"+dt.erro);
          return false;
        }
        else if(dt.registro){
          
          window.location.reload();
        }        
      }
    });
  });
});