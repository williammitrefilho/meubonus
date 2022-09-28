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
$(document).ready(function(){

  var calendario= new Calendario(), contaSelecionada= 0;

  $(calendario.div).hide();
  $(".sombra").hide();

  $("#in-data-ini").click(function(){

    console.log("click");
    calendario.selecionouData= function(data){
      console.log("x");
      $("#data-ini").val(data.getFullYear()+"-"+zeroPad(data.getMonth()+1)+"-"+zeroPad(data.getDate()));
      $("#t-data-ini").text(zeroPad(data.getDate())+"/"+zeroPad(data.getMonth()+1)+"/"+data.getFullYear());
      $("#container-calendario").hide();
    }
    $("#container-calendario").show();
  });

  $("#in-data-fin").click(function(){

    console.log("click");
    calendario.selecionouData= function(data){

      $("#data-fin").val(data.getFullYear()+"-"+zeroPad(data.getMonth()+1)+"-"+zeroPad(data.getDate()));
      $("#t-data-fin").text(zeroPad(data.getDate())+"/"+zeroPad(data.getMonth()+1)+"/"+data.getFullYear());
      $("#container-calendario").hide();
    }
    $("#container-calendario").show();
  });
  $("#btn-enviar-consulta").click(function(){

    $("#form-extrato").submit();
  });

  $("#container-calendario").append(calendario.tabela);
  $("#container-calendario").hide();

  $(".ver-extrato-completo").click(function(){

    $(".sombra").show();
    var id= $(this).parent().parent().parent().find(".ref-conta").attr("id").replace("conta-","");
    contaSelecionada= id;
    console.log("conta", contaSelecionada);
    $("#in-tipo-conta").val(contaSelecionada);
    $("#ver-90-dias").click(function(){

      window.location= "?c=conta&op=consultaExtrato&dias=90&tipo_conta="+contaSelecionada;
    });
    $("#ver-120-dias").click(function(){

      window.location= "?c=conta&op=consultaExtrato&dias=120&tipo_conta="+contaSelecionada;
    });
  });

  $("#btn-fechar-form-extrato").click(function(){

    $(".sombra").hide();
  });

  $("a.ref-conta").click(function(){

    var hthis= $(this).parent().find(".container-mini-extrato")[0];
    $(hthis).show();

    $(hthis).find(".mini-extrato").empty();
    $(hthis).find(".c-mini-extrato").hide();
    $(hthis).find(".container-ajax").show();
    var hthis= $(this).parent()[0];
    $.post("?aj=sim&dias=90&c=conta&op=extrato&tipo_conta="+$(this).attr("id").replace("conta-", ""), function(data){

      $(hthis).find(".container-ajax").hide();
      console.log(data);
      var reg= eval("("+data+")");
      console.log(reg);
      if(reg.length < 2){

        $(hthis).find(".mini-extrato").html("<span class='texto'>Não há lançamentos nos últimos 60 dias.</span>");
        $(hthis).find(".c-mini-extrato").show();
        return;
      }
      var tbl= document.createElement("table");
      $(tbl).html("<tr class='titulo'><td>Registro</td><td>Valor</td><td>Saldo</td></tr>");
      $(tbl).addClass("tabela-extrato");
      for(var i=0; i < reg.length; i++){

        var tr= document.createElement("tr");
        $(tr).html("<td>"+reg[i].nome+"</td><td class='"+(Math.round(reg[i].valor) >= 0 ? "pos" : "neg")+"'>"+(reg[i].valor ? formatReal(reg[i].valor) : "")+"</td><td class='"+(Math.round(reg[i].saldo) >= 0 ? "pos" : "neg")+"'>"+formatReal(reg[i].saldo)+"</td>");
        $(tbl).append(tr);
      }
      $(hthis).find(".mini-extrato").append(tbl);
      $(hthis).find(".c-mini-extrato").show();
    });
  });
  $(".container-mini-extrato").hide();
});