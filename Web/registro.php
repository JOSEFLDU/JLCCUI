<?php

//Conexión con la BDD
//$conn= mysqli_connect("localhost","admin_JLCCTT","DesdemiInteriror","admin_JLCCTT");
//session_start();
require_once ('conexion/conexion.php');
//Declaramos Variables
$tusuario="";
$nombre="";
$apellido="";
$telefono="";
$email="";
$password="";
$password_r="";
$msg="";
$y=0;
$s=1;
$estado=0;

$result7 = $conn -> query("SELECT * FROM `Tipo_Usuario`");
$TipoUsuario7 = $result7-> fetch_all(MYSQLI_ASSOC);
//Se verifica si los campos están llenados
if(isset($_POST['tusuario'])&& isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['password'])
&& isset($_POST['password_r']) &&  isset($_POST['email']) && isset($_POST['telefono']))
   {
     $tusuario=$_POST['tusuario'];
     $nombre=$_POST['nombre'];
     $apellido=$_POST['apellido'];
     $telefono=$_POST['telefono'];
     $email=$_POST['email'];
     $password=$_POST['password'];
     $password_r=$_POST['password_r'];

     if($password==$password_r)
     {
       //Aquí si todo está bien, sigueinte verificamos previamnete que no exista un email repetido
       $result = $conn -> query("SELECT * FROM `Usuario` WHERE `Usu_Email` = '".$email."'");
       $Usuario = $result-> fetch_all(MYSQLI_ASSOC);
       //Contamos si hay el eusuario en la tabla
       $count = count($Usuario);
       // si no hay el usuario registrado con le mismpo email, procedemos a ingresar los datos en la bdd
       if($count == 0)
       {
        $password = sha1($password); // encriptamos el password
        /*$query_insert = mysqli_query($conn, "INSERT INTO Usuario(Tusu_Id, Usu_Nombre, Usu_Apellido,Usu_Password,Usu_Email,
                        Usu_Tfno) VALUES ('$tusuario','$nombre','$apellido','$password','$email','$telefono')");*/
        $conn -> query("INSERT INTO `Usuario` (`Tusu_Id`, `Usu_Nombre`, `Usu_Apellido`,`Usu_Password`,`Usu_Email`,
                        `Usu_Tfno`,`Usu_Estado`) values ('".$tusuario."','".$nombre."','".$apellido."','".$password."','".$email."'
                          ,'".$telefono."','".$estado."');");
         //$msg.="Ususario creado correctamente, ingrese haciendo  <a href='Login.php> clic aquí</a></br>'";
         echo "<script type=\"text/javascript\">alert(\"Usuario Creado Correctamente\");</script>";
         echo "<meta http-equiv='refresh' content='0;url=index.php?'>";
       }
       else
       {
         //$msg="El mail ingresado ya existe </br>";
         //echo "El usuario ya existe";
         //echo "<script type=\"text/javascript\">alert(\"Bienvenido:");</script>";
         echo "<script type=\"text/javascript\">alert(\"El mail ingresado ya existe\");</script>";
         //echo "<meta http-equiv='refresh' content='0;url=registro.php?'>";
       }
     }
     else
     {
      echo "<script type=\"text/javascript\">alert(\"Los Password no Coinciden\");</script>";
     }
   }
   else
   {
      $msg="Complete el Formolario";
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Registro</title>
  <script src="css/SpryAccordion.js" type="text/javascript"></script>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="assets/images/domotica-png-2.png">
  <meta name="apple-mobile-web-app-title" content="mmmmmmmmmmm">
  <!-- Icono de la Pestaña -->
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
  <style>
      body {
        background: url(assets/images/fondo2_index.webp)  ;
        background-size: cover;
        background-repeat: no-repeat;
        margin: 0;
        max-width: 100%;
        height: auto;
      }
  </style>
</head>
<body background="assets/images/fondo2_index.webp">
  <div class="app" id="app">

<!-- ############ LAYOUT START-->
  <div class="center-block w-xxl w-auto-xs p-y-md">
    <div class="navbar">
      <div class="pull-center">
        <div ui-include="'views/blocks/navbar.brand.html'"></div>
      </div>
    </div>

    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm" style="text-align: center;">
          <H5>Registro Usuario</H5>
      </div>
      <form name="form" method="post" >
          <label>Tipo Usuario</label>
          <div class="md-form-group">
            <select name="tusuario" class="md-input" ui-jp="select2" ui-options="{theme: 'bootstrap'}">
              <?php foreach ($TipoUsuario7 as $TipoUsuario) {?>
                <option value="<?php echo $TipoUsuario['Tusu_Id']; ?>"><?php echo $TipoUsuario['Tusu_Tipo']; ?></option>
              <?php } ?>
            </select>
          </div>
        <div class="md-form-group">
          <input type="nombre" name="nombre" class="md-input" required>
          <label>Nombre</label>
        </div>
        <div class="md-form-group">
          <input type="apellido" name="apellido" class="md-input" required>
          <label>Apellido</label>
        </div>
        <div class="md-form-group">
          <input type="email" name="email" class="md-input" value="<?php echo $email;?>" required>
          <label>Email</label>
        </div>
        <div class="md-form-group">
          <input type="telefono" name="telefono" class="md-input" required>
          <label>Teléfono</label>
        </div>
        <div class="md-form-group">
          <input type="password" name="password" class="md-input" required>
          <label>Password</label>
        </div>
        <div class="md-form-group">
          <input type="password" name="password_r" class="md-input" required>
          <label>Repetir Password</label>
        </div>
        <!--<div class="m-b-md">
          <label class="md-check">
            <input type="checkbox" required><i class="primary"></i> Agree the <a href>terms and policy</a>
          </label>
        </div>----->
        <button type="submit" class="btn primary btn-block p-x-md">Registro</button>
      </form>
    </div>

    <div class="p-v-lg text-center">
      <div> <a ui-sref="access.signin" href="index.php" class="text-primary _600">Login</a></div>
    </div>
  </div>

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
</body>
</html>
