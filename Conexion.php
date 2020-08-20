<?php
$Host= 'localhost';
$User= 'root';
$Password = '';
$Bd = 'vacct';

$Conexion= mysqli_connect($Host,$User,$Password,$Bd);

if (!$Conexion) {
	echo "Error de conexion en la base de  datos";
}


?>