<?php
// este permite adicionar los productos que sean necesarios.
include("db.php");

if (isset($_POST['save_taskp'])) {
	$id= $_POST['id']; 
	$nombre = $_POST['nombre']; 
	$precio = $_POST['precio']; 
	$id_categoria = $_POST['id_categoria'];
	$existencia = $_POST['existencia'];


	$query = "INSERT INTO producto(id,nombre,precio,id_categoria,existencia) VALUES ('$id','$nombre','$precio','$id_categoria','$existencia')";
	$result = mysqli_query($conn, $query);

	if (!$result) {
		die("Query failed");
	}

	$_SESSION['message'] = "Datos guardados correctamente";
	$_SESSION['message_type'] = 'success';

	header("Location: indexp.php");
}

?>