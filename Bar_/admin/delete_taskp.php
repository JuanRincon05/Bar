<?php
// permite eliminar los productos ubicandolos por medio del id del producto
include("db.php");

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "DELETE  FROM producto WHERE id = $id";
	$result = mysqli_query($conn, $query);

	if (!$result) {
		die("Query failed");
	}

	$_SESSION['message'] = "Datos guardados correctamente";
	$_SESSION['message_type'] = 'danger';


	header("Location: indexp.php");
}

?>