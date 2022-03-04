<?php
set_time_limit(0);
error_reporting(0);


 $enlaceCon=mysqli_connect("p:127.0.0.1","root","","farmaciasventas16102021");
//$enlaceCon=mysqli_connect("p:10.10.1.11","isullcamani","B0l1v14.@1202**","farmaciasventas");

if (mysqli_connect_errno())
{
	echo "Error en la conexión: " . mysqli_connect_error();
}
mysqli_set_charset($enlaceCon,"utf8");



if (!function_exists('mysqli_result')) {
    function mysqli_result($result, $number, $field=0) {
        mysqli_data_seek($result, $number);
        $row = mysqli_fetch_array($result);
        return $row[$field];
    }
}
?>
