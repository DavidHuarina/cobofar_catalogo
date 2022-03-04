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
