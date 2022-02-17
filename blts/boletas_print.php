<?php
if(!isset($_COOKIE["gl_usuario"])){
   ?><script type="text/javascript">window.location.href='../login.html';</script><?php
}
$gl_usuario=$_COOKIE["gl_usuario"];
// require "conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>BOLETA DE PAGOS</title>
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
    <?php

    require_once '../conexion.php';
    require_once '../functions.php';
    require_once '../functionsGeneral.php';
       // require_once '../layouts/bodylogin2.php';
    // require_once 'styles.php';
    $dbh = new Conexion();

    $cod_personal=$_GET["cod_personal"];
    $sql="SELECT p.paterno,p.materno,p.primer_nombre,(select c.nombre from cargos c where c.codigo=p.cod_cargo)as cargo from personal p where p.codigo=$cod_personal";
    $stmtpersonal = $dbh->query($sql);
    $nombre="NO ENCONTRADO.";
    $cargo="";
    while ($rowpersonal = $stmtpersonal->fetch()){ 
        $nombre= $rowpersonal["paterno"]." ".$rowpersonal["materno"]." ".$rowpersonal["primer_nombre"];
        $cargo = $rowpersonal["cargo"];
    }
    ?>
    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        <!-- /TOP HEADER -->

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
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-8">
                        
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-1 clearfix">
                        <div class="header-ctn">
                            <!-- Cart -->
                            <div class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-user"></i>
                                    <span><?=$_COOKIE["gl_nombre_usuario"]?></span>
                                    <div class="qty"></div>
                                </a>
                                <!-- <div class="cart-dropdown">
                                    <div class="cart-btns">
                                        <a href="../salir.php">Salir  <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div> -->
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->
    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                    <li class="active"><a href="../index.php">Inicio</a></li>
                    <?php 
                    if($gl_usuario==-1){ ?>
                        <li><a href="../product.php">Productos y Precios</a></li>
                    <?php
                        }
                    ?>
                    <li><a href="../blts/boletas_print.php?cod_personal=<?=$gl_usuario?>">Boleta de Pagos</a></li>
                    <li><a href="../salir.php">Cerrar Sesión<i class="fa fa-arrow-circle-right"></i></a></li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>

    <!-- /NAVIGATION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                    <div class="col-md-5">
                        <form id="form1" class="form-horizontal" action="boletas_html.php" method="GET"  target="_blank">
                        <div class="card">
                            <div class="card-header  card-header-text">
                                <div class="card-text">
                                  <h4 class="card-title">Impresión de Boletas</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Peronsal:</label>
                                    <div class="col-sm-4"><div class="form-group"><input class="form-control" type="text" readonly="true" style="background:white;color: blue;" value="<?=$nombre?>" ></div></div>
                                    
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label"> Cargo:</label>
                                    <div class="col-sm-4"><div class="form-group"><input class="form-control" type="text" readonly="true" style="background:white;color: blue;" value="<?=$cargo?>"></div></div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Mes</label>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select name="cod_planilla" id="cod_planilla" class="selectpicker form-control form-control-sm" data-style="btn btn-default"  data-show-subtext="true" data-live-search="true" required="true">
                                                <option value="">SELECCIONE MES</option>
                                                <?php 
                                                $query = "SELECT p.codigo,p.cod_mes,(select m.nombre from meses m where m.codigo=p.cod_mes) as nombre_mes,p.cod_gestion,(select g.nombre from  gestiones g where g.codigo=p.cod_gestion)as nombre_gestion from planillas p where p.cod_estadoplanilla=3";
                                                //echo $query;
                                                $stmt = $dbh->query($query);
                                                while ($rowges = $stmt->fetch()){ 
                                                        $codigo_nuevo=$rowges["codigo"].",".$rowges["cod_mes"].",".$rowges["cod_gestion"];
                                                    ?>
                                                    <option value="<?=$codigo_nuevo;?>"><?=$rowges["nombre_mes"];?> de <?=$rowges['nombre_gestion']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>   
                                <input type="hidden" name="cod_personal" id="cod_personal" value="<?=$cod_personal?>">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-rose">Generar Boleta</button>
                            </div>
                        </div>
                        </form>
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