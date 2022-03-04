<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
require("functions.php");

$cod_material=$_GET["cod_material"];


  $sql="SELECT a.cod_almacen,c.descripcion,c.direccion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad where c.cod_estadoreferencial=1 and c.cod_ciudad>0 and a.estado_pedidos=1 order by c.descripcion";
  //echo $sql;
  $resp=mysqli_query($enlaceCon,$sql); 

  $index=0;
  while($dat=mysqli_fetch_array($resp))
  {
   
   $codAlmacen=$dat[0];
   $sucursal=$dat[1];
   $direccion=$dat[2];   
   $stock=stockProducto($codAlmacen, $cod_material);   
   $estiloTexto="";
   if($stock>0){
      $index++; 
      echo "<tr $estiloTexto>
      <td><b>$sucursal</b><br><small><small>$direccion</small></small></td>      
      <td><b>$stock</b></td>
      </tr>";
    }    
  }
