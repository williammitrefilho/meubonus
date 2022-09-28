$(document).ready(function(){
  
  $("span.data").each(function(){
      
    console.log($(this).text());
    var pts = $(this).text().split("-");
    $(this).text(pts[2]+"/"+pts[1]+"/"+pts[0]);
  });
  
  $("span.valor").each(function(){
      
    $(this).text(formatReal(Number($(this).text())));
  });
});