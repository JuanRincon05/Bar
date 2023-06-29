<?php
// en este se puede ver los productos seleccionados por las personas la cantidad y el valor total a pagar
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();
$productos = isset($_SESSION['pedido']['producto']) ? $_SESSION['pedido']['producto'] : null;
$lista_pedido = array();
if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, nombre, precio, $cantidad AS cantidad FROM producto WHERE id=? AND existencia >= 1");
        $sql->execute([$clave]);
        $lista_pedido[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

//session_destroy();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark ">
            <div class="container">
                <a href="inicio.php" class="navbar-brand ">
                    <strong>Mesero </strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Cerveza</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Aguardiente</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Ron</a>
                        </li>
                    </ul>
                    <a href="pedido.php" class="btn btn-primary">Pedidos <span id="num_pedi" class="badge bg-secondary"><?php echo $num_pedi ?></span></a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="table-response">
                <table class="table">
                    <thead>
                        <tr>
                            <th>producto</th>
                            <th>precio</th>
                            <th>cantidad </th>
                            <th>subtotal </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_pedido == null) {
                            echo '<tr><td colspan = "5" class="text-center"><b>no hay productos </b></td></tr>';
                        } else {
                            $total = 0;
                            foreach ($lista_pedido as $producto) {
                                $id = $producto['id'];
                                $nombre = $producto['nombre'];
                                $precio = $producto['precio'];
                                $cantidad = $producto['cantidad'];
                                $subtotal = $cantidad * $precio;
                                $total += $subtotal;
                        ?>
                                <tr>
                                    <td><?php echo $nombre ?></td>
                                    <td><?php echo MONEDA . number_format($precio) ?></td>
                                    <td>
                                        <input type="number" min="1" max="30" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $id; ?>" onchange="actualizaCantidad(this.value,<?php echo $id; ?> )">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $id ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal) ?>
                                        </div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $id ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo MONEDA . number_format($total) ?></p>
                                </td>
                            </tr>
                    </tbody>
                <?php } ?>
                </table>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <button class="btn btn-primary btn-lg">enviar pedido</button>
                </div>

            </div>

        </div>
    </main>
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar este producto del pedido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })

        function actualizaCantidad(cantidad, id) {
            let url = 'clases/actualizar_pedidos.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('action', 'agregar')
            formData.append('cantidad', cantidad)
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')

                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }
                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 0
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA ?>' + total
                    }

                })

        }
               function eliminar() {
            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = 'clases/actualizar_pedidos.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('id', id)
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload()
                    }

                })

        }


    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>