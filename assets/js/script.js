$(document).ready(function(){
	var baseUrl = 'http://localhost/CuadroMando/index.php/';

	//- - - - -   Login - - -  - - - -  - 
	$('#btnLogin').on('click', function(){
		var rut = $('#rut').val();
		var clave = $('#password').val();

		$.ajax({
			type: 'post',
			url: baseUrl+'login/wsLoginSicbo',
			data: {rut_num: rut, clave: clave},
			success: function(data){
				console.log(data);
				if (data == 'pasa') {
					location.href = baseUrl+'Indicadores/';
					//getIndicadoresByCargo();
				}else{

					Command: toastr["error"]("Rut o contraseña incorrectos")

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
				
			},
			error: function(){
				console.log("error ajax login");
			}
		});
	});
	// - - - - - - -  - - -  - - - - -     - -    - - -
		
	//- - - - - - Indicadores - - - - - - -   -  - - - -

	function getIndicadoresByCargo(){
		var rut = $('#rut').val();

		$.ajax({
			type: 'post',
			url: baseUrl+'Indicadores/getIndicaCargo',
			data: {rut: rut},
			success: function(data){
				console.log(data);
			},
			error: function(){
				console.log("error ajax con indicadores");
			}
		});
	}
});