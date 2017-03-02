$(document).ready(function(){
		var baseUrl = 'http://localhost/CuadroMando/index.php/';

		var idAmbito;

		function getAmbitos(){
			$.ajax({
				type: 'post',
				url: baseUrl + 'Ambitos_controller/getAmbitos',

				error: function(){
					console.log('error ajax al traer ambitos');
				},

				success: function(data){
					console.log(data);
				}
			});
		}

		function getCaracteristicas(){
			$.ajax({
				type: 'post',
				url: baseUrl + 'Ambitos_controller/getAjaxCaracteristicas',

				error: function(){
					console.log('error ajax al traer caracteristicas');
				},
				success: function(data){
					console.log(data);
				}
			});
		}

		//getAmbitos();
		
		$("#tblambitos").on("click", "td", function() {
	     	alert($( this ).text());
	   	});

	});