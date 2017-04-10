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

	$('#btnGuadar').on('click',function(e){ //- - - Guarda datos de evaluacion de indicador - - 
		e.preventDefault();
		$('#dialog-confirm2').dialog("open");		
	});

	$( function () { //DIALOG CONFIRM EVALUACION PERIODICA
		$( "#dialog-confirm2" ).dialog({

			    resizable: false,
			    autoOpen: false,
			    height: "auto",
			    width: 400,
			    modal: true,
			    buttons: {
			   	 "Guardar": function() {
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

						var res = numerador/denominador*100;

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
								$('#txtresultado').val(res+'%');
								$("#btnGuadar").attr('disabled','disabled');

							},
							error: function(){
								console.log('error ajax al guardar');
							}
						});
					}
					 $( this ).dialog( "close" );
			   	 		
			      },
			       Cancelar: function() {
			         $( this ).dialog( "close" );
			       }
			    }
		});
	});

	/*$('#btnVolver').on('click',function(){
		location.href = baseUrl+'Indicadores/misIndicadores3';
	});*/
	
	$('#linkAmbitos').on('click',function(){
		$('#divAmbitos').slideDown('slow');
		$('#divUnidades').hide();
	});

	$('#linkUnidades').on('click',function(){
		$('#divAmbitos').hide();
		$('#divUnidades').slideDown('slow');
	});

	//- - - -  - - -  INFORME TRIMESTRAL- - - - - - - - - -  - - - 

	$('#btnGuardaInforme').on('click',function(e){

		e.preventDefault();
		$('#dialog-confirm').dialog("open");	

	});


	$( function () { //DIALOG CONFIRM INFORME
		$( "#dialog-confirm" ).dialog({
			    resizable: false,
			    autoOpen: false,
			    height: "auto",
			    width: 400,
			    modal: true,
			    buttons: {
			   	 "Guardar": function() {
			   	 		var comentarios = $('#comentarios').val();
						var plan = $('#plan').val();
						var periodo = $('#txtperiodo').val();
						var idIndicador = $('input#textIdindicador').val();
						var resultado = $('#txtresultado').val();
			   	 		$.ajax({
							type: 'post',
							url: baseUrl + 'Informe/GuardaInforme',
							data: {idIndicador: idIndicador, periodo: periodo, comentarios: comentarios, plan: plan,resultado: resultado},
							success: function(){
								toastr.success('Informe guardado exitosamente');
								$('#txtperiodo').val('');
								$('#comentarios').val('');
								$('#plan').val('');
							},
							error: function(){
								console.log('error ajax al guardar informe');
							}
						});

			       	console.log('ok confirm');
			        $( this ).dialog( "close" );
			      },
			       Cancelar: function() {
			         $( this ).dialog( "close" );
			       }
			    }
		});
	});

	/*$('#btnVolver2').on('click',function(){
		location.href = baseUrl+'Indicadores/misIndicadores3';
	});*/

});






