<?php
// en esta el mesero tendra una interfaz de tienda en linea donde se podran observar todos los productos y agregarlos al carro para hacer el pedido
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();


$id = isset($_GET['$id']) ? $_GET['id']:'';
$token = isset($_GET['token']) ? $_GET['token']:'';
$token_tmp = hash_hmac('sha1',$id,KEY_TOKEN);

$sql = $con->prepare("SELECT id,nombre,precio FROM producto WHERE existencia >= 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
session_destroy();
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
          <a href="pedido.php" class="btn btn-primary">Pedidos <span id="num_pedi" class="badge bg-secondary"><?php echo $num_pedi ?></span></a>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 ">
        <?php foreach ($resultado as $row) { ?>
          <div class="col">
            <div class="card shadow-sm">
              <?php
              $id = $row['id'];
              $images = "images/productos/" . $id . "/articulo.jpg";
              if (!file_exists($images)) {
                $images = "images/no-photo.jpg";
              }
              ?>
              <img src="<?php echo $images ?>" width="350" height="350"">
              <div class=" card-body">
              <h5 class="card-title"><?php echo $row['nombre'] ?></h5>
              <p class="card-text"><?php echo number_format($row['precio']) ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo
                    hash_hmac('sha1',$row['id'],KEY_TOKEN);?>"class="btn
                    btn-primary">Detalles </a>
                </div>
                  <button class="btn btn-outline-success" type="button" 
                  onclick="addProducto(<?php echo $row['id']; ?>,
                  '<?php echo hash_hmac('sha1',$row['id'],KEY_TOKEN); ?>')"> Hacer Pedido</button>
              </div>
            </div>
          </div>
      </div>
    <?php } ?>
    </div>
    </div>
  </main>
<script>
  function addProducto(id,token){
    let url = 'clases/pedidos.php'
    let formData= new FormData()
    formData.append('id',id)
    formData.append('token',token)
    fetch(url, {
      method: 'POST',
      body: formData, 
      mode:'cors'
    }).then(response => response.json())
    .then(data=>{
      if(data.ok){
        let elemento = document.getElementById("num_pedi")
        elemento.innerHTML = data.numero
      }

    })

  }
</script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
