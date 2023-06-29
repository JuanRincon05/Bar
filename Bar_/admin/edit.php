
<?php
// permite modificar la informacion del personal del bar
include("db.php");

if (isset($_GET['cedula'])) {
	$cedula = $_GET['cedula'];
	$query = "SELECT * FROM personal WHERE cedula = $cedula";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_array($result);
		$nombre = $row['nombre']; 
		$apellido = $row['apellido']; 
		$edad = $row['edad']; 
		$usuario = $row['usuario']; 
		$contraseña = $row['contraseña']; 
		$turno = $row['turno']; 
		$id_cargo = $row['id_cargo']; 
		
	}	
	
}

if (isset($_POST['update'])) {
	$cedula = $_GET['cedula'];
	$nombre = $_POST['nombre']; 
	$apellido = $_POST['apellido']; 
	$edad = $_POST['edad'];
	$usuario = $_POST['usuario'];
	$contraseña = $_POST['contraseña'];
	$turno = $_POST['turno'];
	$id_cargo = $_POST['id_cargo'];

	$query = "UPDATE personal set nombre ='$nombre', apellido ='$apellido', edad = '$edad', usuario = '$usuario', contraseña = '$contraseña' , turno = '$turno', id_cargo = '$id_cargo'WHERE cedula = $cedula";

	mysqli_query($conn, $query);

	header("Location: index.php");

}

?>

<?php include("include/header.php") ?>

<center><br><h5>Actualizar datos de usuario</h5></center>
<div class="container p-4">
	<div class="row">
		<div class="col-md-4 mx-auto">
			<div class="card card-body">
				<form action="edit.php?cedula=<?php echo $_GET['cedula']; ?>" method = "POST">
					<div class="form-group">
						<input type="text" name="nombre" value="<?php echo $nombre; ?>">
					</div>
					<div class="form-group">
						<input type="text" name="apellido" value="<?php echo $apellido; ?>">
					</div>
					<div class="form-group">
						<input type="number" name="edad" value="<?php echo $edad; ?>">
					</div>
					<div class="form-group">
						<input type="text" name="usuario" value="<?php echo $usuario; ?>">
					</div>
					<div class="form-group">
						<input type="number" name="contraseña" value="<?php echo $contraseña; ?>">
					</div>
					<div class="form-group">
						<input type="text" name="turno" value="<?php echo $turno; ?>">
					</div>
					<div class="form-group">
						<input type="number" name="id_cargo" value="<?php echo $id_cargo; ?>">
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
