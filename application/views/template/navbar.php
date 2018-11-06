<nav class="navbar navbar-inverse bg-inverse navMargen">
  <div class="container">
  	<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Calidad CBO</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url('index.php/welcome/Home'); ?>">Inicio <span class="sr-only">(current)</span></a></li>
        <!--<li><a href="<?php echo base_url('index.php/Indicadores/MisUnidades')?>">Mediciones</a></li>-->
        <li><a href="<?php echo base_url('index.php/Welcome/Reemplazando')?>">Reemplazar</a></li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->

  </div>
</nav>

<?php
  if(!($this->session->userdata('user') == true)){
       echo "Sesion expirada";
       redirect(base_url(),'refresh');
    }
?>

<div style="width: max;">

  <a href="<?php echo base_url('index.php/welcome/Home'); ?>" class="bntInicio"><span class="glyphicon"><i class="fa fa-home" aria-hidden="true"></i></span></a>
  <div style="width: 150px;float:right;">
    <a href="<?php echo base_url('index.php/welcome/logout'); ?>" class="logout">Cerrar sesión <i class="fa fa-sign-out" aria-hidden="true"></i></a>
  </div>
  <div style="width: 300px;float:right;">
    <p class=""><?php echo $this->session->userdata('user'); ?></p>
  </div>

</div>