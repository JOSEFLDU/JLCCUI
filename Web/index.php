<?php

//Conexión con la BDD
session_start();
require_once ('conexion/conexion.php');
$_SESSION['logged']=false;
if ($conn==false)
{
   echo "<script type=\"text/javascript\">alert(\"No se puedo conectar a la BDD\");</script>";
   die();
}
//Declaramos Variables
$email="";
$msg="";
//Se verifica si los campos están llenados
if(isset($_POST['email'])&& isset($_POST['password']))
   {
     if ($_POST['email']=="")
     {
       echo "<script type=\"text/javascript\">alert(\"Ingrese su Email\");</script>";
     }
     else if ($_POST['password']=="")
     {
       echo "<script type=\"text/javascript\">alert(\"Ingrese su Password\");</script>";
     }
     else
     {
       $email=strip_tags($_POST['email']);
       $password=sha1(strip_tags($_POST['password']));
       //validar si el usuario está registrado
       $result = $conn->query("SELECT * FROM `Usuario` WHERE `Usu_Email` = '".$email."'");
       //$users= $result->fetch_all(MYSQLI_ASSOC);
       $users = $result-> fetch_all(MYSQLI_ASSOC);
       //Contamos si la tabla tines los valores
       $count=count($users);
       if ($count==1)
       {
         $result2 = $conn->query("SELECT * FROM `Usuario` WHERE `Usu_Email` = '".$email."'  AND Usu_Password = '".$password."'");
         //$users= $result->fetch_all(MYSQLI_ASSOC);
         $users2 = $result2-> fetch_all(MYSQLI_ASSOC);
         //Contamos si la tabla tines los valores
         $count2=count($users2);
         if ($count2==1)
         {
           $_SESSION['Usu_Id']=$users[0]['Usu_Id'];
           $_SESSION['Tusu_Id']=$users[0]['Tusu_Id'];
           $_SESSION['Usu_Nombre']=$users[0]['Usu_Nombre'];
           $_SESSION['Usu_Apellido']=$users[0]['Usu_Apellido'];
           $_SESSION['Usu_Email']=$users[0]['Usu_Email'];
           $_SESSION['Usu_Tfno']=$users[0]['Usu_Tfno'];

           echo "<script type=\"text/javascript\">alert(\"Datos Ingresados Correctamente\");</script>";
           $_SESSION['logged']=true;
           echo "<meta http-equiv='refresh' content='0;url=dashbord.php?'>";
           $_SESSION['time'];
         }
         else
         {
           echo "<script type=\"text/javascript\">alert(\"Password Incorrecto\");</script>";
           $_SESSION['logged']=false;
         }

       }
       else
       {
         echo "<script type=\"text/javascript\">alert(\"Usuario no Registrado\");</script>";
         $_SESSION['logged']=false;
       }
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>JLCCUI</title>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
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
  <div class="center-block w-xxl w-auto-xs p-y-md" >
    <div class="navbar">
      <div class="pull-center">
        <div ui-include="'views/blocks/navbar.brand.html'"></div>
      </div>
    </div>
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm" style="text-align:center;">
        Ingrese su Email y Password
      </div>
      <form name="form" method="post">
        <div class="md-form-group float-label">
          <input type="email" class="md-input" value="<?php echo $email ?>" ng-model="user.email" name="email" required>
          <label>Email:</label>
        </div>
        <div class="md-form-group float-label">
          <input type="password" class="md-input" ng-model="user.password" name="password" required>
          <label>Password:</label>
        </div>
        <button type="submit" class="btn primary btn-block p-x-md">Iniciar Sesión</button>
      </form>
    </div>

    <div class="p-v-lg text-center">
      <div class="m-b"><a ui-sref="access.forgot-password" href="forgot-password.html" class="text-primary _600">Olvido su Password?</a></div>
      <div><a ui-sref="access.signup" href="registro.php" class="text-primary _600">Crear Usuario</a></div>
    </div>
  </div>

<!-- ############ LAYOUT END-->

  </div>
<!-- Alertas -->
  <script src="css/SpryAccordion.js" type="text/javascript"></script>
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
