<?php

	$html.='<div  style="height: 49.4%">';
			$html.='<table width="100%" class="table" style="font-size:12px;">
				<tr><td colspan="2" >
					<table width="100%">
					<tr ><td width="25%" style="border: 0;" ><b>CORPORACION BOLIVIANA DE FARMACIAS</b><br>Av.Landaeta Nro 836<br>La Paz - Bolivia<br>NIT:1022039027</td>
						<td width="25%" style="border: 0;"><center><span style="font-size: 13px"><b>PAPELETA DE SUELDOS</b></span><br><b>EXPRESADA EN BOLIVIANOS</b></center></td>
						<td width="25%" style="border: 0;"><center><table width="100%"><tr><td style="border: 0;align:left" width="70%">N° PAT. 651-1-956</td><td style="border: 0;" width="30%"><img class="" width="50" height="40" src="../assets/img/favicon.png"></td></tr></table></center></td>
					</tr>
					</table>
				</td></tr>
				<tr><td>
					<b>MES:</b> '.$mes.' de '.$gestion.'<br>
					<b>NOMBRE:</b> '.$result['apellidos'].' '.$result['nombres'].'<BR>
					<b>CARGO:</b> '.$result['cargo'].'<BR>
					<b>HABER BASICO:</b> '.formatNumberDec($result['haber_basico_pactado']).' BS <br>
					<b>DIAS TRAB:</b> '.$result['dias_trabajados'].' 
				</td>
				<td class="text-right"><b>Nro. Pla:</b> '.$index_planilla.'</td></tr>
				<tr><td width="50%" valign="top">
					<table width="100%">
						<tr><td colspan="2" style="background:#F2F2F2;border: 0;"><center><b>INGRESOS</b></center></td></tr>
						<tr>
							<td class=text-left" style="border: 0;font-family:Arial, sans-serif;" valign="top">Haber Basico días<br>Bono Antiguedad<br>Com Sobre Ventas<br>Fallo de Caja<br>Hras Noche<br>Hrs Domingo<br>Hrs. Feriado<br>Hrs. Extraordinarias<br>Reintegros<br>Movilidad<br>Refrigerio</td>
							<td class="text-right" style="border: 0;font-family:Arial, sans-serif;" valign="top">'.formatNumberDec($haber_basico_dias).'<br>'.formatNumberDec($bono_antiguedad).'<br>'.formatNumberDec($com_ventas).'<br>'.formatNumberDec($fallo_caja).'<br>'.formatNumberDec($hrs_noche).'<br>'.formatNumberDec($hras_domingo).'<br>'.formatNumberDec($hrs_feriado).'<br>'.formatNumberDec($hras_extraordianrias).'<br>'.formatNumberDec($reintegro).'<br>'.formatNumberDec($movilidad).'<br>'.$refrigerio.'<BR>&nbsp;<BR>&nbsp;</td>
						</tr>
						<tr>
							<td class=text-left" style="border: 0;"><b>Total Ingresos:</b></td>
							<td class="text-right" style="border: 0;">'.formatNumberDec($suma_ingresos).'</td>
						</tr>
					</table>
				</td>
				<td width="50%" valign="top">
					<table width="100%">
						<tr><td colspan="2" style="background:#F2F2F2;border: 0;"><center><b>DEDUCCIONES</b></center></td></tr>
						<tr>
							<td class="text-left" style="border: 0;font-family:Arial, sans-serif;" valign="top">Ap. Vejez 10%<br>Riesgo Prof. 1.71%<br>Com.AFP 0.5%<br>Apo.Sol 0.5%<br>RC IVA<br>Anticipos<br>Prestamos<br>Inventario<br>Vencidos<br>Atrasos<br>Faltantes Caja<br>Otros Descuentos<br>Aporte Sindical</td>
							<td class="text-right" style="border: 0;font-family:Arial, sans-serif;" valign="top">'.formatNumberDec($Ap_Vejez).'<br>'.formatNumberDec($Riesgo_Prof).'<br>'.formatNumberDec($ComAFP).'<br>'.formatNumberDec($aposol).'<br>'.formatNumberDec($RC_IVA).'<br>'.formatNumberDec($Anticipos).'<br>'.formatNumberDec($Prestamos).'<br>'.formatNumberDec($Inventario).'<br>'.formatNumberDec($Vencidos).'<br>'.formatNumberDec($Atrasos).'<br>'.formatNumberDec($Faltantes_Caja).'<br>'.formatNumberDec($Otros_Descuentos).'<br>'.formatNumberDec($Aporte_Sindical).'</td>
						</tr>
						<tr>
							<td class=text-left" style="border: 0;"><b>Total Egresos:</b></td>
							<td class="text-right" style="border: 0;">'.formatNumberDec($suma_egresos).'</td>
						</tr>
					</table>
				</td></tr>
				<tr>
				
				<td style="background:#F2F2F2;border-right: 0;">';
						//GENERANDO QR
						//generando Clave unico 
						$nuevo_numero=$cod_personal+$cod_planilla+$cod_mes+$cod_gestion;
						$cantidad_digitos=strlen($nuevo_numero);
						$numero_adicional=$nuevo_numero+100+$cantidad_digitos;
						$numero_exa=dechex($numero_adicional);//convertimos de decimal a hexadecimal 
						// echo $exa."_";
						// echo hexdec($exa);//se convierte hexa a decimal
						$codigo_generado=$cod_personal."#".$cod_planilla."#".$cod_mes."#".$cod_gestion."#".$numero_exa;
						$dir = 'qr_temp/';
                        if(!file_exists($dir)){
                            mkdir ($dir);}
                        $fileName = $dir.$codigo_generado.'.png';
                        $tamanio = 3; //tamaño de imagen que se creará
                        $level = 'M'; //tipo de precicion Baja L, mediana M, alta Q, maxima H
                        $frameSize = 1; //marco de qr                                
                        $contenido = $codigo_generado;
                        QRcode::png($contenido, $fileName, $level, $tamanio,$frameSize);
                        $html.='<img src="'.$fileName.'"/>';


					$html.='</td><td class="text-right" style="background:#F2F2F2;border-left: 0;"><b>Liquido Pagable: '.formatNumberDec($liquido_pagable).'
				</b></td></tr>
			</table>';
			// $html.='<table width="100%">
			// 	<tr>
			// 		<td><center><p>______________________________<br>Recibí Conforme</p></center></td>
			// 	</tr>
			// </table>';
			 // $html.='<div style="page-break-after: always"></div>';
	$html.='</div>';


?>