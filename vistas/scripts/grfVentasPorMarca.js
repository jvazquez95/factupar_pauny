var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
 num +='';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}
function init(){
   listar();
   $("#f_i").change();
   $("#f_f").change();
   $("#actualizar").click(listar);
    //cargamos los items al select usuario
}

function listar()
{

    var f_i = $("#f_i").val();
    var f_f = $("#f_f").val();

$(document).ready(function() {
    $.ajax({
        url: '../ajax/grfVentasPorMarca.php?op=listar',
		data:{f_i: f_i, f_f: f_f},
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        method: "GET",
        success: function(data) {
            var nombre = [];
            var stock = [];
            var color = ['#1F1567','#1E0984',  '#280CAF', '#3513D7', '#502BFF', '#3C70DA', '#7559FC', '#9680FE', '#C7BBFE', '#D3CBFB', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'];
			var bordercolor = ['white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white', 'white'];
            console.log(data);

            for (var i in data) {
                nombre.push(data[i].nombre);
                stock.push(data[i].stock);
            }

            var chartdata = {
                labels: nombre,
                datasets: [{
                    label: 'Proveedores',
                    backgroundColor: color,
                    borderColor:'white',
                    borderWidth: 2,
                    hoverBackgroundColor: color,
                    hoverBorderColor: bordercolor,
                    data: stock
                }]
				
            };

            var mostrar = $("#miGrafico");

            var grafico = new Chart(mostrar, {
                type: 'horizontalBar',
                data: chartdata,
                options: 
				
				{
					elements: {
						rectangle: {
							borderWidth: 2,
						}
					},
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Monto de Ventas por Marca'
					}
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
}
init(); 
