<?php
// este permite al mesero observar la cantidad que posee el establecimiento del producto como informacion pertinente de este
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(id) FROM producto WHERE id=? and existencia >= 1");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT nombre, existencia, precio  FROM producto WHERE id=? AND existencia >= 1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $existencia = $row['existencia'];
            $precio = $row['precio'];
            $dir_images = 'images/productos/' . $id . '/';
            $rutaImg = $dir_images . 'articulo.jpg';

            if (!file_exists($rutaImg)) {
                $rutaImg = 'images/no-photo.jpg';
            }
            $images = array();
            if (file_exists($dir_images)) {
                $dir = dir($dir_images);
                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'articulo.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }
        } else {

            echo 'Error al procesar la petición';
            exit;
        }
    }
}

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
                <a href="#" class="navbar-brand ">
                    <strong>Mesero</strong>
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
                    <a href="pedido.php" class="btn btn-primary">
                        Pedidos <span id="num_pedi" class="badge bg_secondary" <?php echo $num_pedi?>></span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <img src="<?php echo $rutaImg ?>" width="500" height="500">
                </div>
                <div class="col-md-6 order-md-2">
                    <h1><?php echo $nombre; ?></h1>
                    <h1><?php echo 'cantidad en existencia:' ?></h1>
                    <h1><?php echo $existencia; ?></h1>
                    <h1><?php echo MONEDA . number_format($precio); ?></h1>

                    <p class="lead">
                    </p>
                    <div class="d-grid gap-3col-10 mx-auto">
                    <a href="inicio.php"class="btn btn-primary">Volver </a>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
            crossorigin="anonymous">
    </script>
    <script>
        function addProducto(id,token){
            let url = 'clases/pedidos'
            let formData=new FormData()
            formData.append('id',id)
            formData.append(' ',token)

            fetch(url,{
                method:'POST',
                body: formData,
                mode: 'cors',
            }).then(response=>response.json())
            .then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_pedi")
                    elemento.innerHTML = data.numero
                }
            })


        }

    </script>
</body>
</html>