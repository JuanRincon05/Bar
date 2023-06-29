<?php
// esta permite eliminar al personal que sea necesario ubicandolo por medio de la cedula 
include("db.php");

if (isset($_GET['cedula'])) {
	$cedula = $_GET['cedula'];
	$query = "DELETE  FROM personal WHERE cedula = $cedula";
	$result = mysqli_query($conn, $query);

	if (!$result) {
		die("Query failed");
	}

	$_SESSION['message'] = "Datos guardados correctamente";
	$_SESSION['message_type'] = 'danger';


	header("Location: index.php");
}

?>