<?php
// este permite agregar a la base de datos de la empresa al personal nuevo 
include("db.php");

if (isset($_POST['save_task'])) {
	$cedula= $_POST['cedula']; 
	$nombre = $_POST['nombre']; 
	$apellido = $_POST['apellido']; 
	$edad = $_POST['edad'];
	$usuario = $_POST['usuario'];
	$contraseña = $_POST['contraseña'];
	$turno = $_POST['turno'];
	$id_cargo = $_POST['id_cargo'];

	$query = "INSERT INTO personal(cedula,nombre,apellido,edad,usuario,contraseña,turno,id_cargo) VALUES ('$cedula','$nombre','$apellido','$edad','$usuario','$contraseña', '$turno','$id_cargo')";
	$result = mysqli_query($conn, $query);

	if (!$result) {
		die("Query failed");
	}

	$_SESSION['message'] = "Datos guardados correctamente";
	$_SESSION['message_type'] = 'success';

	header("Location: index.php");
}

?>