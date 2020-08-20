<?php

			$Alert = "";
    session_start();
			if (!empty($_SESSION['Active'])) {
				header('location:Vistas/index.php'); 
			}else{


if (!empty($_POST))
					{

 if (empty($_POST['documento']) || empty($_POST['clave'])) 
					 {

$Alert = "INGRESE SU CLAVE Y CONTRASEÑA";

}else{

require_once 'Conexion.php';

$Doc =  mysqli_real_escape_string ($Conexion,$_POST['documento']);
$Pass = md5(mysqli_real_escape_string($Conexion,$_POST['clave']));


 $query = mysqli_query($Conexion,"SELECT * FROM  usuario WHERE documento='$Doc' AND  clave = '$Pass'");

$Resultado = mysqli_num_rows($query);

 if ($Resultado > 0) 
{
 $Dato= mysqli_fetch_array ($query);
			   
 $_SESSION['Active'] = true;
$_SESSION['idusuario'] = $Dato['idusuario']; 
 $_SESSION['nombre'] = $Dato ['nombre'];
 $_SESSION['documento'] = $Dato ['documento'];
$_SESSION['rol'] = $Dato ['rol'];

header('location:Vistas/index.php'); 
 }else{
$Alert = "Usuario o contraseña incorrectos intente de nuevo";
	session_destroy();
     }
	 }

	 }
	 }
       

 ?> 
 <title> Login | VACCT</title>
 <link rel="stylesheet" href="Vistas/css/main.css">
<div class="full-box login-container cover">
	<form action="" method="POST" autocomplete="off" class="logInForm">
		<p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
		<p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserName">Documento</label>
		  <input  class="form-control" id="UserName"  name="documento" type="text" style="color: #FFF;">
		  <p class="help-block">Escribe tú Numero De Documento</p>
		</div>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserPass">Contraseña</label>
		  <input  class="form-control" id="UserPass" name="clave"  type="password" style="color: #FFF;">
		  <p class="help-block">Escribe tú contraseña</p>
		</div>
		<div class="form-group text-center">
			  <label class="text-center text-muted text-uppercase" style="color: #FF3212;"> <?php  echo isset($Alert)? $Alert : '';?>
			<input type="submit" value="Iniciar sesión" class="btn btn-info" style="color: #FFF;">
		</div>
	</form>
	
</div>