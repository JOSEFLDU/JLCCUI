<?php
//Conexión con la BDD
require_once ('conexion/conexion.php');
session_start();
//Declaramos las variables y traemos las variables del usuario
$dispositivo="";
$caracteristicas="";
$serie="";
$estado="0";
$estado1="1";
$msg="";
$x=0;
$y=0;
$usuario=$_SESSION['Usu_Id'];
$logged=$_SESSION['logged'];
$TipUsuario=$_SESSION['Tusu_Id'];
$nombre= $_SESSION['Usu_Nombre'];
$apellido=$_SESSION['Usu_Apellido'];
//verificamos si el usuario esta logeado
if (!$logged)
{
   echo "<script type=\"text/javascript\">alert(\"Ingreso xxxno Autorizado\");</script>";
   echo "<meta http-equiv='refresh' content='0;url=login.php?'>";
   die();
}
//Verificar la conexión con la BDD
if ($conn==false)
{
   echo "<script type=\"text/javascript\">alert(\"No se puedo conectar a la BDD\");</script>";
   die();
}
//verificamos el tipo de usuario
if (($TipUsuario==3))
{
   echo "<script type=\"text/javascript\">alert(\"No Tiene Permisos\");</script>";
   echo "<meta http-equiv='refresh' content='0;url=login.php?'>";
   die();
}

//Sentencia SQL para mostrar los datos
$result7 = $conn -> query("SELECT * FROM `Dispositivo` WHERE `Usu_Id` = '".$usuario."' AND Dis_Estado = '".$estado."'");
$Dispositivo7 = $result7-> fetch_all(MYSQLI_ASSOC);

