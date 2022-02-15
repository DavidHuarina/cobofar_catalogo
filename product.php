<?php
if(!isset($_COOKIE["gl_usuario"])){
   ?><script type="text/javascript">window.location.href='login.html';</script><?php
}
$gl_usuario=$_COOKIE["gl_usuario"];
require "conexionmysqli2.inc";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>COBOFAR CATÁLOGO</title>
		<link rel="shortcut icon" href="img/icon_farma.ico" type="image/x-icon">

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
<style type="text/css">
	.badge-carro{
		position: absolute;background: #C70039;color:white;border: 1px solid white; border-radius: 50%;font-size: 12px;padding-right: 2px;padding-top: 2px;top:0px;right: 10px;font-weight: bold;width:25px;height: 25px;text-align: center;
	}
	.badge-precio{
		position: absolute;background: #32AE9D;color:white;border: 1px solid white; border-radius: 5px;font-size: 16px;padding-right: 2px;padding-top: 2px;bottom:20px;right: 10px;height: 30px;text-align: center;padding-left: 3px;
	}

</style>
    </head>
	<body>
		<?php 
$nombreProdGet="";
$codProducto="";
$lineaProd=0;
$sqlLinea="";
$sql2="";
if(isset($_POST['nom'])&&($_POST['nom']!=""||$_POST['cod']!="")){
	$nombreProdGet=$_POST['nom'];
	$codProducto=$_POST['cod'];
	if($_POST['proveedor']>0){
		$lineaProd=$_POST['proveedor'];
		$sqlLinea=" m.cod_linea_proveedor in (SELECT cod_linea_proveedor from proveedores_lineas where cod_proveedor='$lineaProd')  and ";
	}

	if($codProducto>0){
		$sql="SELECT m.codigo_material,m.descripcion_material,m.cantidad_presentacion,(SELECT precio from precios where codigo_material=m.codigo_material and cod_precio=1 and cod_ciudad=-1 order by precio desc limit 1)precio,(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT l.cod_proveedor from proveedores_lineas l where l.cod_linea_proveedor=m.cod_linea_proveedor))proveedor FROM material_apoyo m where m.codigo_material='$codProducto'";		
	}else{
    	$sql="SELECT m.codigo_material,m.descripcion_material,m.cantidad_presentacion,(SELECT precio from precios where codigo_material=m.codigo_material and cod_precio=1 and cod_ciudad=-1 order by precio desc limit 1)precio,(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT l.cod_proveedor from proveedores_lineas l where l.cod_linea_proveedor=m.cod_linea_proveedor))proveedor FROM material_apoyo m where $sqlLinea m.descripcion_material like '%$nombreProdGet%' order by m.descripcion_material  limit 10";	

    	$sql2="SELECT m.codigo_material,m.descripcion_material,m.cantidad_presentacion,(SELECT precio from precios where codigo_material=m.codigo_material and cod_precio=1 and cod_ciudad=-1 order by precio desc limit 1)precio,(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT l.cod_proveedor from proveedores_lineas l where l.cod_linea_proveedor=m.cod_linea_proveedor))proveedor FROM material_apoyo m where $sqlLinea m.descripcion_material like '%$nombreProdGet%' order by m.descripcion_material";		
	}

}else{
	$sql="SELECT m.codigo_material,m.descripcion_material,m.cantidad_presentacion,(SELECT precio from precios where codigo_material=m.codigo_material and cod_precio=1 and cod_ciudad=-1 order by precio desc limit 1)precio,(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT l.cod_proveedor from proveedores_lineas l where l.cod_linea_proveedor=m.cod_linea_proveedor))proveedor FROM material_apoyo m where m.cod_linea_proveedor=70 having precio>0 order by m.descripcion_material  limit 10";
}

if($sql2==""){
	$sql2=$sql;
}
//echo $sql;
		?>

<script type="text/javascript">	
	function subirPrecio(prod){
		var cantidad=parseInt($("#cantidad_entera_prod"+prod).val());
		//if(cantidad<99){
			cantidad++;			
			$("#cantidad_prod"+prod).html(cantidad);
			$("#cantidad_entera_prod"+prod).val(cantidad);
			var preunit=parseFloat($("#precio_unidad_prod"+prod).val());
			$("#precio_total_prod"+prod).html("T: "+(preunit*cantidad).toFixed(2)+" Bs.");
		//}
	}
	function bajarPrecio(prod){
		var cantidad=parseInt($("#cantidad_entera_prod"+prod).val());
		if(cantidad>1){
			cantidad--;
			$("#cantidad_prod"+prod).html(cantidad);
			$("#cantidad_entera_prod"+prod).val(cantidad);
			var preunit=parseFloat($("#precio_unidad_prod"+prod).val());
			$("#precio_total_prod"+prod).html("T: "+(preunit*cantidad).toFixed(2)+" Bs.");
		}
	}
	function cambiarCantidad(prod){
		var cantidad=parseInt($("#cantidad_entera_prod"+prod).val());	
		if(cantidad>0){		
			$("#cantidad_prod"+prod).html(cantidad);
			var preunit=parseFloat($("#precio_unidad_prod"+prod).val());
			$("#precio_total_prod"+prod).html("T: "+(preunit*cantidad).toFixed(2)+" Bs.");
		}
	}
