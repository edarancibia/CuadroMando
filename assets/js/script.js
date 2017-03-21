$(document).ready(function(){

	function configToastr(){
		toastr.options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": false,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		   "hideMethod": "fadeOut"
		}
	}
	var baseUrl = 'http://localhost/CuadroMando/index.php/';

	//- - - - -   Login - - -  - - - -  - 
	$('#btnLogin').on('click', function(){
		var rut = $('#rut').val();
		var clave = $('#password').val();


		//- - -COMPRUEBA SI EXISTE USUARIO Y CLAVE EN BD SICBONET
		$.ajax({
			type: 'post',
			url: baseUrl+'login/wsLoginSicbo',
			data: {rut_num: rut, clave: clave},
			success: function(data){
				console.log(data);
				if (data == 'pasa') {
					$.ajax({
						type: 'post',
						url: baseUrl+'login/validaCargo',
						data: {rut_num: rut},
						success: function(data){
							console.log(data);
							if (data == 1) {
								location.href = baseUrl+'Welcome/HomeSupervisor';
							}else{
								location.href = baseUrl+'Welcome/home';
							}
						},
						error: function(){
							console.log('error ajax getGargo');
						}
					});

				}else{

					Command: toastr["error"]("Rut o contraseña incorrectos")
					configToastr();
				}
				
			},
			error: function(){
				console.log("error ajax login");
			}
		});
	});
	// - - - - - - -  - - -  - - - - -     - -    - - -
		
//- - - - - - Indicadores - - - - - - -   -  - - - - - - - - -

	function getIndicadoresByCargo(){
		var rut = $('#rut').val();

		$.ajax({
			type: 'post',
			url: baseUrl+'Indicadores/getIndicaCargo',
			data: {rut: rut},
			success: function(data){
				console.log(data);
				//$("body").html(baseUrl+'Indicadores/getIndicaCargo');
				location.href = baseUrl+'Indicadores/getIndicaCargo?rut_num='+rut;
			},
			error: function(){
				console.log("error ajax con indicadores");
			}
		});
	}

	$('#btnGuadar').on('click',function(){ //- - - Guarda datos de evaluacion de indicador - - 
		var parsedDen = 0;
		var parsedNum = 0;
		var parsedRes = 0;
		var denominador = $('#txtvalor1').val();
		var numerador = $('#txtvalor2').val();
		var fecha = new Date;
        var anio = fecha.getFullYear();
        var mes = parseInt(fecha.getMonth());
        var periodo = mes.toString()+anio.toString();
        var indicador = $('#txtIdindicador').val();
		parsedDen = parseInt(denominador);
		parsedNum = parseInt(numerador);
		parsedRes = parseInt(parsedDen / parsedNum * 100);
		var fecha2 = moment().format('L');

		if (denominador == '') {
			toastr.info('Ingrese valores');
			configToastr();
			$('#txtvalor2').focus();
		}else if(numerador == ''){
			toastr.info('Ingrese valores');
			$('#txtvalor2').focus();
		}else{
			$.ajax({
				type: 'post',
				url: baseUrl+'Indicadores/guardaEvaluacion',
				data: {denominador: parsedDen,numerador: parsedNum,multiplicador: 100, resultado: parsedRes,idIndicador: indicador,fecha: fecha2, periodo: periodo},
				success: function(data){
					console.log('Guardado exitosamente');
					$('#txtvalor1').val('');
					$('#txtvalor2').val('');
					toastr.success('Datos guardados exitosamente');
					configToastr();

				},
				error: function(){
					console.log('error ajax al guardar');
				}
			});
		}
	});

	$('#btnVolver').on('click',function(){
		location.href = baseUrl+'Indicadores/misIndicadores';
	});
	
	$('#linkAmbitos').on('click',function(){
		$('#divAmbitos').slideDown('slow');
		$('#divUnidades').hide();
	});

	$('#linkUnidades').on('click',function(){
		$('#divAmbitos').hide();
		$('#divUnidades').slideDown('slow');
	});


		/*$.ajax({  ///- - BUSCA FECHA DE ULTIMA EVALUACION - - -
			type: 'post',
			url: baseUrl+'Indicadores/getUltima',
			data: {idIndicador: indicador},
			success: function(data){
				fecha = data;
				console.log('la fecha es: '+fecha);

				$.ajax({ // - - - 
					type: 'post',
					url: baseUrl+'Indicadores/validateDate',
					data: {fecha: fecha, idIndicador: indicador},
					success: function(data){
						console.log('validacion '+data);
						if (data == 1) {
							console.log('No se puede');
							$("#txtvalor1").attr('disabled','disabled');
							$("#txtvalor2").attr('disabled','disabled');
							$("#btnGuadar").attr('disabled','disabled');
						}else{
							console.log('Si se puede');
						}
					},
					error: function(){
						console.log('error ajax validacion');
					}
				});
			},
			error: function(){
				console.log('error ajax con fecha');
			}
		});*/

});






