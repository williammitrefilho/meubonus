function formatReal(num){

	num= Number(num);
	if(num === NaN)
		return "0,00";

	var pts= num.toString().split(".");
	if(pts.length < 2)
		return pts[0]+",00";

	while(pts[1].length < 2)
		pts[1]+="0";

	return pts[0]+","+pts[1].substr(0,2);
}
function zeroPad(num){

	num= Number(num);
	if(num === NaN)
		return "00";

	num= num.toString();
	while(num.length < 2)
		num= "0"+num;

	return num;
}
function DiaCalendario(data){

	var hthis= this;
	this.data= new Date(data);
	this.td= document.createElement("td");
	this.td.innerHTML= this.data.getDate();
	this.td.onclick= function(){

		hthis.clicked();
	}
	this.clicked= function(){};
}

function Calendario(){
	
	var hthis= this;
	this.div= document.createElement("div");
	this.div.setAttribute("class", "cont-calendario");
	this.tabela= document.createElement("table");
	this.tabela.setAttribute("class",  "calendario");
	this.dataAtual= new Date();
	this.mesAtual= this.dataAtual.getMonth();
	this.anoAtual= this.dataAtual.getFullYear();

//	console.log(this);

	this.cabecalho= document.createElement("tr");
	this.btnAvancar= document.createElement("td");
	this.btnAvancar.setAttribute("colspan", "2");
	this.btnAvancar.innerHTML= ">";
	this.btnAvancar.onclick= function(){

		hthis.mesAtual ++;
		if(hthis.mesAtual > 11){

			hthis.mesAtual = 0;
			hthis.anoAtual ++;
		}
		hthis.atualizarMes();
	}

	this.btnVoltar= document.createElement("td");
	this.btnVoltar.setAttribute("colspan", "2");
	this.btnVoltar.innerHTML= "<";
	this.btnVoltar.onclick= function(){

		hthis.mesAtual --;
		if(hthis.mesAtual < 0){

			hthis.mesAtual = 11;
			hthis.anoAtual --;
		}
		hthis.atualizarMes();
	}

	this.nomeMes= document.createElement("td");
	this.nomeMes.setAttribute("colspan", "3");
	
	this.cabecalho.appendChild(this.btnVoltar);
	this.cabecalho.appendChild(this.nomeMes);
	this.cabecalho.appendChild(this.btnAvancar);

	this.linhaDiasSemana= document.createElement("tr");
	for(var i=0; i < 7; i++){

		this.linhaDiasSemana.innerHTML += "<td>"+Calendario.diasSemana[i]+"</td>";
	}

	this.selecionouData=function(data){

		console.log(data);
	};

	this.atualizarMes();
}

Calendario.prototype.atualizarMes= function(){

	var hthis= this;
	this.tabela.innerHTML= "";
	this.nomeMes.innerHTML= Calendario.meses[this.mesAtual]+" "+this.anoAtual;
	this.tabela.appendChild(this.cabecalho);
	this.tabela.appendChild(this.linhaDiasSemana);
	var data= new Date(this.anoAtual, this.mesAtual, 1, 0, 0, 1, 0), dataFin= new Date(this.anoAtual, this.mesAtual + 1, 0, 0, 0, 1, 0);
//	console.log(this.mesAtual, this.anoAtual, data, dataFin);
	data.setDate(1-data.getDay());
	dataFin.setDate(dataFin.getDate()+6-dataFin.getDay());
//	console.log(data, data.getDay(), dataFin, dataFin.getDay());
	var tr= document.createElement("tr");
	while(data.getTime() < dataFin.getTime()){
		console.log(data.getMonth(), data.getFullYear());
		var dia= new DiaCalendario(data);
		dia.clicked= function(){

			hthis.selecionouData(this.data);
		}
		tr.appendChild(dia.td);
		if(dia.data.getMonth() !== this.mesAtual || dia.data.getFullYear() !== this.anoAtual){
			dia.td.setAttribute("class", "fora");
		}
		if(data.getDay() == 6){

			this.tabela.appendChild(tr);
			tr= document.createElement("tr");
		}
		data.setDate(data.getDate()+1);
	}
	if(tr.childNodes.length > 0){

		while(tr.childNodes.length < 7){

			var dia= new DiaCalendario(data);
			dia.clicked= function(){

				hthis.selecionouData(this.data);
			}
			data.setDate(data.getDate()+1);
			tr.appendChild(dia.td);
			dia.td.setAttribute("class", "fora");
		}
		this.tabela.appendChild(tr);
	}
}

Calendario.meses= [
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

Calendario.diasSemana= [
"Dom",
"Seg",
"Ter",
"Qua",
"Qui",
"Sex",
"Sáb"
]

function JanelaConsulta(){

	this.div= document.createElement("div");
	this.tipoRelatorio= 1;
}

JanelaConsulta.tiposRelatorio= [
"",
"Faturamento",
"Saída de Estoque",
];