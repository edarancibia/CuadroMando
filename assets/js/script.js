$(document).ready(function(){

	var email;

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
	var baseUrl = window.location.origin+'/CuadroMando/index.php/';

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
					parsedRes = parseInt(parsedNum / parsedDen * 100);
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

	//SECCION MODAL ENVIO DE CORREO DESDE VISTA DE SUPERVISOR - -  - - - -  -
	$( function() {
    var dialog, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#txtmail" ),
      email = $( "#txtasunto" ),
      password = $( "#txtmensaje" ),
      allFields = $( [] ).add( name ).add( email ).add( password ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }

    function correo(){

    	if ($('#txtmail').val() != '') {
    		var $div = $('<div id="spinner" <i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true"></i> ');
			$div.css({
			    height: '40px',
			    width: '40px',
			    //background: 'red'
			});
	 		
			$("#dialog-form").append($div);

	    	var para = $('#txtmail').val();
	    	var asunto = $('#txtasunto').val();
	    	var mensaje = $('#txtmensaje').val();

	    	$.ajax({
	    		type: 'post',
	    		url: baseUrl +'Mail/sendMail',
	    		data: {to: para, subject: asunto, message: mensaje},

	    		success: function(){
	    			$('#txtmail').val('');
	    			$('#txtasunto').val('');
	    			var mensaje = $('#txtmensaje').val('');
	    			toastr.success('Mensaje enviado exitosamente');
	    			$("#dialog-form").dialog( "close" );
	    			$('#spinner').hide();
	    		},
	    		error: function(){
	    			console.log('error ajax envio de correo');
	    		}
	    	});
    	}else{
    		toastr.error('Ingrese destinatario');
    		$('#txtmail').focus();
    	}
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 460,
      width: 400,
      modal: true,
      buttons: {
        "Enviar": correo,

        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( ".btnmail" ).button().on( "click", function() {
    	var id = $(this).data('id');
    	getEmail(id);
      	dialog.dialog( "open" );
    });

     $( ".btnmail2" ).button().on( "click", function() {
     	var id = $(this).data('id');
     	getEmail(id);
      	dialog.dialog( "open" );
    });

     //obtiene json con datos del responsable desde el controlador INDICADORES
     function getEmail(id){
     	 $.ajax({
     		type: 'post',
     		url: baseUrl + 'Indicadores/Responsable',
     		data: {idIndicador: id},
     		dataType: 'json',
     		success: function(data){
    			email = data.resp.email;
    			$('#txtmail').val(email);
    			$('#txtmail').attr('disabled','disabled');;
     		},
     		error: function(){
     			console.log('error ajax al buscar email');
     		}
     	});
     }
 });

/* * * * *    FIN SECCION ENVIO DE EMAIL ****************** * * * * * ** * * * ** * * */

	/*$("td").each(function() {
	    var value = this.innerHTML;
	    if (value === 'No' || value === 'NO' || value === 'no') {
	        $(this).parent('tr').addClass('no');
	    } 
	});*/

	//$(function() {
	    /* Obtiene todas las filas del body de la tabla*/
	//	const filas = $('#tablaUnidad tbody tr');
	    /* Itera sobre los valores de dicha fila */
	//	for(let i=0 ;i<filas.length;i++){
	         /* Compara los valores , obteniendo los hijos con ChildNodes, 
	          donde el primer td será el Indice 1 , como deseo acceder al segundo Td ,
	           accedo al indice 3*/
	/*		if(filas[i].childNodes[9].innerText=='NO'){
				filas[i].style.background= '#ccc';
			}
		}
	});*/


//------------- COLOREAR TABLAS SEGUN CUMPLIMIENTO DE INDICADORES --- - -
	$(function() {
	  $("#tablaUnidad td:last-child:contains(NO)")
	    .parents("tr")
	    .css("background-color", "#F4A460");
	});

	$(function() {
	  $("#tablaAmbito td:last-child:contains(NO)")
	    .parents("tr")
	    .css("background-color", "#F4A460");
	});
	//---------------------- - - - - - - - - - - -- - - - - - - -- - - - - -- 

});






