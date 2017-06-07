<div class="container">

	<div class="jumbotron">
		<img src="<?php echo base_url().'assets/img/logo_final_febrero.png';?>" class="img-responsive">
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Inicio de sesión</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" method="post" role="form" action="<?= base_url('index.php/login/Login'); ?>">
                    <fieldset>
			    	  	<div class="input-group">
			    	  		<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
			    		    <input class="form-control" placeholder="Rut" name="rut" id="rut" type="text" required>
			    		</div>
			    		<br>
			    		<div class="input-group">
						  <span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
						  <input class="form-control" type="password" placeholder="Contraseña" name="password" id="password" required>
						</div>
			    		<br>
			    		<!--<button type="button" id="btnLogin" class="btn btn-lg btn-success btn-block" name="btnLogin">Iniciar sesión</button>-->
			    		<button type="submit" name="btnLogin2" id="btnLogin2" class="btn btn-success btn-lg btn-block">Iniciar sesión</button>
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
	
</div>
<script type="text/javascript">
	$('#rut').focus();
</script>
</body>