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
        <li class="active"><a href="<?php echo base_url('index.php/welcome/HomeSupervisor'); ?>">Inicio <span class="sr-only">(current)</span></a></li>
        <li><a href="<?php echo base_url('index.php/Informe/ReportsIndex')?>">Informes</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('index.php/Indicadores/mantencion')?>">Nuevo indicador</a></li>
            <li><a href="<?php echo base_url('index.php/Indicadores/editIndicador')?>">Modificar indicador</a></li>
            <li><a href="<?php echo base_url('index.php/Indicadores/EditIndex')?>">Modificar datos</a></li>
            <li><a href="<?php echo base_url('index.php/Unidad/')?>">Nuevo Servicio</a></li>
            <li><a href="<?php echo base_url('index.php/Registro/NewUser')?>">Nuevo Usuario</a></li>
          </ul>
        </li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->

  </div>
</nav>

<?php
  if(!($this->session->userdata('user') == true)){
       echo "session expirada";
       redirect(base_url(),'refresh');
    }
?>

<div style="width: max;">

  <a href="<?php echo base_url('index.php/welcome/HomeSupervisor'); ?>" class="bntInicio"><span class="glyphicon"><i class="fa fa-home" aria-hidden="true"></i></span></a>
  <div style="width: 150px;float:right;">
    <a href="<?php echo base_url('index.php/welcome/logout'); ?>" class="logout">Cerrar sesión <i class="fa fa-sign-out" aria-hidden="true"></i></a>
  </div>
  <div style="width: 300px;float:right;">
    <p><?php echo $this->session->userdata('user'); ?></p>
  </div>

</div>