//Se verifica si los campos están llenados
if(isset($_POST['dispositivo'])&& isset($_POST['caracteristicas']) && isset($_POST['serie']))
{
  $dispositivo=strip_tags($_POST['dispositivo']);
  $caracteristicas=strip_tags($_POST['caracteristicas']);
  $serie=strip_tags($_POST['serie']);

  //Sentencia SQL para validar el nombre del dispositivo que no se repita
  $result = $conn -> query("SELECT * FROM `Dispositivo` WHERE `Dis_Nombre` = '".$dispositivo."'");
  $Diapositivo = $result-> fetch_all(MYSQLI_ASSOC);
  //Contamos si hay el dispositivo en la tabla
  $count = count($Diapositivo);
  // si no hay el dispositivo registrado con el mismo nombre, procedemos a ingresar los datos en la bdd
  if ($count == 0)
  {
    $conn -> query("INSERT INTO `Dispositivo` (`Usu_Id`, `Dis_Nombre`, `Dis_Caracteristicas`,`Dis_Serie`,`Dis_Estado`)
    values ('".$usuario."','".$dispositivo."','".$caracteristicas."','". $serie."','". $estado."');");
    echo "<script type=\"text/javascript\">alert(\"Dispositivo Creado Correctamente\");</script>";
    echo "<meta http-equiv='refresh' content='0;url=devices.php?'>";
  }
  else
  {
    echo "<script type=\"text/javascript\">alert(\"EL Dispositivo ya existe, registre correctamente\");</script>";
  }

}
else
{
  //Para eliminar el dispositivo de forma lógica.
  if(isset($_POST['eliminarDispositivo']) && isset($_POST['eliminarDispositivo'])!="")
  {
    $DisId= $_POST['eliminarDispositivo'];
    $result1 = $conn -> query("UPDATE `Dispositivo` SET `Dis_Estado`=1 WHERE `Dis_Id`=$DisId");
    echo "<script type=\"text/javascript\">alert(\"Dispositivo Eliminado Correctamente\");</script>";
    echo "<meta http-equiv='refresh' content='0;url=devices.php?'>";
  }
  else
  {
    /*if(isset($_POST['actualizarDispositivo']) && isset($_POST['actualizarDispositivo'])!="")
    {
    $DisId1= $_POST['actualizarDispositivo'];
    $dispositivo1=$_POST['dispositivo'];
    $caracteristicas1=$_POST['caracteristicas'];
    $serie1=$_POST['serie'];
    $result8 = $conn -> query("UPDATE `Dispositivo` SET `Dis_Nombre`=$dispositivo1,`Dis_Caracteristicas`=$caracteristicas1,
                              `Dis_Serie`=$serie1 WHERE `Dis_Id`=$DisId1");
    echo "<script type=\"text/javascript\">alert(\"Dispositivo Actualizado Correctamente\");</script>";
    echo "<meta http-equiv='refresh' content='0;url=devices.php?'>";
    }*/
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Página de Inicio</title>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Imágen de la pestaña -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="assets/images/domotica-png-2.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="assets/images/domotica-png-2.png">

  <!-- style -->
  <link rel="stylesheet" href="assets/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="assets/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="assets/material-design-icons/material-design-icons.css" type="text/css" />
  <link rel="stylesheet" href="assets/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css ../assets/styles/app.min.css -->
  <link rel="stylesheet" href="assets/styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="assets/styles/font.css" type="text/css" />
</head>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->

  <!-- aside -->
  <div id="aside" class="app-aside modal nav-dropdown">
  	<!-- fluid app aside -->
    <div class="left navside dark dk" data-layout="column">
  	  <div class="navbar no-radius">
        <!-- brand -->
        <a class="navbar-brand">
        	<div ui-include="'assets/images/logo.svg'"></div>
        	<img src="assets/images/logo.png" alt="." class="hide">
        	<span class="hidden-folded inline"><?php echo $nombre." ".$apellido; ?></span>
        </a>
        <!-- / brand -->
      </div>
      <div class="hide-scroll" data-flex>
          <nav class="scroll nav-light">

              <ul class="nav" ui-nav>
                <li class="nav-header hidden-folded">
                  <small class="text-muted">Main</small>
                </li>

                <li>
                  <a href="dashbord.php" >
                    <span class="nav-icon">
                      <i class="material-icons md-24">
                        <!--<span ui-include="'assets/images/i_1.svg'"></span>-->
                      </i>
                    </span>
                    <span class="nav-text">Principal</span>
                  </a>
                </li>
                <li>
                  <a href="devices.php" >
                    <span class="nav-icon">
                      <i class="material-icons md-24"></i>
                    </span>
                    <span class="nav-text">Dispositivos</span>
                  </a>
                </li>
                <li>
                  <a href="registroUsuario.php" >
                    <span class="nav-icon">
                    <i class="material-icons md-24"></i>
                    </span>
                    <span class="nav-text">Crear Usuario</span>
                  </a>
                </li>
          </nav>
      </div>
      <div class="b-t">
        <div class="nav-fold">
        	<a href="profile.html">
        	    <span class="pull-left">
        	      <img src="assets/images/a0.jpg" alt="..." class="w-40 img-circle">
        	    </span>
        	    <span class="clear hidden-folded p-x">
        	      <span class="block _500">Jean Reyes</span>
        	      <small class="block text-muted"><i class="fa fa-circle text-success m-r-sm"></i>online</small>
        	    </span>
        	</a>
        </div>
      </div>
    </div>
  </div>
  <!-- / -->

  <!-- content -->
  <div id="content" class="app-content box-shadow-z0" role="main">
    <div class="app-header white box-shadow">
        <div class="navbar navbar-toggleable-sm flex-row align-items-center">
            <!-- Open side - Naviation on mobile -->
            <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
              <i class="material-icons">&#xe5d2;</i>
            </a>
            <!-- / -->

            <!-- Page title - Bind to $state's title -->
            <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>

            <!-- navbar collapse -->
            <div class="collapse navbar-collapse" id="collapse">
              <!-- link and dropdown -->
              <ul class="nav navbar-nav mr-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link" href data-toggle="dropdown">
                    <i class="fa fa-fw fa-plus text-muted"></i>
                    <span>New</span>
                  </a>
                  <div ui-include="'views/blocks/dropdown.new.html'"></div>
                </li>
              </ul>

              <div ui-include="'views/blocks/navbar.form.html'"></div>
              <!-- / -->
            </div>
            <!-- / navbar collapse -->

            <!-- navbar right -->
            <ul class="nav navbar-nav ml-auto flex-row">
              <li class="nav-item dropdown pos-stc-xs">
                <a class="nav-link mr-2" href data-toggle="dropdown">
                  <i class="material-icons">&#xe7f5;</i>
                  <span class="label label-sm up warn">3</span>
                </a>
                <div ui-include="'views/blocks/dropdown.notification.html'"></div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link p-0 clear" href="#" data-toggle="dropdown">
                  <span class="avatar w-32">
                    <img src="assets/images/a0.jpg" alt="...">
                    <i class="on b-white bottom"></i>
                  </span>
                </a>
                <div ui-include="'views/blocks/dropdown.user.html'"></div>
              </li>
              <li class="nav-item hidden-md-up">
                <a class="nav-link pl-2" data-toggle="collapse" data-target="#collapse">
                  <i class="material-icons">&#xe5d4;</i>
                </a>
              </li>
            </ul>
            <!-- / navbar right -->
        </div>
    </div>
    <div class="app-footer">
      <div class="p-2 text-xs">
        <div class="pull-right text-muted py-1">
          &copy; Copyright <strong>JLCCUI</strong> <span class="hidden-xs-down"></span>
          <!--<a ui-scroll-to="content"><i class="fa fa-long-arrow-up p-x-sm"></i></a>-->
        </div>
        <div class="nav">
          <a class="nav-link" href="../">About</a>

        </div>
      </div>
    </div>
    <div ui-view class="app-body" id="view">

      <!-- Add los Datos de los dispositivos-->
      <div class="padding">
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="box p-a">
             <div class="pull-left m-r">
               <span class="w-48 rounded  accent">
                 <i class="material-icons md-24"></i>
               </span>
             </div>
             <div class="clear">
               <h4 class="m-0 text-lg _300"><a href>23 <span class="text-sm">°C</span></a></h4>
               <small class="text-muted">Promedio: 17°C</small>
             </div>
           </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="box p-a">
             <div class="pull-left m-r">
               <span class="w-48 rounded  primary">
                 <i class="material-icons md-24"></i>
               </span>
             </div>
             <div class="clear">
               <h4 class="m-0 text-lg _300"><a href>40 <span class="text-sm">°C</span></a></h4>
               <small class="text-muted">Temp Pico: 70°C</small>
             </div>
           </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="box p-a">
             <div class="pull-left m-r">
               <span class="w-48 rounded  warn">
                 <i class="material-icons md-24"></i>
               </span>
             </div>
             <div class="clear">
               <h4 class="m-0 text-lg _300"><a href>5.03 <span class="text-sm">V</span></a></h4>
               <small class="text-muted">Tensión Pico: 5.8v</small>
             </div>
           </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="box p-a">
                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">Led1</label>
                  <div class="col-sm-10">
                    <label class="ui-switch ui-switch-md info m-t-xs">
                      <input type="checkbox" checked="">
                      <i></i>
                    </label>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="box p-a">
                <div class="form-group row">
                  <label class="col-sm-2 form-control-label">Led2</label>
                  <div class="col-sm-10">
                    <label class="ui-switch ui-switch-md info m-t-xs">
                      <input type="checkbox" checked="">
                      <i></i>
                    </label>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>

<!-- ############ PAGE END-->

    </div>
  </div>
  <!-- / -->

  <!-- theme switcher -->
  <div id="switcher">
    <div class="switcher box-color dark-white text-color" id="sw-theme">
      <a href ui-toggle-class="active" target="#sw-theme" class="box-color dark-white text-color sw-btn">
        <i class="fa fa-gear"></i>
      </a>
      <div class="box-header">
        <h2>Temas</h2>
      </div>
      <div class="box-divider"></div>

      <div class="box-body">
        <div data-target="bg" class="row no-gutter text-u-c text-center _600 clearfix">
          <label class="p-a col-sm-6 light pointer m-0">
            <input type="radio" name="theme" value="" hidden>
            Light
          </label>
          <label class="p-a col-sm-6 grey pointer m-0">
            <input type="radio" name="theme" value="grey" hidden>
            Grey
          </label>
          <label class="p-a col-sm-6 dark pointer m-0">
            <input type="radio" name="theme" value="dark" hidden>
            Dark
          </label>
          <label class="p-a col-sm-6 black pointer m-0">
            <input type="radio" name="theme" value="black" hidden>
            Black
          </label>
        </div>
      </div>
    </div>

    <div class="switcher box-color black lt" id="sw-demo">
      <a href ui-toggle-class="active" target="#sw-demo" class="box-color black lt text-color sw-btn">
        <i class="fa fa-list text-white"></i>
      </a>
      <div class="box-header">
        <h2>Demos</h2>
      </div>
      <div class="box-divider"></div>
      <div class="box-body">
        <div class="row no-gutter text-u-c text-center _600 clearfix">
          <a href="html/dashboard.html"
            class="p-a col-sm-6 primary">
            <span class="text-white">Default</span>
          </a>
          <a href="html/dashboard.0.html"
            class="p-a col-sm-6 success">
            <span class="text-white">Zero</span>
          </a>
          <a href="html/dashboard.1.html"
            class="p-a col-sm-6 blue">
            <span class="text-white">One</span>
          </a>
          <a href="html/dashboard.2.html"
            class="p-a col-sm-6 warn">
            <span class="text-white">Two</span>
          </a>
          <a href="html/dashboard.3.html"
            class="p-a col-sm-6 danger">
            <span class="text-white">Three</span>
          </a>
          <a href="html/dashboard.4.html"
            class="p-a col-sm-6 green">
            <span class="text-white">Four</span>
          </a>
          <a href="html/dashboard.5.html"
            class="p-a col-sm-6 info">
            <span class="text-white">Five</span>
          </a>
          <div
            class="p-a col-sm-6 lter">
            <span class="text">...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / -->

<!-- ############ LAYOUT END-->

  </div>
<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
  <script src="libs/jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
  <script src="libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="libs/jquery/underscore/underscore-min.js"></script>
  <script src="libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="libs/jquery/PACE/pace.min.js"></script>

  <script src="html/scripts/config.lazyload.js"></script>

  <script src="html/scripts/palette.js"></script>
  <script src="html/scripts/ui-load.js"></script>
  <script src="html/scripts/ui-jp.js"></script>
  <script src="html/scripts/ui-include.js"></script>
  <script src="html/scripts/ui-device.js"></script>
  <script src="html/scripts/ui-form.js"></script>
  <script src="html/scripts/ui-nav.js"></script>
  <script src="html/scripts/ui-screenfull.js"></script>
  <script src="html/scripts/ui-scroll-to.js"></script>
  <script src="html/scripts/ui-toggle-class.js"></script>

  <script src="html/scripts/app.js"></script>

  <!-- ajax -->
  <script src="libs/jquery/jquery-pjax/jquery.pjax.js"></script>
  <script src="html/scripts/ajax.js"></script>
<!-- endbuild -->
<!-- Alertas -->
  <!--<script src="css/SpryAccordion.js" type="text/javascript"></script>-->
</body>
</html>