</script>

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
									<img src="./img/logo_farma.gif" alt="" width="300">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-8">
							<div class="header-search">
								<form action="product.php" method="post">
									<select class="input-select" name="proveedor" style='width:100px !important;'>
										<option value="0">Todos</option>
										
										<?php 
											$sqlTipo="select p.cod_proveedor,p.nombre_proveedor from proveedores p
																where p.estado_activo=1 and p.cod_proveedor>0 order by 2;";

											$respTipo=mysqli_query($enlaceCon,$sqlTipo);
											while($datTipo=mysqli_fetch_array($respTipo)){
												$codTipoMat=$datTipo[0];
												$nombreTipoMat=$datTipo[1];
												if($lineaProd==$codTipoMat){
												    echo "<option value=$codTipoMat selected>$nombreTipoMat</option>";	
												}else{
													echo "<option value=$codTipoMat>$nombreTipoMat</option>";
												}
												
											}
										?>
									</select>

									<input class="input" placeholder="Buscar Producto" name="nom" value="<?=$nombreProdGet?>" style='width: 250px;'>
									<input class="input" placeholder="Codigo" name="cod" style='width: 100px;' value="<?=$codProducto?>">
									<button class="search-btn" type="submit">Buscar</button>
								</form>
							</div>
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
									<div class="cart-dropdown">
										<div class="cart-btns">
											<a href="salir.php">Salir  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
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
						<li class="active"><a href="index.php">Inicio</a></li>
						<?php 
						if($gl_usuario==-1){ ?>
							<li><a href="product.php">Productos y Precios</a></li>
						<?php
							}
						?>
						<li><a href="boletas/boletas_print.php?cod_personal=<?=$gl_usuario?>">Boleta de Pagos</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>

		<!-- /NAVIGATION -->

	<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="section-title">
							<h4 class="title">Resultados de la Búsqueda</h4>
							<div class="section-nav">
								<div id="slick-nav-3" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-3">
							<div>
<?php
	$resp=mysqli_query($enlaceCon,$sql2);
	while($dat=mysqli_fetch_array($resp))
	{
		$codMaterial=$dat['codigo_material'];	
		$nombreProd=$dat['descripcion_material'];
		$proveedor=$dat['proveedor'];
		$precioOrigen=$dat['precio'];
		if($precioOrigen>0){
			$precio2=number_format((($precioOrigen*100)/97),2,'.',',');
			$precio=number_format($precioOrigen,2,'.',',');
			$precioOrigen=number_format($precioOrigen,2,'.','');

			
										?>
							   <!-- product widget -->
							   <input type="hidden" id="precio_unidad_prod<?=$codMaterial?>" value='<?=$precioOrigen?>'>
								<div class="product-widget">
									<div class="product-img">
										<img src="./img/card.png" alt="">
										<div class='badge-carro' id='cantidad_prod<?=$codMaterial?>'>1</div>
									</div>
									<div class="product-body">
										<p class="product-category"><?=$proveedor?></p>
										<h3 class="product-name"><a href="#"><?=$nombreProd?></a></h3>
										<h4 class="product-price">Bs <?=$precio?> <del class="product-old-price">Bs <?=$precio2?></del></h4>
										<span id='precio_total_prod<?=$codMaterial?>' class='badge-precio'>T: <?=$precio?> Bs.</span>
										<div>
												<button class='btn btn-sm' onclick='bajarPrecio(<?=$codMaterial?>); return false;'>-</button>
												<input type="number" id='cantidad_entera_prod<?=$codMaterial?>' style='text-align: right;width:60px' value='1' onkeyup='cambiarCantidad(<?=$codMaterial?>)' onkeypress='cambiarCantidad(<?=$codMaterial?>)' placeholder='Cant'>
												<button class='btn btn-sm' onclick='subirPrecio(<?=$codMaterial?>); return false;'>+</button>
											</div>
										<br>
									</div>
								</div>
								<!-- /product widget -->
										<?php
		}
	}
	?>
								
							</div>
						</div>
					</div>

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Productos</h3>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
<?php


	
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{
		$nombreProd=$dat['descripcion_material'];
		$proveedor=$dat['proveedor'];
		$precio=$dat['precio'];
		if($precio>0){
			$precio2=number_format((($precio*100)/97),2,'.',',');
			$precio=number_format($precio,2,'.',',');			
										?><!-- product -->
										<div class="product">
											<div class="product-img">
												<img src="./img/card.png" alt="">
												<div class="product-label">
													<span class="new">Prod</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category"><?=$proveedor?></p>
												<h3 class="product-name"><a href="#"><?=$nombreProd?></a></h3>
												<h4 class="product-price">Bs <?=$precio?> <del class="product-old-price">Bs <?=$precio2?></del></h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</div>
											</div>
											<div class="add-to-cart">
												<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> agregar</button>
											</div>
										</div>
										<!-- /product --><?php

		}
	}
	?>
										
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->


	

		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-4 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Us</h3>
								<p>Farmacias Bolivia</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>Av. Landaeta N° 836</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>+591 70013999</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>cobofar@farmaciasbolivia.com.bo</a></li>
								</ul>
							</div>
						</div>


						<div class="clearfix visible-xs"></div>

					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Cobofar <i class="fa fa-heart-o" aria-hidden="true"></i> <a href="https://colorlib.com" target="_blank">FARMACIAS BOLIVIA</a>
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>
