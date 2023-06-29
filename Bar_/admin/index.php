<?php include("db.php")
// en esta pagina se mostraran todo el personal que posee el bar en una tabla con su respectiva informacion
 ?>
<?php include("include/header.php") ?>
<div class="container p-4">
	<h5>Datos de usuario</h5>
	<div class="row">
		<div class="col-md-3" style="background-color:#D1F2EB">
			<?php if (isset($_SESSION['message'])) { ?>
				<div class="alert alert-<?=$_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
					<? $_SESSION['message']?>
					 <strong>Solicitud ejecutada correctamente</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php session_unset(); } ?>

			<div class="card card-body" style="background-color:#A3E4D7">
				<form action="save_task.php" method="POST">
				<h6>Cedula</h6>
					<div class="form-group">
						<input type="number" name="cedula" class="form-control" placeholder="" required
						minlength="10" maxlength="10" autofocus>
					</div>
					<div class="form-group">
						<h6>Nombres</h6>
						<input type="text" name="nombre" class="form-control" placeholder="" required
						minlength="4" autofocus>
					</div>
					<div class="form-group">
						<h6>Apellidos</h6>
						<input type="text" name="apellido" class="form-control" placeholder="" required
						minlength="4" maxlength="10" autofocus>
					</div>
					<h6>Edad</h6>
					<div class="form-group">
						<input type="number" name="edad" class="form-control" placeholder="" required
						minlength="3" maxlength="3" autofocus>
					</div>

					<h6>Usuario</h6>
					<div class="form-group">
					<input type="text" name="usuario" class="form-control" placeholder="" required
						minlength="3" maxlength="15" autofocus>	
					</div>
					
					<h6>Contraseña</h6>
					<div class="form-group">
					<input type="text" name="contraseña" class="form-control" placeholder="" required
						minlength="5" maxlength="20" autofocus>	
					</div>

					<h6>Turno</h6>
					<select name="id_cargo" class="id_cargo">
            		<option value="1">Dia</option>
            		<option value="2">Tarde</option>
            		<option value="3">Noche</option>
					<tr>
					</select><br>
					
					<label> <h6>Id Cargo</h6></label><br>
        			<select name="id_cargo" class="id_cargo">
            		<option value="1">Administrador</option>
            		<option value="2">Cajero</option>
            		<option value="3">Mesero</option>
					<tr>
					</select><br>
					
					<input type="submit" class="btn btn-success btn-block" name="save_task" value="Enviar">
				</form>
			</div>
			
			<center><br><a class="btn btn-secondary" href="admin.php" role="button">Volver</a></center>
			
		</div>
		<div class="col-md-9">
			<table class="table table-bordered table-dark">
				<thead>
					<tr>
						<th>cedula</th>
						<th>nombre</th>
						<th>apellido</th>
						<th>edad</th>
						<th>usuario</th>
						<th>contraseña</th>
						<th>turno</th>
						<th>id_cargo</th>
						<th>Acciones</th>
					</tr>
				</thead >
				<tbody>
					<?php
					$query = "SELECT * FROM personal";
					$result_tasks = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_array($result_tasks)) { ?>
						<tr>
							<td><?php echo $row['cedula'] ?></td>
							<td><?php echo $row['nombre'] ?></td>
							<td><?php echo $row['apellido'] ?></td>
							<td><?php echo $row['edad'] ?></td>
							<td><?php echo $row['usuario'] ?></td>
							<td><?php echo $row['contraseña'] ?></td>
							<td><?php echo $row['turno'] ?></td>
							<td><?php echo $row['id_cargo'] ?></td>
							<td>
							
								<a href="edit.php?cedula=<?php echo $row['cedula']?>" class ="btn btn-primary">
									Edit
								</a>
								<a href="delete_task.php?cedula=<?php echo $row['cedula']?>" class ="btn btn-danger">
									Delete
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<center><br><a class="btn btn-secondary" href="buscar.php" role="button">Consultar</a></center>
			
		</div>
	</div>
	
</div>

<?php include("include/footer.php") ?>



