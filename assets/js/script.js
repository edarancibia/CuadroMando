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

						var res = denominador/numerador*100;

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
								$('#txtresultado').val(parsedRes+'%');
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
		if ($('#txtperiodo').val() == '' || $('#comentarios').val() == '' || $('#plan').val() == '') {
			toastr.error('Complete todos los campos');
		}else{
			e.preventDefault();
			$('#dialog-confirm').dialog("open");	
		}

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


// - - - - - -  -SECCION ADMINISTRACION - - - - - - - - - 
	//MANTENCION DE INDICADORES
	$('#txtCaracteristica').each(function(i, el) {
	    var that = $(el);
	    that.autocomplete({
	        source: baseUrl+'Indicadores/getCaracteristica',
	       /* select: function( event , ui ) {
	            alert( "You selected: " + ui.item.label );
	        }*/
	    });
	});

	$('#btnGuardaIndicador').on('click',function(e){

		if ($('#txtCaracteristica').val().length < 1 || $('#txtUmbral').val() < 1 || $('#txtDescIndicador').val() < 1  || $('#txtf1').val() < 1 ||$('#txtf2').val() < 1) {
			toastr.error('Complete todos los campos');
			return false;
		}else{
			e.preventDefault();
			$('#dialog-confirm3').dialog("open");	
		}

	});

	$( function () { //DIALOG CONFIRM NUEVO INDICADOR
		$( "#dialog-confirm3" ).dialog({

			    resizable: false,
			    autoOpen: false,
			    height: "auto",
			    width: 400,
			    modal: true,
			    buttons: {
			   	 "Guardar": function() {
			   	 	var unidad = $('#cboUnidades').val();
			   	 	var caract = $('#txtCaracteristica').val();
			   	 	var desc = $('#txtDescIndicador').val();
			   	 	var umbral = $('#txtUmbral').val();
			   	 	var umbralDesc = $('#cboTipUmbral').val();
			   	 	var resp = $('#cboResponsable').val();
			   	 	var umbralDesc2;
			   	 	var f1 = $('#txtf1').val();
			   	 	var f2 = $('#txtf2').val();
			   	 	var a,b,c,d,e,f,g,h,i,j,k,l,m;
			   	 	var subUnidad2;
			   	 	var nuevoIndicador;

			   	 	if ($('#chksubu1').is(':checked')) {
			   	 		a = $('#chksubu1').val();
			   	 	}else{
			   	 		a = '';
			   	 	}

			   		if ($('#chksubu2').is(':checked')) {
			   	 		b = $('#chksubu2').val();
			   	 	}else{
			   	 		b = '';
			   	 	}

			   	 	if ($('#chksubu3').is(':checked')) {
			   	 		c = $('#chksubu3').val();
			   	 	}else{
			   	 		c = '';
			   	 	}

				   	 if ($('#chksubu4').is(':checked')) {
			   	 		d = $('#chksubu4').val();
			   	 	}else{
			   	 		d = '';
			   	 	}

			   	 	if ($('#chksubu5').is(':checked')) {
			   	 		e = $('#chksubu5').val();
			   	 	}else{
			   	 		e = '';
			   	 	}

			   	 	if ($('#chksubu6').is(':checked')) {
			   	 		f = $('#chksubu6').val();
			   	 	}else{
			   	 		f = '';
			   	 	}

			   	 	if ($('#chksubu7').is(':checked')) {
			   	 		g = $('#chksubu7').val();
			   	 	}else{
			   	 		g = '';
			   	 	}

			   	 	if ($('#chksubu8').is(':checked')) {
			   	 		h = $('#chksubu8').val();
			   	 	}else{
			   	 		h = '';
			   	 	}

			   	 	if ($('#chksubu9').is(':checked')) {
			   	 		i = $('#chksubu9').val();
			   	 	}else{
			   	 		i = '';
			   	 	}

			   	 	if ($('#chksubu10').is(':checked')) {
			   	 		j = $('#chksubu10').val();
			   	 	}else{
			   	 		j = '';
			   	 	}

			   	 	if ($('#chksubu11').is(':checked')) {
			   	 		k = $('#chksubu11').val();
			   	 	}else{
			   	 		k = '';
			   	 	}

			   	 	if ($('#chksubu12').is(':checked')) {
			   	 		l = $('#chksubu12').val();
			   	 	}else{
			   	 		l = '';
			   	 	}

			   	 	if ($('#chksubu13').is(':checked')) {
			   	 		m = $('#chksubu13').val();
			   	 	}else{
			   	 		m = '';
			   	 	}

			   	 	var subUnidad = a+' '+b+' '+c+' '+d+' '+e+' '+f+' '+g+' '+h+' '+i+' '+j+' '+k+' '+l+' '+m;
			   	 	subUnidad2 = subUnidad.trim();

			   	 	if (umbralDesc == 1) {
			   	 		umbralDesc2 = umbral;
			   	 	}

			   	 	if (umbralDesc == 2) {
			   	 		umbralDesc2 = '>='+umbral;
			   	 	}

			   	 	if (umbralDesc == 3) {
			   	 		umbralDesc2 = '<='+umbral;
			   	 	}
			   	 

			   	 	$.ajax({
			   	 		type: 'post',
			   	 		url: baseUrl+'Indicadores/nuevo',
			   	 		data: {caract:caract,desc:desc,umbral:umbral,umbralDesc:umbralDesc2,f1:f1,f2:f2,subUn: subUnidad2},
			   	 		success: function(d){
			   	 			console.log('el codigo indicadores es: '+d);
			   	 			nuevoIndicador = d;
			   	 			toastr.success('Indicador guardado exitosamente');
			   	 		},
			   	 		error: function(){
			   	 			console.log('error ajax al guardar nuevo indicador');
			   	 		}
			   	 	}).done(function(){

			   	 				$.ajax({
									type: 'post',
									url: baseUrl+'Indicadores/relIndUnidad',
									data: {idIndicador: nuevoIndicador,idUnidad:unidad},
									success: function(){
										console.log('relacion ind unidad guardada exitosamente');
									},
									error: function(){
										console.log('error ajax en relacion ind-unidad');
									}
								});

			   	 				$.ajax({
									type: 'post',
									url: baseUrl+'Indicadores/relIndCar',
									data: {idIndicador: nuevoIndicador,idCargo:resp},
									success: function(){
										console.log('relacion ind cargo guardada exitosamente');
									},
									error: function(){
										console.log('error ajax en relacion ind-cargo');
									}
								});

								limpiarMantendor();

			   	 	});

					 $( this ).dialog( "close" );
			   	 		
			      },
			       Cancelar: function() {
			         $( this ).dialog( "close" );
			       }
			    }
		});
	});

	function limpiarMantendor(){
		$('#txtCaracteristica').val('');
		$('#txtDescIndicador').val('');
		$('#txtUmbral').val('');
		$('#txtf1').val('');
		$('#txtf2').val('');
		$('#chksubu1 :checked').removeAttr('checked');
		$('#chksubu2 :checked').removeAttr('checked');
		$('#chksubu3 :checked').removeAttr('checked');
		$('#chksubu4 :checked').removeAttr('checked');
		$('#chksubu5 :checked').removeAttr('checked');
		$('#chksubu6 :checked').removeAttr('checked');
		$('#chksubu7 :checked').removeAttr('checked');
		$('#chksubu8 :checked').removeAttr('checked');
		$('#chksubu9 :checked').removeAttr('checked');
		$('#chksubu10 :checked').removeAttr('checked');
		$('#chksubu11 :checked').removeAttr('checked');
		$('#chksubu12 :checked').removeAttr('checked');
		$('#chksubu13 :checked').removeAttr('checked');
	}

});






