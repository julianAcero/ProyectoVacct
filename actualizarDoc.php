<?php
include "../Conexion.php";

if (!empty($_POST))
 {
	$alert = '';
	if (empty($_POST['documento']) || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['rol']))
	 {
		$alert = "Ingrese todos los campos";
	}else{
		
        $idUsuario = $_POST['idUsuario'];
		$documento = $_POST['documento'];
		$nombre = $_POST['nombre'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];
		$clave = md5($_POST['clave']);
		$rol = $_POST['rol'];

		
		$query = mysqli_query($Conexion, "SELECT * FROM usuario 
													WHERE (documento = '$documento' AND idusuario != $idUsuario)
													OR (nombre = '$nombre' AND idusuario != $idUsuario) ");
		$result = mysqli_fetch_array($query);



		if ($result > 0 ) {
			$alert = "El usuario ya existe";
		}else{
			if (empty($_POST['clave'])) {

				$sql_update = mysqli_query($Conexion, "UPDATE usuario 
													   SET documento = '$documento', nombre ='$nombre' , telefono = '$telefono' , direccion = '$direccion' , rol='$rol'
													   WHERE idusuario= $idUsuario");
				
			}else{
             $sql_update = mysqli_query($Conexion, "UPDATE usuario 
									             	SET documento ='$documento',nombre='$nombre' , telefono = '$telefono', direccion = '$direccion', clave = '$clave', rol='$rol' 
									             	WHERE idusuario= $idUsuario");
			}

			if($sql_update){
				$alert = "Usuario actualizado correctamente";
			}else{
				$alert = "Error al actualizar el usuario";
			}
		}
	}
	mysqli_close($Conexion);
}


///Mostrar datos 
if (empty($_GET['id'])) { 
	header('location: ListaDoc.php');
	mysqli_close($Conexion);
}

$iduser = $_GET['id'];
 
 $sql= mysqli_query($Conexion,"SELECT  u.idusuario,u.documento,u.nombre, u.telefono, u.direccion, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN  rol r ON u.rol = r.idrol WHERE idusuario= $iduser AND estatus = 1");
mysqli_close($Conexion);
$result_sql= mysqli_num_rows($sql);

if($result_sql==0) {
header('Location: ListaDoc.php');

}else{
 while ($Data = mysqli_fetch_array($sql)) {
 	$iduser= $Data['idusuario'];
 	$Documento= $Data['documento'];
 	$Nombre= $Data['nombre'];
 	$Telefono= $Data['telefono'];
 	$Direccion= $Data['direccion'];
 	$idrol= $Data['idrol'];
 	$Rol= $Data['rol'];


 	if ($idrol == 1) {
 		$option = ' <label><input type="radio" value="'.$idrol.'"><i class="zmdi zmdi-star"></i> &nbsp;'.$Rol.'</label>';
 	}else if($idrol == 2){
 		$option = ' <label><input type="radio" value="'.$idrol.'"><i class="zmdi zmdi-star"></i> &nbsp;'.$Rol.'</label>';
 	}else if($idrol == 3){
 		$option = ' <label><input type="radio" value="'.$idrol.'"><i class="zmdi zmdi-star"></i> &nbsp;'.$Rol.'</label>';
 	}
 }

}


?>




<!DOCTYPE html>
<html lang="es">
<head>
	<title>Actualizar Docentes</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>


	<?php include"modulos/Navlateral.php";  ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php include "modulos/navbar.php"; ?>
		<h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>DOCENTES ACTUALIZAR</small></h1>
	
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="NuevoDoc.php" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO DOCENTES
	  		</a>
	  	</li>
	  	<li>
	  		<a href="ListaDoc.php" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE DOCENTES
	  		</a>
	  	</li>
	  	<li>
	  		<a href="BuscDoc.php" class="btn btn-primary">
	  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR DOCENTES
	  		</a>
	  	</li>
	</ul>
</div>

<center><label class="text-center text-muted text-uppercase" style="color: #FF3212;"> <?php  echo "<br>"; echo isset ($alert)? $alert : '';?></label></center>
<!-- Panel nuevo DOCENTE -->
<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; ACTUALIZAR DOCENTE</h3>
		</div>
		<div class="panel-body">
			<form action="actualizarDoc.php" method="post">

		    	<fieldset>
		    		<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12">
						    	<div class="form-group label-floating">

                                    <input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
								  	<label class="control-label">Documento de Identidad * </label>
								  	<input pattern="[0-9-]{1,30}" class="form-control" type="text" name="documento" value="<?php echo $Documento; ?>" maxlength="30">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Nombres Completos*</label>
								  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,}" class="form-control" type="text" name="nombre"  value="<?php echo $Nombre; ?>" maxlength="100">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Teléfono</label>
								  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono"   value="<?php echo $Telefono; ?>"maxlength="15">
								</div>
		    				</div>
		    				<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Dirección</label>
								  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="" name="direccion"   value="<?php echo $Direccion; ?>"maxlength="28">

								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-key"></i> &nbsp; Datos de la cuenta</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Contraseña *</label>
								  	<input class="form-control" type="password" name="clave" maxlength="70">
								</div>
		    				</div>
		    				
		    				
		    		
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-star"></i> &nbsp; Rol </legend>

		    		<?php include"../Conexion.php" ?>

		    		<?php 
		    			$query_rol = mysqli_query($Conexion, "SELECT * FROM rol");
		    			mysqli_close($Conexion);
		    			$result_rol = mysqli_num_rows($query_rol);
                     ?>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
								<div class="radio radio-primary">
				<?php
				echo $option;
				if ($result_rol > 0) {
					while ($rol = mysqli_fetch_array($query_rol)) {  
						if ($rol['idrol'] == 2) {
							# code...
												?>

						            <label>
										<input type="radio" name="rol" id="rol" value="<?php echo $rol["idrol"];?>">
										<i class="zmdi zmdi-star"></i> &nbsp;<?php echo $rol["rol"]; ?> 
									</label>
						<?php	
						}		
					}
				}
				?>		
								</div>

		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
			    <p class="text-center" style="margin-top: 20px;">
			    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Actualizar</button>
			    </p>
		    </form>
		</div>
	</div>
		</section>
		</section>

	<?php include"modulos/script.php";  ?>
</body>
</html>