<?php
require("conexionmysqli2.inc");
$usuario_adm = $_POST["usuario"];
$contrasena = $_POST["contrasena"];
$contrasena = str_replace("'", "''", $contrasena);

// $password2 = md5($contrasena);
$password2 = $contrasena;
$sql = "
    SELECT f.cod_cargo, f.cod_ciudad,u.codigo_funcionario
    FROM funcionarios f, usuarios_sistema u
    WHERE u.codigo_funcionario=f.codigo_funcionario AND u.usuario='$usuario_adm' AND u.contrasena='$password2' ";
$resp = mysqli_query($enlaceCon,$sql);
$num_filas = mysqli_num_rows($resp);
if ($num_filas != 0) {
    $dat = mysqli_fetch_array($resp);
    $cod_cargo = $dat[0];
    $cod_ciudad = $dat[1];
    $usuario = $dat[2];

    setcookie("gl_usuario", $usuario,time()+3600*24*30, '/');
    

	//sacamos el nombre del usuario
	$sqlUser="select nombres from funcionarios where codigo_funcionario='$usuario'";
	$respUser=mysqli_query($enlaceCon,$sqlUser);
	$nombreUser=mysqli_result($respUser,0,0);
	

	setcookie("gl_nombre_usuario",$nombreUser,time()+3600*24*30, '/');

	

   header("location:index.php");
}else{
	?><script type="text/javascript">window.location.href='login.html'</script><?php
}
?>
