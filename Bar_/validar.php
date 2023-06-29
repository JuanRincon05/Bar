<?php
/* Este valida los campos del formulario Index.html, el usuario debe estar registrado con 
anterioridad y dependiendo de que rol le halla dado el administrador lo redirigira a la pagina acorde con 
sus funciones definidas, de no estar registrado el sistema mostrara un error de autenticacion.
*/
$usuario=$_POST['usuario']; 
$contraseña=$_POST['contraseña'];
session_start();
$_SESSION['usuario']=$usuario;

$conexion=mysqli_connect("localhost","root","","bar");

$consulta="SELECT*FROM personal where usuario='$usuario' and contraseña='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_fetch_array($resultado);

if($filas['id_cargo']==1){ //admin
header("location:admin/admin.php");
}else
if($filas['id_cargo']==2){ //Cajero
header("location:cajero/pedido.php");
}else
if ($filas['id_cargo']==3){ //Mesero
header("location:mesero/inicio.php");
}
else{
    ?>
    <?php
    include("index.html");
    ?>
    <h1 class="bad">ERROR EN LA AUTENTIFICACION</h1>
    <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
