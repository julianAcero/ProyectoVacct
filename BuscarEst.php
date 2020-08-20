



<!DOCTYPE html>
<html lang="es">
<head>
	<title>Buscar Estudiantes </title>
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

		 <link rel="stylesheet" href="/css/main.css">

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>Estudiantes</small></h1>
	</div>
	<p class="lead"></p>
</div>
<?php
include "../Conexion.php";
$Busqueda=$_REQUEST['busqueda'];

if (empty($Busqueda)) {
	header("Location: ListaEst.php");
}


 ?>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="NuevoDoc.php" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ESTUDIANTE
	  		</a>
	  	</li>
	  	<li>
	  		<a href="ListaDoc.php" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ESTUDIANTES
	  		</a>
	  	</li>
	  	<li>
	  		<a href="BuscDoc.php" class="btn btn-primary">
	  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ESTUDIANTES
	  		</a>
	  	</li>
	</ul>
</div>
<div class="container-fluid">
	<form class="well">
		<p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo "$Busqueda"?>”</strong></p>
		<div class="row">
			<input class="form-control" type="hidden" name="search_admin_destroy">
			<div class="col-xs-12">
				<p class="text-center">
					<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
				</p>
			</div>
		</div>
	</form>
</div>

<!-- Panel listado de busqueda de ESTUDIANTES -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; RESULTADOS DE LA BUSQUEDA   <font  size ="5"color="FFF">  "<?php  echo "$Busqueda" ?>"</font></h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Documento</th>
							<th class="text-center">NOMBRE</th>
							<th class="text-center">Telefono Acudiente</th>
							<th class="text-center">Direccion</th>
							<th class="text-center">Rol</th>
							<th class="text-center">A. CUENTA</th>
							<th class="text-center">ELIMINAR</th>
						</tr>
					</thead>
					<?php 
                     //Paginador 
					$rol='';
					if ($Busqueda=='Estudiantes') {
						$rol="OR rol LIKE '%1%'";
					}
					$sql_registro=mysqli_query($Conexion," SELECT COUNT(*)as total_registro FROM usuario
WHERE(
idusuario LIKE '%$Busqueda%' OR
documento LIKE '%$Busqueda%' OR
nombre LIKE '%$Busqueda%' OR
telefono LIKE '%$Busqueda%' OR
direccion LIKE '%$Busqueda%' 
$rol
)
AND 
estatus=1");
					$sql_Resultado=mysqli_fetch_array($sql_registro);
					$total_registro= $sql_Resultado['total_registro'];		

					$por_pagina=5;

					if (empty($_GET['pagina'])) {

						$pagina=1;
						
					}else {
						$pagina=$_GET['pagina'];
					}

                     $desde=($pagina-1) * $por_pagina;

                     $total_paginas= ceil($total_registro/$por_pagina);	

                      $Query= mysqli_query($Conexion,"SELECT  u.idusuario,u.documento,u.nombre, u.telefono, u.direccion, r.rol FROM usuario u INNER JOIN  rol r ON u.rol = r.idrol WHERE
                      	(
			         u.idusuario LIKE '%$Busqueda%' OR
		        	u.documento LIKE '%$Busqueda%' OR
			         u.nombre LIKE '%$Busqueda%' OR
			        u.telefono LIKE '%$Busqueda%' OR
			       u.direccion LIKE '%$Busqueda%' OR
                      r.rol LIKE '%$Busqueda%'
			            )
			            AND
			            estatus = 1 ORDER BY U.idusuario ASC LIMIT $desde,$por_pagina");

              $Resultado=mysqli_num_rows($Query);

              if ($Resultado > 0) {

              
              while ($Data= mysqli_fetch_array($Query)) {
     
                  
                 if ($Data['rol']=='Docente') {
              		# code...
                            	
              	?>
             
					<tbody>
						<tr>
							<td><?php echo $Data["idusuario"]; ?></td>
							<td><?php echo $Data["documento"]; ?></td>
							<td><?php echo $Data["nombre"]; ?></td>
							<td><?php echo $Data["telefono"]; ?></td>
							<td><?php echo $Data["direccion"]; ?></td>
							<td><?php echo $Data["rol"]; ?></td>
							<td>
								<a href="actualizarDoc.php?id=<?php echo $Data["idusuario"]; ?>" class="btn btn-success btn-raised btn-xs">
									<i class="zmdi zmdi-refresh"></i>
								</a>
							</td>
                             
							<td>
								
									<a href="borrarDoc.php?id=<?php echo $Data["idusuario"]; ?>" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
									</a>
							</td>
							</tr>
		<?php
              }
			  }
              }
              ?>
					</tbody>
				</table>
			</div>
			<nav class="text-center">
				<ul class="pagination pagination-sm">
					<li class=""><a href="">«</a></li>
					<?php 
                     for ($i=1; $i < $total_paginas; $i++) { 
                     	echo '<li class="active"><a href="?pagina'.$i.'">'.$i.'</a></li>';
                     }

					?>
				
					<li><a href="">»</a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>
		</section>

	<?php include"modulos/script.php";  ?>
</body>
</html>