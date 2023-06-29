<?php include("db.php")
// en esta pagina se mostraran todos los productos que posee el bar en una tabla con su respectiva informacion
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
				<form action="save_taskp.php" method="POST">
				<h6>id</h6>
					<div class="form-group">
						<input type="number" name="id" class="form-control" placeholder="" required
						minlength="10" maxlength="10" autofocus>
					</div>
					<div class="form-group">
						<h6>Nombres</h6>
						<input type="text" name="nombre" class="form-control" placeholder="" required
						minlength="3" maxlength="30" autofocus>
					</div>
					<div class="form-group">
						<h6>Precio</h6>
						<input type="number" name="precio" class="form-control" placeholder="" required
						minlength="4" maxlength="10" autofocus>
					</div>
					<h6>Id Categoria</h6>
					<div class="form-group">
						<input type="number" name="id_categoria" class="form-control" placeholder="" required
						minlength="10" maxlength="10" autofocus>
					</div>

					<h6>Existencias</h6>
					<div class="form-group">
					<input type="number" name="existencia" class="form-control" placeholder="" required
						minlength="3" maxlength="15" autofocus>	
					</div>
					
					
					<input type="submit" class="btn btn-success btn-block" name="save_taskp" value="Enviar">
				</form>
			</div>
			
			<center><br><a class="btn btn-secondary" href="admin.php" role="button">Volver</a></center>
			
		</div>
		<div class="col-md-9">
			<table class="table table-bordered table-dark">
				<thead>
					<tr>
						<th>id</th>
						<th>nombre</th>
						<th>precio</th>
						<th>id_categoria</th>
						<th>existencia</th>
						<th>Acciones</th>
					</tr>
				</thead >
				<tbody>
					<?php
					$query = "SELECT * FROM producto";
					$result_tasks = mysqli_query($conn, $query);
					while ($row = mysqli_fetch_array($result_tasks)) { ?>
						<tr>
							<td><?php echo $row['id'] ?></td>
							<td><?php echo $row['nombre'] ?></td>
							<td><?php echo $row['precio'] ?></td>
							<td><?php echo $row['id_categoria'] ?></td>
							<td><?php echo $row['existencia'] ?></td>
							<td>
							
								<a href="editp.php?id=<?php echo $row['id']?>" class ="btn btn-primary">
									Edit
								</a>
								<a href="delete_taskp.php?id=<?php echo $row['id']?>" class ="btn btn-danger">
									Delete
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<center><br><a class="btn btn-secondary" href="buscarp.php" role="button">Consultar</a></center>
			
		</div>
	</div>
	
</div>

<?php include("include/footer.php") ?>



