<body class="skin-blue-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <!--<span class="logo-mini"><?php echo strtoupper(substr(Globals::getTitle(), 0, 1));?><b><?php echo strtoupper(substr(Globals::getTitle2(), 0, 1));?></b></span>-->
          <span class="logo-mini"><b>S</b>d<b>L</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
          SE - Liquidación</span>
          <!-- <span class="logo-lg"><b>Si</b>de<b>Li</b></span> -->
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li><span class="logo-lg">
              
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- <img src="" class="user-image" alt="User Image"> -->
                  <span class="hidden-xs username" > <i class="fa fa-fw fa-user fa-2" aria-hidden="true"></i> <?php echo $userName;?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <!-- <li class="user-header">
                    <img src="" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li> -->
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-12 text-center">
                      <a href="#" onclick="editProfile()" >Perfil</a>
                    </div>
                  </li>
                  <!--
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>}-->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <!--
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    -->
                    <div class="pull-right">
                      <a href="<?php  echo base_url();?>user/cerrarSession" class="btn btn-default btn-flat">Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <!--
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
              -->
            </ul>
          </div>
        </nav>
      </header>

<!-- Modal para mostrar los errores de base de datos -->
<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="cerrarError()"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelError"><i class="icon fa fa-database"></i> Error en DB!</h4> 
      </div>
      <div class="modal-body" id="modalBodyError">
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-danger alert-dismissable">
                  <div id="error_db_msj">
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="cerrarError()">Cerrar</button>
      </div>
    </div>
  </div>
</div>