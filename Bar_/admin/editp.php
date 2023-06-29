
<?php
// permite modificar la informacion de los productos que posee el bar 
include("db.php");

if (isset($_GET['id'])) {
	$cedula = $_GET['id'];
	$query = "SELECT * FROM producto WHERE id = $id";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$nombre = $row['Nombre']; 
		$precio = $row['precio']; 
		$id_categoria = $row['id_categoria']; 
		$existencia = $row['existencia']; 
		
	}	
	
}

if (isset($_POST['update'])) {
	$cedula = $_GET['cedula'];
	$nombre = $_POST['nombre']; 
	$precio = $_POST['precio'];
	$id_categoria = $_POST['id_categoria'];
	$existencia = $_POST['existencia'];

	$query = "UPDATE producto set nombre ='$nombre', precio ='$precio', id_categoria = '$id_categoria', existencia = '$existencia'WHERE id = $id";

	mysqli_query($conn, $query);

	header("Location: indexp.php");

}

?>

<?php include("include/header.php") ?>

<center><br><h5>Actualizar datos de usuario</h5></center>
<div class="container p-4">
	<div class="row">
		<div class="col-md-4 mx-auto">
			<div class="card card-body">
				<form action="editp.php?id=<?php echo $_GET['id']; ?>" method = "POST">
					<div class="form-group">
						<input type="text" name="nombre" value="<?php echo $nombre; ?>">
					</div>
					<div class="form-group">
						<input type="number" name="precio" value="<?php echo $precio; ?>">
					</div>
					<div class="form-group">
						<input type="number" name="id_categoria" value="<?php echo $id_categoria; ?>">
					</div>
					<div class="form-group">
						<input type="number" name="existencia" value="<?php echo $existencia; ?>">
					</div>
					
					<button class="btn btn-success" name="update" >
						Actualizar
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>
