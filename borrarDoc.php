<?php 
include "../Conexion.php";
 if (!empty($_POST))
  {
     $idDocente= $_POST['idusuario'];

     $Query_Borrar =mysqli_query($Conexion,"UPDATE usuario SET estatus=0 WHERE idusuario = $idDocente");

    if ( $Query_Borrar) 
    {
    	header("location: ListaDoc.php");
    }else{

    	echo "error al eliminar el usuario";
    }
 }



 if (empty($_REQUEST['id'])) 
 {
 	header("location: ListaDoc.php");
 }else{
     
      $idDocente= $_REQUEST['id'];

      $Query= mysqli_query($Conexion,"SELECT u.documento,u.nombre,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $idDocente");

      $result= mysqli_num_rows($Query);

      if ($result > 0)
       {
      	while ($Dato=mysqli_fetch_array($Query)) {
      		$Documento=$Dato['documento'];
      		$Nombre=$Dato['nombre'];
      		$Rol=$Dato['rol'];

      	}
      }else{
      	 	header("location: ListaDoc.php");

      }

 }

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Eliminar Docente</title>
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
		<h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>DOCENTES ELIMINAR</small></h1>
		 <center>
				<div class="btn btn-danger btn-raised btn-xs">
					 <h6>¿Estas seguro de eliminar este usuario? <br> <br>	
				</h6>
				
				<div class="btn btn-danger btn-raised btn-xs">
				<h3> Documento: <span><?php echo $Documento; ?></span></h3>	
					 <h3> Nombre: <span><?php echo $Nombre; ?></span></h3>	
					 <h3> Rol: <span><?php echo $Rol; ?></span></h3>	
                        </center>
				</div>
				<center> <form method="post" action="">
					<input type="hidden" name="idusuario" value="<?php echo $idDocente; ?>">
					<a href="ListaDoc.php" 	class="btn btn-danger btn-raised btn-xl">CANCELAR</a>
					<input type="submit" name="Aceptar :") value="CONFIRMAR" class="btn btn-success btn-raised btn-xl">
				</form>
				</center>
		</section>

	<?php include"modulos/script.php";  ?>
</body>
</html>