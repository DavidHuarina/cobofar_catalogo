<?php



  function obtenerValorConfiguracionPlanillas($cod){
    $dbh = new Conexion();
    $stmt = $dbh->prepare("SELECT valor_configuracion from configuraciones_planillas where id_configuracion=$cod");
    $stmt->execute();
    $result= $stmt->fetch();
    $valor=$result['valor_configuracion'];
    return $valor;
  }
  function nombreMes($month){
    if($month==1){    return ("Enero");   }
    if($month==2){    return ("Febrero");  }
    if($month==3){    return ("Marzo");  }
    if($month==4){    return ("Abril");  }
    if($month==5){    return ("Mayo");  }
    if($month==6){    return ("Junio");  } 
    if($month==7){    return ("Julio");  }
    if($month==8){    return ("Agosto");  }
    if($month==9){    return ("Septiembre");  }
    if($month==10){    return ("Octubre");  }         
    if($month==11){    return ("Noviembre");  }         
    if($month==12){    return ("Diciembre");  }             
  }

  function nameGestion($codigo){
     $dbh = new Conexion();
     $stmt = $dbh->prepare("SELECT nombre FROM gestiones where codigo=:codigo");
     $stmt->bindParam(':codigo',$codigo);
     $stmt->execute();
     $nombreX="";
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombreX=$row['nombre'];
     }
     return($nombreX);
  }


    function descargarPDFBoleta2($nom,$html){
    //aumentamos la memoria  
    ini_set("memory_limit", "128M");
    // Cargamos DOMPDF
    require_once 'assets/libraries/dompdf/dompdf_config.inc.php';
    $mydompdf = new DOMPDF();
    ob_clean();
    $mydompdf->load_html($html);
    $mydompdf->render();
    $canvas = $mydompdf->get_canvas();
    $canvas->page_text(500, 25, "", Font_Metrics::get_font("sans-serif"), 10, array(0,0,0)); 
    $mydompdf->set_base_path('assets/libraries/plantillaPDF_planillas.css');
    $mydompdf->stream($nom.".pdf", array("Attachment" => false));
  }

   function descargarPDFBoleta($nom,$html){
    //aumentamos la memoria  
    ini_set("memory_limit", "128M");
    // Cargamos DOMPDF
    require_once 'assets/libraries/dompdf/dompdf_config.inc.php';
      $dompdf = new DOMPDF();
      // $dompdf->set_paper("letter", "portrait");
      $dompdf->set_paper("A4", "portrait");
      $dompdf->load_html($html);    
      $dompdf->render();
      $pdf = $dompdf->output();
      file_put_contents("../blts/boletas_temp/".$nom.".pdf", $pdf);
  }

function obtenerNombreProductoSimple($codigo){
  require("conexionmysqli2.inc");
  $sql="select descripcion_material from material_apoyo where codigo_material=$codigo";
  $resp=mysqli_query($enlaceCon,$sql);
  $nombre="";
  while($dat=mysqli_fetch_array($resp)){
  $nombre=$dat[0];
  }
  return($nombre);
}
function obtenerSucursalporAlmacen($almacen){
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT a.cod_ciudad from almacenes a where a.cod_almacen='$almacen'";
  // echo $sql_detalle;
  $codigo="";       
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){  
       $codigo=$detalle[0];       
  }  
  return $codigo;
}

function obtenerInicioActividadesSucursal($id){
  $estilosVenta=1;
  require("conexionmysqli2.inc");
  $sql = "SELECT fecha_inicio from configuraciones_inicio_sucursales c where cod_ciudad=$id";
  $resp=mysqli_query($enlaceCon,$sql);
  $codigo="1983-01-01";
  while ($dat = mysqli_fetch_array($resp)) {
    $codigo=$dat['fecha_inicio'];
  }
  return($codigo);
}
function stockProducto($almacen, $item){  
  $fechaActual=date("Y-m-d");
  $stock2=stockProductoFechas($almacen, $item,$fechaActual);
  return($stock2);
}

function stockProductoFechas($almacen, $item,$fechaActual){
  $estilosVenta=1;
  $codSucursal=obtenerSucursalporAlmacen($almacen);
  $fechaInicioSucursal=obtenerInicioActividadesSucursal($codSucursal);
  require("conexionmysqli2.inc");

  $sql_ingresos="select IFNULL(sum(id.cantidad_unitaria),0) from ingreso_almacenes i, ingreso_detalle_almacenes id
      where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.fecha BETWEEN '$fechaInicioSucursal' and '$fechaActual' and i.cod_almacen='$almacen'
      and id.cod_material='$item' and i.ingreso_anulado=0";
  $resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
  $dat_ingresos=mysqli_fetch_array($resp_ingresos);
  $cant_ingresos=$dat_ingresos[0];
  $sql_salidas="select IFNULL(sum(sd.cantidad_unitaria),0) from salida_almacenes s, salida_detalle_almacenes sd
      where s.cod_salida_almacenes=sd.cod_salida_almacen and s.fecha BETWEEN '$fechaInicioSucursal' and '$fechaActual' and s.cod_almacen='$almacen'
      and sd.cod_material='$item' and s.salida_anulada=0";
  $resp_salidas=mysqli_query($enlaceCon,$sql_salidas);
  $dat_salidas=mysqli_fetch_array($resp_salidas);
  $cant_salidas=$dat_salidas[0];
  $stock2=$cant_ingresos-$cant_salidas;
  
    mysqli_close($enlaceCon);
    return $stock2;
}
?>