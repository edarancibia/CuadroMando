$(document).ready(function(){

	var email,resp,resp2,resp3;

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
	var baseUrl = window.location.origin+'/erwin/CuadroMando/index.php/';

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

	$('#cbomes').change(function(){
		var anio = $('#cboAnio').val();
		var mes = $('#cbomes').val();
		var periodo = anio.concat(mes);
		console.log(anio+mes);
		var indicador = $('#txtIdindicador').val();

		$.ajax({ // - - - COMPRUEBA SI HAY ALGUNA EVALUACION DURANTE EL PERIODO ACTUAL
				type: 'post',
				url: baseUrl+'Indicadores/validateDate',
				data: {periodo: periodo, idIndicador: indicador},
				success: function(data){
					//console.log('validacion '+data);
					if (data == 1) {
						//console.log('No se puede');
						$("#txtvalor1").attr('disabled','disabled');
						$("#txtvalor2").attr('disabled','disabled');
						$("#btnGuadar").attr('disabled','disabled');
						toastr.warning('Ya existen datos para este periodo');

						$.ajax({
							type: 'post',
							url: baseUrl+'Indicadores/GetDatosMes',
							data: {periodo: periodo, idIndicador: indicador},
							success: function(data){
								var obj = JSON.parse(data);
								var num = obj.datosPer[0].numerador;
								var den = obj.datosPer[0].denominador;
								var res = obj.datosPer[0].resultado;
								$("#txtvalor1").val(den);
								$("#txtvalor2").val(num);
								$('#txtresultado').val(res);
								//console.log('numerador: '+num);
							},
							error: function(){
								console.log('error al obtener datos del periodo');
							}
						});
					}else{
						$("#txtvalor1").attr('disabled',false);
						$("#txtvalor2").attr('disabled',false);
						$("#btnGuadar").attr('disabled',false);
						//console.log('Si se puede');
						$('#txtvalor1').val('');
						$('#txtvalor2').val('');
						$('#txtresultado').val('');
						$('#txtvalor1').focus();
					}
				},
				error: function(){
					console.log('error ajax validacion');
				}
			});
	});

	$('#btnGuadar').on('click',function(e){ //- - - Guarda datos de evaluacion de indicador - - 
		e.preventDefault();
		if ($('#cbomes').val() == 0) {
			toastr.error('Seleccione mes');
		}else{
			$('#dialog-confirm2').dialog("open");	
		}	
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
			        var anio = $('#cboAnio').val();
					var mes = $("#cbomes").val();
					var periodo = anio.concat(mes);
			        var indicador = $('#txtIdindicador').val();
					parsedDen = parseInt(denominador);
					parsedNum = parseInt(numerador);

					var roundDen = Math.round(denominador);
					var roundNum = Math.round(numerador);

					var roundDen = denominador;
					var roundNum = numerador;
					var fecha2 = moment().format('L');
					console.log('den'+roundDen, 'num'+roundNum);

					if (parsedDen == 0) {
						parsedDen = roundDen
						parsedNum = roundNum;	
						parsedRes = 0;

						$.ajax({
							type: 'post',
							url: baseUrl+'Indicadores/guardaEvaluacion',
							data: {numerador: parsedNum,denominador: parsedDen,multiplicador: 100, resultado: 0,idIndicador: indicador,fecha: fecha2, periodo: periodo},
							success: function(data){
								console.log('Guardado exitosamente');
								$('#txtvalor1').val('');
								$('#txtvalor2').val('');
								toastr.success('Datos guardados exitosamente');
								configToastr();
								$('#txtresultado').val(0+'%');
								$("#btnGuadar").attr('disabled','disabled');

							},
							error: function(){
								console.log('error ajax al guardar');
							}
						});
					}else{
						console.log('aqui');
						
						parsedRes = parseInt(parsedDen / parsedNum * 100);
						var parsedRes_ = parsedRes.toFixed(2);
						//var res = roundDen/roundNum*100;
						var roundRes2 = denominador/numerador *100;
						//var roundRes = roundRes2.toFixed(2);
						var roundRes3 = Math.round(roundRes2);
						console.log('aqii'+parsedDen,parsedNum,roundRes3);
						//aqui quede domingo 13 enero
						$.ajax({
							type: 'post',
							url: baseUrl+'Indicadores/guardaEvaluacion',
							data: {numerador: roundNum,denominador: roundDen,multiplicador: 100, resultado: roundRes3,idIndicador: indicador,fecha: fecha2, periodo: periodo},
							success: function(data){
								console.log('Guardado exitosamente');
								$('#txtvalor1').val('');
								$('#txtvalor2').val('');
								toastr.success('Datos guardados exitosamente');
								configToastr();
								//$('#txtresultado').val(String.fromCharCode(roundRes3)+'%');
								$('#txtresultado').val(roundRes3+'%');
								$("#btnGuadar").attr('disabled','disabled');

							},
							error: function(){
								console.log('error ajax al guardar');
							}
						});		
					}
					
					var fecha2 = moment().format('L');

					if (denominador == '') {
						toastr.info('Ingrese valores');
						configToastr();
						$('#txtvalor2').focus();
					}else if(numerador == ''){
						toastr.info('Ingrese valores');
						$('#txtvalor2').focus();
					}else{

						//var res = denominador/numerador*100;

						if (parsedRes == 0) {
							//var roundRes = 0;
							var roundRes2 = denominador/numerador *100;
							//var roundRes = roundRes2.toFixed(2);
							var roundRes = Math.round(res);
							
						}else{
							var res = roundDen/roundNum*100;
							var roundRes =	Math.round(res);
							//var roundRes =	res;
							
						}

						//console.log('numerador='+roundDen+ ' '+'denominador='+roundNum+ 'resultado='+roundRes);

						/*$.ajax({
							type: 'post',
							url: baseUrl+'Indicadores/getFormula',
							data: {idIndicador: indicador},
							success: function(d){
								var obj = JSON.parse(d);
								var formula = obj.form.umbralDesc;
								$('#txtresultado').val(roundRes+'%');
								if (formula.contains('<')) {
									console.log('es menos o igual');
								}
							},
							error: function(){
								console.log('error al obtener formula');
							}
						});*/

						/*$.ajax({
							type: 'post',
							url: baseUrl+'Indicadores/guardaEvaluacion',
							data: {numerador: roundNum,denominador: roundDen,multiplicador: 100, resultado: roundRes,idIndicador: indicador,fecha: fecha2, periodo: periodo},
							success: function(data){
								console.log('Guardado exitosamente');
								$('#txtvalor1').val('');
								$('#txtvalor2').val('');
								toastr.success('Datos guardados exitosamente');
								configToastr();
								$('#txtresultado').val(roundRes+'%');
								$("#btnGuadar").attr('disabled','disabled');

							},
							error: function(){
								console.log('error ajax al guardar');
							}
						});*/
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
						var periodoDet = $('#txtperiodo').val();
						var idIndicador = $('input#textIdindicador').val();
						var resultado = $('#txtresultado').val();
						var periodo = $('#txtperiodo2').val();

			   	 		$.ajax({
							type: 'post',
							url: baseUrl + 'Informe/GuardaInforme',
							data: {idIndicador: idIndicador, periodo: periodo ,periodoDet: periodoDet, comentarios: comentarios, plan: plan,resultado: resultado},
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
    			var d = data.resp;
    			email = d.email;
    			$('#txtmail').val(email);
    			$('#txtmail').attr('disabled','disabled');;
     		},
     		error: function(XMLHttpRequest, textStatus, errorThrown){
     			console.log('error: '+textStatus);
     		}
     	});
     }
 });

/* * * * *    FIN SECCION ENVIO DE EMAIL ****************** * * * * * ** * * * ** * * */


//------------- COLOREAR TABLAS SEGUN CUMPLIMIENTO DE INDICADORES --- - -
	$(function() {
	  $("#tablaUnidad td:last-child:contains(NO)")
	    .parents("tr")
	    .css("background-color", "#ffcccc");
	});

	$(function() {
	  $("#tablaAmbito td:last-child:contains(NO)")
	    .parents("tr")
	    .css("background-color", "#ffcccc");
	});

	$(function() {
	  $("#tablaMedicion td:last-child:contains(NO)")
	    .parents("tr")
	    .css("background-color", "#ffcccc");
	});
	//---------------------- - - - - - - - - - - -- - - - - - - -- - - - - -- 


// - - - - - -  -SECCION ADMINISTRACION - - - - - - - - - - - - - - - --  - - 
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

	$('#cboResponsable').on('change', function(){
		//obtiene rut del encargado
		resp = $('#cboResponsable').val();

		$.ajax({
			type: 'post',
			url: baseUrl+'Indicadores/getRutResNuevo',
			data: {idCargo: resp},
			success: function(d){
				var obj = JSON.parse(d);
				resp2 = obj.resp.fk_rut_num;
				$('#hiddenRutRes').val(resp2);
				resp3 = $('#hiddenRutRes').val(resp2);
			},
			error: function(){
				console.log('error ajax obteniendo rut resp');
			}
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
			   	 	var umbralDesc2;
			   	 	var f1 = $('#txtf1').val();
			   	 	var f2 = $('#txtf2').val();
			   	 	var a,b,c,d,e,f,g,h,i,j,k,l,m;
			   	 	var subUnidad2;
			   	 	var nuevoIndicador,nuevoIndicador2;
			   	 	var unidad2;
			   	 	var resp4 = $('#hiddenRutRes').val();

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
			   	 			//console.log('el codigo indicadores es: '+d);
			   	 			nuevoIndicador = d;
			   	 			$('#hiddenIndi').val(nuevoIndicador);
			   	 			toastr.success('Indicador guardado exitosamente');
			   	 		},
			   	 		error: function(){
			   	 			//console.log('error ajax al guardar nuevo indicador');
			   	 		}
			   	 	}).done(function(){
		   	 				$.ajax({
								type: 'post',
								url: baseUrl+'Indicadores/relIndUnidad',
								data: {idIndicador: nuevoIndicador,idUnidad:unidad,idCargo:resp,rut_res: resp4},
								success: function(){
									console.log('relacion ind unidad guardada exitosamente');
								},
								error: function(){
									console.log('error ajax en relacion ind-unidad');
								}
							});
			   	 	});			

								limpiarMantendor();

			   	 	
				

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

	//filtra indicadores por unidad en mantencion de responsables
	$('#cboUnidad').change(function(){
		var idUnidad = $('#cboUnidad').val();

		$.ajax({
			type: 'post',
			url: baseUrl+'Indicadores/ListaPorUnidad',
			//dataType: 'JSON',
			data: {idUnidad: idUnidad},
			success: function(d){
				var data = d.indicadores;
				
    			$('#records_table tr').remove();

				$.each(data, function(i, item){
					$('<tr>').html(
        				"<td>"+data[i].idIndicador +"</td><td>"+ data[i].codigo + "</td><td>" + data[i].desc_subUn + "</td><td>" + data[i].descripcion + "</td><td><input type='radio' name='rdInd' id='rdInd'/></td>").appendTo('#records_table');
				});
			},
			error: function(jqXHR, exception){
				console.log(jqXHR);
			}
		});
	});

	 $('input:radio').change(function(){
        alert('changed');   
    });          



//  - - - - -- - FIN ADMINISTRACION - - - - - -- - 

// ocultar filas de tablas de resultados segun cumplimiento

	$("#btnFiltrar").on('click',function(){
		
	  $("#tablaUnidad td:last-child:contains(SI)")
	    .parents("tr").toggle();

	});

	$("#btnFiltrar2").on('click',function(){
	  $("#tablaAmbito td:last-child:contains(SI)")
	    .parents("tr").toggle();

	});

	$("#btnFiltrar3").on('click',function(){
	  $("#tablaMedicion td:last-child:contains(SI)")
	    .parents("tr").toggle();

	});

	$('#tabla-preview td:last-child:contains(SI)')
		.parents('tr').toggle();


	$('#btnModDatos').on('click',function(){
		$('#dialog-confirm4').dialog("open");

		
	});

	$( function () { //DIALOG CONFIRM MODIFICA DATOS
		$( "#dialog-confirm4" ).dialog({
			    resizable: false,
			    autoOpen: false,
			    height: "auto",
			    width: 400,
			    modal: true,
			    buttons: {
			   	 "Guardar": function() {
			   	 
			   	 	var numerador = $('#txtf1').val();
					var denominador = $('#txtf2').val();
					var idIndicador = $('#txtIdIndicador2').val();
					var periodo = $('#txtperiodo3').val();

					//con decimales
					var roundNum2 = numerador;
					var roundDen2 = denominador;
			   	 		
			   	 		$.ajax({
							type: 'post',
							url: baseUrl + 'Indicadores/Edit',
							data: {idIndicador: idIndicador, numerador: roundDen2,denominador: roundNum2,periodo: periodo},
							success: function(){
								toastr.success('Datos modificados exitosamente');
								$('#txtperiodo').val('');
								$('#comentarios').val('');
								$('#plan').val('');
							},
							error: function(){
								console.log('error ajax al modificar datos');
							}
						});

			       	
			        $( this ).dialog( "close" );
			      },
			       Cancelar: function() {
			         $( this ).dialog( "close" );
			       }
			    }
		});
	});

	//LISTA DE INDICADORES EN BUSCADOR DE INFORMES
	$('#btnReport2').on('click',function(){
		var cuarto = $('#cboTrimestre').val();
		var anio = $('#cboanio6').val();
		var idUnidad = $('#cboUnidad').val();

		$.ajax({
			type: 'post',
			url: baseUrl + 'Informe/Reports',
			data: {idUnidad: idUnidad},
			success: function(d){
				var data = JSON.parse(d);
				$('#table-reports tr').remove();

				$.each(data.lista, function(i, item){
					$('<tr>').html(
        				"<td>"+data.lista[i].carac+' '+data.lista[i].desc_subUn+"</td><td>"+ 
        				data.lista[i].descInd + "</td><td>" + data.lista[i].responsable+
        				"<td><a href="+baseUrl+"Informe/GetReport?idIndicador="+data.lista[i].idIndicador+
        				"&trimestre="+cuarto+"&anio="+anio+"&idUnidad="+idUnidad+"&rut="+data.lista[i].rut+
        				" target='blank' class='btn btn-danger'><i class='fa fa-print' aria-hidden='true'></i></a></td>"+
        				"<td><a href="+baseUrl+"Informe/UpdateReport?idIndicador="+data.lista[i].idIndicador+
        				"&trimestre="+cuarto+"&anio="+anio+"&idUnidad="+idUnidad+"&rut="+data.lista[i].rut + ' '+
        				" target='blank' class='btn btn-primary'>Editar <i class='fa fa-pencil' aria-hidden='true'></a></td>").appendTo('#table-reports');
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
		});
	})

	//llena lista de indicadores por unidad para editar datos
	$('#btnEditIndex').on('click',function(){
		var idUnidad = $('#cboUnidad2').val();

		$.ajax({
			type: 'post',
			url: baseUrl + 'Indicadores/EditList',
			data: {idUnidad: idUnidad},
			success: function(d){
				var data = JSON.parse(d);
				
				$('#table-edit tr').remove();

				$.each(data.lista, function(i, item){
					$('<tr>').html(
        				"<td>"+data.lista[i].carac+' '+data.lista[i].desc_subUn+"</td><td>"+ 
        				data.lista[i].descInd + "</td><td>" + data.lista[i].responsable+
        				"<td><button type='button' data-id="+data.lista[i].idIndicador+" data-toggle='modal' data-target='#modalEditValues' class='btn btn-info'>Modificar</button></td>").appendTo('#table-edit');
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
		});
	});


	//EDITA INFORMES
	$('#btnModInforme').on('click',function(){
		var idIndicador = $('#textIdindicador_').val();
		var periodoDet = $('#txtperiodo_').val();
		var periodo = $('#txtperiodo3').val();
		var comentarios = document.getElementById("comentarios_").value;
		var plan2 = document.getElementById("plan_").value;
		var resultado = $('#txtresultado_').val();
		var fecha; 

		if($('#txtfechaInforme').val() === ''){
			fecha = $('#txtfechaInforme2').val();
		}else{
			fecha = $('#txtfechaInforme').val();
		}

		//console.log(idIndicador+' '+periodo+' '+periodoDet+' '+resultado+' '+comentarios+' '+plan2);

		$.ajax({
			type: 'post',
			url: baseUrl + 'Informe/UpdateReport2',
			data: {idIndicador: idIndicador, periodo: periodo, periodoDet: periodoDet, resultado: resultado, comentarios: comentarios,plan: plan2, fecha: fecha},
			success: function(){
				//console.log(idIndicador+' '+periodo+' '+periodoDet+' '+resultado+' '+comentarios+' '+plan);
				toastr.success('Informe modificado exitosamente!');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
		});

	});

	$('#btnVolver').on('click',function(){
		javascript:history.back(1);
	});

// - - - - -  SECCION MODAL INFORME - - - - -  - - - - 

	/*var idIndicadorModal;

	$('#myModal').on('shown.bs.modal', function (e) {
		var boton = e.relatedTarget;
  		var idIndicadorModal = $(boton).attr("data-id");
  		var idUnidad = $(boton).attr("data-unidad");

  		$('#btnModalOk').on('click',function(){
  			if ($('#cboCuarto').val() == 0) {
  				toastr.error('Seleccione trimestre');
  			}else{
  				var anio = $('#cboAnio3').val();
				var cuarto = $('#cboCuarto').val();
				
				$.ajax({
					type: 'post',
					url: baseUrl+'Informe/Informe',
					data: {idIndicador: idIndicadorModal,anio: anio,cuarto: cuarto,idUnidad:idUnidad},
					success: function(data){
						console.log(data);
					},
					error: function(jqXHR, textStatus, errorThrown){
						console.log(errorThrown);
					}
				});
  			}
		});
	});*/

	//CREA NUEVO SERVICIO - - - - - -  - - - - - - - - -
	$('#btnUnidad').on('click',function(e){

			e.preventDefault();
			$('#dialog-confirmUnidad').dialog("open");	
		

	});

	//busca si existe el usuario para asignar cargo
	$("#txtrutrespcargo").keypress(function(e) {
        if(e.which == 13) {
          var rut_encargado = $('#txtrutrespcargo').val();

          $.ajax({
          	type: 'post',
          	url: baseUrl + 'Registro/ValidateUser',
          	data: {rut_encargado: rut_encargado},
          	success: function(data){
          		var obj = JSON.parse(data);
          		//var ape1 = resp["a_pat"];
          		//console.log("dato: "+obj.encargado.a_pat);
          		$('#txtnomrespcargo').val(obj.encargado.nombre+' '+ obj.encargado.a_pat+' '+obj.encargado.a_mat);
          	},
          		error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			},
          });
        }
      });

	$( function () { //DIALOG CONFIRM MODIFICA DATOS
		$( "#dialog-confirmUnidad" ).dialog({
			    resizable: false,
			    autoOpen: false,
			    height: "auto",
			    width: 400,
			    modal: true,
			    buttons: {
			   	 "Guardar": function() {
			   	 
			   	 	var resp = $('#txtrutrespcargo').val();
			   	 	var desc = $('#txtunidad').val();
			   	 	var desCargo = $('#txtrescargo').val();
			   	 	var email = $('#txtresmail').val();
			   	 	var perfil = $('#cboPerfilUser').val();
			   	 		
			   	 		$.ajax({
							type: 'post',
							url: baseUrl + 'Unidad/Add',
							data: {desc: desc,respCargo: resp,desCargo: desCargo,email:email,perfil:perfil},
							success: function(d){
								toastr.success('Servicio guardado exitosamente');
								$('#txtunidad').val('');
								$('#txtrutrespcargo').val('');
						   	 	$('#txtrescargo').val('');
						   	 	$('#txtresmail').val('');
						   	 	$('#txtnomrespcargo').val('');

							},
							error: function(XMLHttpRequest, textStatus, errorThrown){
								console.log(XMLHttpRequest);
							}
						});

			       	
			        $( this ).dialog( "close" );
			      },
			       Cancelar: function() {
			         $( this ).dialog( "close" );
			       }
			    }
		});
	});

	//CREA CARGO Y RELACION CON UNIDAD
	$('#txtrutrespcargo').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });

	//EDITA UMBRAL DE INDICADORES
	//lista indicador por unidad para editar
	$('#btnEditIndex5').on('click', function(){
		var idUnidad = $('#cboUnidadEditaUmbral').val();

		$.ajax({
			type: 'post',
			url: baseUrl + 'Indicadores/EditList',
			data: {idUnidad: idUnidad},
			success: function(d){
				var data = JSON.parse(d);
				//console.log(data);
				$('#table-edit-umbral tr').remove();
				$.each(data.lista, function(i, item){
					$('<tr>').html(
        				"<td>"+data.lista[i].carac+' '+data.lista[i].desc_subUn+"</td><td>"+ 
        				data.lista[i].descInd + "</td><td>" + data.lista[i].responsable+
        				"<td><button type='button' data-id="+data.lista[i].idIndicador+" data-toggle='modal' data-target='#modalEditUmbral' class='btn btn-info'>Modificar</button></td>").appendTo('#table-edit-umbral');
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
		});
	});

	//NUEVO USUARIO
	$('#txtrutUsernew').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });

	$('#btnokUsernew').on('click', function(){
		var rut = $('#txtrutUsernew').val();
		var pass = $('#txtpassUsernew').val();
		var apat = $('#txtuserapat').val();
		var amat = $('#txtuseramat').val();
		var nombre = $('#txtusernom').val();
		var perfil = $('#cboPerfilUser').val();
		var cargo = $('#txtrescargo').val();
		var email = $('#txtresmail').val();
		var unidad = $('#cboUnidad').val();

		//comprueba si usuario ya existe
		$.ajax({
			type: 'post',
			url: baseUrl + 'Registro/ValidateUser',
			data: {rut_encargado: rut},
			success: function(data){
				var obj = JSON.parse(data);
          		//var ape1 = resp["a_pat"];
          		$.ajax({
						type: 'post',
						url: baseUrl + 'Registro/AddUser',
						data: {rut: rut,apat: apat, amat: amat, nombre: nombre, pass: pass,perfil:perfil,email:email,unidad:unidad,cargo:cargo},
						success: function(){
							toastr.success('Usuario creado exitosamente!');
								$('#txtrutUsernew').val('');
								$('#txtpassUsernew').val('');
								$('#txtuserapat').val('');
								$('#txtuseramat').val('');
								$('#txtusernom').val('');
								$('#txtrescargo').val('');
								$('#txtresmail').val('');
						},
						error: function(XMLHttpRequest, textStatus, errorThrown){
							console.log(XMLHttpRequest);
						}
				});
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
		});
	});

	//cambio de clave
	$('#txtrutnuevapass').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });

	$("#btnnuevapass").on('click',function(e) {
          var rut_usuario = $('#txtrutnuevapass').val();
          var nueva_pass = $('#txtnuevapass').val();

          $.ajax({
          	type: 'post',
          	url: baseUrl + 'Registro/ChangePass',
          	data: {rut_usuario: rut_usuario, nueva_pass: nueva_pass},
          	success: function(data){
          		toastr.success('Contraseña modificada exitosamente');
          		$('#txtrutnuevapass').val('');
          		$('#txtnuevapass').val('');
          	},
          		error: function(XMLHttpRequest, textStatus, errorThrown){
				toastr.error('Algo salió mal, verifica los datos');
				//console.log(XMLHttpRequest);
			},
          });
      });

	//modal editar umbral - - - -  -
	$('#modalEditUmbral').on('shown.bs.modal', function (e){
		var boton = e.relatedTarget;
		var idIndicadorModalUmbral = $(boton).attr("data-id");

		$('#txtidndicadorumbral').val(idIndicadorModalUmbral);

		$.ajax({
			type: 'post',
			url: baseUrl + 'Indicadores/GetUmbral',
			data: {idIndicador: idIndicadorModalUmbral},
			success: function(d){
				var obj = JSON.parse(d);
				$('#txtumbralactual').val(obj.umbral.umbralDesc);
				$('#txtnuevoumbral').val(obj.umbral.umbral);
				$('#desIndEdita').val(obj.umbral.descripcion);
				$('#f1edita').val(obj.umbral.formula1);
				$('#f2edita').val(obj.umbral.formula2);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				//toastr.error('Algo salió mal, verifica los datos');
				console.log(XMLHttpRequest);
			},
		});
	});

	$('#btnEditUmbral').on('click', function(){
		var idIndicador = $('#txtidndicadorumbral').val();
		var umbral = $('#txtnuevoumbral').val();
		var tipo = $('#cboTipoUmbral').val();
		var desc = $('#desIndEdita').val();
		var f1 = $('#f1edita').val();
		var f2 = $('#f2edita').val();
		var umbralDesc = tipo + umbral;
		//var data= {idIndicador: idIndicador, umbral: umbral, umbralDesc: umbralDesc,desc:desc, f1:f1, f2:f2};
		//console.log(data);
		$.ajax({
			type: 'post',
			url: baseUrl + 'Indicadores/UpdateUmbral',
			data: {idIndicador: idIndicador, umbral: umbral, umbralDesc: umbralDesc,desc:desc, f1:f1, f2:f2},
			success: function(d){
				toastr.success('Umbral actualizado exitosamente!');
				$('#txtnuevoumbral').val('');
				$('#desIndEdita').val();
				$('#f1edita').val();
				$('#f2edita').val();
				$('#modalEditUmbral').modal('hide');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				//toastr.error('Algo salió mal, verifica los datos');
				console.log(XMLHttpRequest);
			},
		});
	});

	//modifica usuario responsable de una unidad - - - -
	$('#btnReemplaza').on('click', function(e){
		//e.preventDefault();
		//$('#dialog-confirmReemplaza').dialog("open");
		
		var rut_actual = $('#cboActual').val();

		$.ajax({
			type: 'post',
			url: baseUrl + 'Registro/ReemplazarLista',
			data: {rut_actual: rut_actual},
			success: function(d){
				var data = JSON.parse(d);
				//console.log(data);
				$('#table-lista-reemplazo tr').remove();
				$.each(data.indicadores_reemplazar, function(i, item){
					$('<tr>').html(
        				
        				"<td>"+data.indicadores_reemplazar[i].Caracteristica+"</td><td>"+data.indicadores_reemplazar[i].unidad+"</td><td>"+ 
        				data.indicadores_reemplazar[i].sub + "</td><td>" + data.indicadores_reemplazar[i].descripcion+
        				"<td><button type='button' data-id="+data.indicadores_reemplazar[i].idIndicador+" data-toggle='modal' data-target='#modalAsignaReemplazo' class='btn btn-info'>Modificar</button></td>").appendTo('#table-lista-reemplazo');
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
		});	
	});

	$('#modalAsignaReemplazo').on('shown.bs.modal', function (e){
		var boton = e.relatedTarget;
		var idIndicador = $(boton).attr("data-id");
		$('#hiddenIndicador').val(idIndicador);

		$('#btnReemplazaOK').on('click', function(){
			var rut_nuevo = $('#cboNuevoResp').val();
			//var indicador2 = $('#hiddenIndicador').val(idIndicador);

			$.ajax({
				type: 'post',
				url: baseUrl+'Registro/InsertDelegate_',
				data: {idIndicador: idIndicador, rut_nuevo: rut_nuevo},
				success: function(){
					toastr.success('Indicador transferido exitosamente!');
					$('#modalAsignaReemplazo').modal('hide');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					console.log(XMLHttpRequest);
				}
			});
		});
	});


	//carga modal para editar datos del indicador
	$('#modalEditValues').on('shown.bs.modal', function (e) {
		var boton = e.relatedTarget;
		var idIndicadorModal = $(boton).attr("data-id");
		$('#txtidndicador').val(idIndicadorModal);
  		var idIndicador_ = $('#txtidndicador').val();
  		var periodo_ = $('#cboanio7').val()+$('#cbomes2').val();
  		$('#txtperiodo4').val(periodo_);

  		$.ajax({
			type: 'post',
			url: baseUrl+'Indicadores/EditIndex2',
			data: {idIndicador: idIndicador_, periodo: periodo_},
			success: function(d){
				var data = JSON.parse(d);
				if(d.length == 13){
					alert('No hay datos');
					$('#modalEditValues').modal('hide');
				}else{
					$('#lblDescInd').append(data.info[0].cod_c+'  '+data.info[0].descripcion);
				}

				$('#table-editValues tr').remove();

				$.each(data.info, function(i, item){
					$('<tr>').html( 
						"<td style='display:none;'>"+data.info[i].idIndicadorDatos+"</td>"+
        				"<td>" + data.info[i].formula1+
        				"</td><td><input type='text' class='form-control col-xs-2' id='txtvalor1' value="+data.info[i].denominador+"></td>"+
        				"<td>"+ data.info[i].formula2+
        				"</td><td><input type='text' class='form-control col-xs-2' id='txtvalor2' value="+data.info[i].numerador+"></td>"+
        				"<td><button id='btnEditValue' type='button' data-id="+data.info[i].idIndicador+" data-toggle='modal' data-target='#' class='btn btn-info'>Modificar</button></td>"+
        				"<td><button id='btnDeleteValue' type='button' data-id="+data.info[i].idIndicadorDatos+" data-toggle='modal' data-target='#' class='btn btn-danger'>Eliminar</button></td>").appendTo('#table-editValues');
				});
		
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
				$(".modal-body").html('');
			}
		});
	});

	$('#modalEditValues').on('hidden.bs.modal', function(){
	    $('#lblDescInd').html('');
	});

	//ELIMINAR DATOS DE INDICADORES PARA DUPLICADOS
	$(document).on("click","#btnDeleteValue",function(e) {
         
         var idIndicadorDatos_ = document.getElementById("table-editValues").rows[0].cells.item(0).innerHTML;
         
         $.ajax({
         	type: 'post',
         	url: baseUrl + 'Indicadores/RemoveValue',
         	data: {idIndicadorDatos: idIndicadorDatos_},
         	success: function(d){
         		console.log('ok');
         		$('#modalEditValues').modal('hide');
         	},
         	error: function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest);
			}
         });
	});

	$(document).on("click","#btnEditValue",function(e) {

		var idIndicadorDatos_ = document.getElementById("table-editValues").rows[0].cells.item(0).innerHTML;

		var numerador = $('#txtvalor1').val();
		var denominador = $('#txtvalor2').val();
		var idIndicador = $('#txtidndicador').val();
		var periodo = $('#txtperiodo4').val();
		var fecha = $('#txtfecha_n').val();

		//con decimales
		var roundNum2 = numerador;
		var roundDen2 = denominador;
		
		$.ajax({
			type: 'post',
			url: baseUrl + 'Indicadores/Edit',
			data: {idIndicadorDatos: idIndicadorDatos_,numerador:roundNum2,denominador: roundDen2},
			//data: {idIndicador: idIndicador, numerador: roundDen2,denominador: roundNum2,periodo: periodo,fecha: fecha},
			success: function(){
				toastr.success('Datos modificados exitosamente');
				$('#modalEditValues').modal('hide');
			},
			error: function(){
				console.log('error ajax al modificar datos');
			}
		});
	});


});






