<!--en esta parte el administrador podra buscar por medio del codigo de producto mostrando todos los datos-->
<?php include("include/header.php") ?>
<?php include ("db.php")?>
<html lang="es">
<body>

    <div class="col-md-4">
        <br><h5>Buscar registro</h5>
        <div class="form-group mb-2">
        <form action="buscarp.php" method="POST">
            <input class="form" type="text" name="buscar" id="" placeholder="Codigo de Producto">
            <input class="btn btn-primary" type="submit" value="Buscar">
        </form>
        </div>
    </div><br>

    <center>
        <div class="col-md-9">
            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <h5>REGITROS DE USUARIO</h5><br>
                        <td>id</td> 
                        <td>nombre</td>
                        <td>precio</td>
                        <td>id_categoria</td>
                        <td>existencia</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buscar = $_POST['buscar'];
                    $cnx = mysqli_connect("localhost", "root", "", "bar");
                    $sql = "SELECT *  FROM producto WHERE id like '$buscar' '%' order by id asc";
                    $rta = mysqli_query($cnx, $sql);
                    while ($mostrar = mysqli_fetch_row($rta)) {
                        ?>
                        <tr>
                            <td><?php echo $mostrar[0] ?></td>
                            <td><?php echo $mostrar[1] ?></td>
                            <td><?php echo $mostrar[2] ?></td>
                            <td><?php echo $mostrar[3] ?></td>
                            <td><?php echo $mostrar[4] ?></td>
                            

                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </center>
    <center><br><a class="btn btn-secondary" href="indexp.php" role="button">Volver</a></center>
</body>
</html>
<?php include("include/footer.php") ?>