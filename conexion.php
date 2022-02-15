<?php 


class Conexion extends PDO { 
   
private $tipo_de_base = 'mysql';
private $host = '10.10.1.11';

private $nombre_de_base = 'financierocobofarbk1';   
private $usuario = 'isullcamani';
private $contrasena = 'B0l1v14.@1202**';

  private $port = '3306';

  
  public function __construct() {
    //Sobreescribo el método constructor de la clase PDO.
    try{
      parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base.';port='.$this->port, $this->usuario, $this->contrasena,array(PDO::ATTR_PERSISTENT => 'buff',PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));//      
    }catch(PDOException $e){
       echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
       exit;
    }
  } 
}  

?>