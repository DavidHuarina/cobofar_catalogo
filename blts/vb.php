<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>VALIDACIÓN DE BOLETAS DE PAGOS</title>
        <link rel="shortcut icon" href="../img/icon_farma.ico" type="image/x-icon">
        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css"/>
        <!-- Slick -->
        <link type="text/css" rel="stylesheet" href="../css/slick.css"/>
        <link type="text/css" rel="stylesheet" href="../css/slick-theme.css"/>
        <!-- nouislider -->
        <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css"/>
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="../css/style.css"/>
    </head>
    <body>
    <!-- HEADER -->
    <header>
        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="#" class="logo">
                                <img src="../img/logo_farma.gif" alt="" width="300">
                            </a>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->


<?php
require_once '../functions.php';
require_once '../functionsGeneral.php';
require_once '../conexion.php';
$dbh = new Conexion();

$msg="ACCESO DENEGADO";
$estado=2;
$estilo_estado='style="background:red;"';
$icono='<i class="fa fa-times-circle"></i>';
if (isset($_GET['ws'])) {
    $string_codigo=$_GET['ws'];
    // echo $string_codigo."****";
    $array_codigo=explode('.', $string_codigo);
    if(count($array_codigo)==5){
        $cod_personal=$array_codigo[0];
        $cod_planilla=$array_codigo[1];
        $cod_mes=$array_codigo[2];
        $cod_gestion=$array_codigo[3];
        $numero_exa=hexdec($array_codigo[4]);//llegará en exadecimal
        ;//se convierte hexa a decimal
        //generando Clave unico 
        $nuevo_numero=$cod_personal+$cod_planilla+$cod_mes+$cod_gestion;
        $cantidad_digitos=strlen($nuevo_numero);
        $numero_adicional=$nuevo_numero+100+$cantidad_digitos;
        // $numero_exa=dechex($numero_adicional);//convertimos de decimal a hexadecimal 
        if($numero_adicional==$numero_exa){
            $msg="BOLETA CORRECTA";
            $estado=1;
        }else{
            $msg="DATOS INCORRECTOS.";
        }
    }else{
        $msg="ACCESO DENEGADO";
    }
}else{
    $msg="ACCESO DENEGADO";
}

if($estado==1){
    $estilo_estado='style="background:green;"';
    $icono='<i class="fa fa-check-circle"></i>';
    $mes=strtoupper(nombreMes($cod_mes));
    $gestion=nameGestion($cod_gestion);

    $sql="SELECT p.primer_nombre as nombres,CONCAT(p.paterno,' ', p.materno) as apellidos,(select c.nombre from cargos c where c.codigo=p.cod_cargo) as cargo,pm.liquido_pagable
    FROM personal p
    join planillas_personal_mes pm on pm.cod_personalcargo=p.codigo
    where pm.cod_planilla=$cod_planilla and p.codigo=$cod_personal";
    $stmtpersonal = $dbh->query($sql);
    $nombre="NO ENCONTRADO.";
    $cargo="";
    while ($rowpersonal = $stmtpersonal->fetch()){ 
        $nombre= $rowpersonal["nombres"]." ".$rowpersonal["apellidos"];
        $cargo = $rowpersonal["cargo"];
        // $liquido_pagable = $rowpersonal["liquido_pagable"];
    }
}
// echo $msg;
?>
    <div class="section" <?=$estilo_estado?>>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                    <div class="col-md-5">
                      
                        <div class="card">
                            <div class="card-header  card-header-text">
                                <div class="card-text">
                                  <h2><b><?=$msg?></b><br><center><?=$icono?></center></h2>
                                  <?php
                                 
                                 if($estado==1){ ?>
                                  <h5>Personal: <?=$nombre?><br>Cargo: <?=$cargo?><br>
                                    Mes-Gestión: <?=$mes?>-<?=$gestion?><br>
                                    </h5>
                                  <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /SECTION -->
<!-- jQuery Plugins -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/nouislider.min.js"></script>
    <script src="../js/jquery.zoom.min.js"></script>
    <script src="../js/main.js"></script>

</body>
</html>