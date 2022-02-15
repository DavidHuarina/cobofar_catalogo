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


    function descargarPDFBoleta($nom,$html){
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


?>