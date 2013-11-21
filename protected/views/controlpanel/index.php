<?php
/* @var $this ControlPanelController */


$usuarios_totales = User::model()->count();
$looks_totales = Look::model()->count();
$productos_activos = Producto::model()->countByAttributes(array('status'=>1,'estado'=>0));
$ventas = Orden::model()->count();
$looks_aprobar = Look::model()->countByAttributes(array('status'=>1)); // por aprobar

	$ordenes = Orden::model()->findAll();
	$sumatoria = 0;
	
	foreach($ordenes as $uno)
	{
		if($uno->estado != 5)
			$sumatoria = $sumatoria + $uno->total;	
	}

/* forma anterior */	
$sql = "SELECT sum(total) as total FROM tbl_orden";
$dinero_ventas = Yii::app()->db->createCommand($sql)->queryScalar();

if($ventas != 0)
	$promedio = $sumatoria / $ventas;
else
	$promedio = 0;
?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Control</h1>
  </div>
  
  	<?php
  	/*
  	$url = "http://www.grupozoom.com/servicios/servicios.php?tipo_menu=tarifas";
	$data = array("servicio"=>1,
				"procesar"=>1,
				"txtcodguia"=>'',
				"optretirarofi"=>0,
				"txtciudadori"=>"ANACO",
				"cmbciudadori"=>"24",
				"codciudaddes"=>"48",
				"codoficinaopedes"=>"2",
				"codtraslado"=>3,
				"txtpeso"=>"30000",
				"txtciudaddes"=>"AGUA BLANCA",
				"txtcodservicio"=>0,
				"cmboficinades"=>"",
				"txtnumeropie"=>8,
				"pesomax"=>"",
				"nombreofides"=>"",
				"txtpesobru"=>7,
				"txtvalordec"=>60,
				"txtvalormin"=>50,
				
			);
  	$output = Yii::app()->curl->post($url, $data);
	
	$doc = new DOMDocument();
	$doc->loadHTML($output);
	//echo $data;
	$anchor_tags = $doc->getElementsByTagName('table');
	
	foreach ($anchor_tags as $tag) {
		
		
	if ($tag->getAttribute('class') == 'ContentArea'){
			echo $tag->nodeValue;
		}
		
	}
	//echo $output;
	 
	//$url = "https://api.instapago.com/api/payment";
	*/

	$data_array = array(
		"Amount"=>"200.00", // MONTO DE LA COMPRA
		"Description"=>"Compra de Look de Pruea", // DESCRIPCION 
		"CardHolder"=>"Rafael Angel Palma C", // NOMBRE EN TARJETA
		"CardHolderID"=>'14502908',
		"CardNumber"=>"4111111111111111", // NUMERO DE TARJETA
		"CVC"=>"124", //CODIGO DE SEGURIDAD
		"ExpirationDate"=>"10/2016", // FECHA DE VENCIMIENTO
		"StatusId"=>"2", // 1 = RETENER 2 = COMPRAR
		"Address"=>"Calle 16 Carrera 22 Qta Reina", // DIRECCION
		"City"=>"San Cristobal", // CIUDAD
		"ZipCode"=>"5001", // CODIGO POSTAL
		"State"=>"Tachira", //ESTADO
	);

	$output = Yii::app()->curl->putPago($data_array);
	print_r($output);

	/*
	echo "Success: ".$output->success."<br>"; // 0 = FALLO 1 = EXITO
	echo "Message:".$output->success."<br>"; // MENSAJE EN EL CASO DE FALLO
	echo "Id: ".$output->id."<br>"; // EL ID DE LA TRANSACCION
	echo "Code: ".$output->code."<br>"; // 201 = AUTORIZADO 400 = ERROR DATOS 401 = ERROR AUTENTIFICACION 403 = RECHAZADO 503 = ERROR INTERNO	
	*/
  	?>
  	
  
  <div class="row">
    <div class="span12 graficos_controlpanel">
      <div class="bg_color3 margin_bottom_small padding_small box_1">


            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#mes" data-toggle="tab">Mensual</a></li>
              <li><a href="#semana" data-toggle="tab">Semanal</a></li>
              <li><a href="#dia" data-toggle="tab">Diario</a></li>
            </ul>
            
            <div class="tab-content">
            	
              <div class="tab-pane active" id="mes" >
                <div class="clearfix" style="width: 100%;height: 100%;">   
                 	<?php
 
					$ya = date('Y-m-d', strtotime('now'));
					      	
					$sql = "select fecha from tbl_orden limit 1";
					$primera = Yii::app()->db->createCommand($sql)->queryScalar();
					
					// de dos meses a un mes como primer punto de ventas	      	
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -2 month'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
					$monthago = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					/*
					$sql = "select count(*) from tbl_orden where fecha between '".$primera."' and '".date('Y-m-d H:i:s', strtotime($ya. ' -1 month'))."' ";
					$monthago = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					*/
					
					// de un mes hasta hoy		
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".$ya."' ";
					$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					$uno = date('d-m-Y', strtotime($ya. ' -1 month'));
					$dos = date('d-m-Y', strtotime('now'));
					
					      	$this->Widget('ext.highcharts.HighchartsWidget', array(
							   'options'=>array(
							   	  'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
							      'title' => array('text' => 'Ventas en el último mes.'),
							      'xAxis' => array(
							         'categories' => array($uno, $dos)
							      ),
							      'yAxis' => array(
							         'title' => array('text' => 'Ventas')
							      ),
							      'series' => array(
							        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
							         array('name' => 'Total', 'data' => array($monthago,$ahora))
							      )
							   )
							));
					
					
					?>
        		</div>
              </div>
              
              <div class="tab-pane" id="semana">
                <div class="clearfix">
					<?php
					
					$ya = date('Y-m-d', strtotime('now'));
					      	
					$sql = "select fecha from tbl_orden limit 1";
					$primera = Yii::app()->db->createCommand($sql)->queryScalar();
					      	
					// un mes y una semana a un mes
					      	
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 month -1 week'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
					$cuatrosem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					//  a 3 semanas
					      	
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".date('Y-m-d', strtotime($ya. ' -3 week'))."' ";
					$tressem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// a 2 semanas
					      	
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -3 week'))."' and '".date('Y-m-d', strtotime($ya. ' -2 week'))."' ";
					$dossem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// a una semana
					      	
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -2 week'))."' and '".date('Y-m-d', strtotime($ya. ' -1 week'))."' ";
					$unosem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// de la primera venta hasta hoy
					
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 week'))."' and '".$ya."' ";
					$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar(); 	
					
					
					$uno = date('d-m-Y', strtotime($ya. ' -1 month'));
					$dos = date('d-m-Y', strtotime('now'));
					$tres = date('d-m-Y', strtotime('-3 week'));
					$cuatro = date('d-m-Y', strtotime('-2 week'));
					$cinco = date('d-m-Y', strtotime('-1 week'));
					
					
						$this->Widget('ext.highcharts.HighchartsWidget', array(
							'options'=>array(
								'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
								'title' => array('text' => 'Ventas por semanas'),
								'xAxis' => array(
									'categories' => array($uno, $tres, $cuatro, $cinco, $dos)
									),
								'yAxis' => array(
										'title' => array('text' => 'Ventas')
									),
								'series' => array(
										array('name' => 'Total', 'data' => array($cuatrosem, $tressem, $dossem, $unosem, $ahora))
									)
							)
						));
						
						
						?>
              	</div>
              </div>
              
              <div class="tab-pane" id="dia">
	            <div class="clearfix">
	            	<?php
					
					$ya = date('Y-m-d', strtotime('now'));
					      	
					$sql = "select fecha from tbl_orden limit 1";
					$primera = Yii::app()->db->createCommand($sql)->queryScalar();
					       	
					// un mes y un dia	
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 month -1 day'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
					$treintaun = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// de aqui en adelante diario
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".date('Y-m-d', strtotime($ya. '-1 month +1 day'))."' ";
					$treinta = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					$todos = Array();
					$fecha = Array();
					
					for($i=30 ; $i>0 ; $i--)
					{		
						$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. '-'.$i.' day'))."' and '".date('Y-m-d', strtotime($ya. '-'.($i-1).' day'))."' ";
						array_push($todos, (int) Yii::app()->db->createCommand($sql)->queryScalar());
						
						//echo $sql."<br>";
						
						array_push($fecha,date('d-m', strtotime($ya. '-'.($i-1).' day')));
					}				
					
					$sql = "select count(*) from tbl_orden where fecha between '".date('Y-m-d', strtotime($ya. ' -1 day'))."' and '".$ya."' ";
					$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar(); 	
					
					$uno = date('d-m', strtotime($ya. ' -1 month'));
					$tres = date('d-m', strtotime('-1 month +1 day'));

						$this->Widget('ext.highcharts.HighchartsWidget', array(
							'options'=>array(
								'chart' => array('type' =>'areaspline','width'=>1170), // column, area, line, spline, areaspline, bar, pie, scatter
								'title' => array('text' => 'Ventas por semanas'),
								'xAxis' => array(
									'categories' => array($uno,$tres,$fecha[0],$fecha[1],$fecha[2],$fecha[3],$fecha[4],$fecha[5],$fecha[6],$fecha[7],$fecha[8],$fecha[9],$fecha[10],
															$fecha[11],$fecha[12],$fecha[13],$fecha[14],$fecha[15],$fecha[16],$fecha[17],$fecha[18],$fecha[19],$fecha[20],
															$fecha[21],$fecha[22],$fecha[23],$fecha[24],$fecha[25],$fecha[26],$fecha[27],$fecha[28],$fecha[29])
									),
								'yAxis' => array(
										'title' => array('text' => 'Ventas')
									),
								'series' => array(
									array('name' => 'Total', 'data' => array($treintaun, $treinta,$todos[0],$todos[1],$todos[2],$todos[3],$todos[4],$todos[5],$todos[6],$todos[7],$todos[8],$todos[9],$todos[10]
																			,$todos[11],$todos[12],$todos[13],$todos[14],$todos[15],$todos[16],$todos[17],$todos[18],$todos[19],$todos[20]
																			,$todos[21],$todos[22],$todos[23],$todos[24],$todos[25],$todos[26],$todos[27],$todos[28],$todos[29]))
								)
							)
						));
						
						
					?>
	            </div>
	          </div>
	          
            </div>

</div></div>
      <div class="row">
        <div class="span6 margin_top">
         <div class="well well_personaling_big"> 
                   <h4 class="margin_top CAPS">Estadisticas</h4>

         
         <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Ventas Totales</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($sumatoria); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong> Promedio de Ventas</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($promedio); ?> Bs / Venta.</td>
            </tr>
            <tr>
              <td><strong>Numero de Usuarios registrados</strong>:</td>
              <td><?php echo $usuarios_totales; ?></td>
            </tr>
            <tr>
              <td><strong> Numero de Looks creados</strong>:</td>
              <td><?php echo $looks_totales; ?></td>
            </tr>
            <tr>
              <td><strong>Numero de Looks Aprobados</strong>:</td>
              <td><?php echo Look::model()->getAprovados(); ?> </td>
            </tr>
            <tr>
              <td><strong> Numero de Productos Activos</strong>:</td>
              <td><?php echo $productos_activos; ?></td>
            </tr>
          </table>
          <h4 class="margin_top">ACCIONES PENDIENTES</h4>
          <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Looks por aprobar</strong>:</td>
              <td><?php echo $looks_aprobar; ?></td>
            </tr>
          <tr>
              <td><strong>Pagos por confirmar</strong>:</td>
              <td><?php echo Orden::model()->getXConfirmar(); ?></td>
            </tr> 
            <tr>
              <td><strong>Personal Shoppers por aprobar</strong>:</td>
              <td><?php echo User::model()->aplicantes; ?></td>
            </tr>
          </table>
</div>        </div>
        <div class="span5 offset1 margin_top">
        	 <h4 class="margin_bottom_small">FUENTE DE REGISTROS</h4>
        	 
        	<?php

$sql = "SELECT count( * ) as total FROM tbl_users where twitter_id != '' ";
$a = Yii::app()->db->createCommand($sql)->queryScalar();

$sql = "SELECT count( * ) as total FROM tbl_users where facebook_id != '' ";
$b= Yii::app()->db->createCommand($sql)->queryScalar();

$sql = "SELECT count( * ) as total FROM tbl_users where twitter_id = NULL and twitter_id = NULL ";
$c = Yii::app()->db->createCommand($sql)->queryScalar();
		
$total = User::model()->count();

$tw = (int) $a / $total; // porcentaje por twitter
$fb = (int) $b / $total; // porcentaje por facebook
$nor = (int) ($total - $a - $b) / $total; // via normal por email
		 
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
      'chart'=> array(
            'plotBackgroundColor'=> null,
            'plotBorderWidth'=> null,
            'plotShadow'=> false
        ),
      'title' => array('text' => 'Fuentes de Registros'),
        'tooltip'=>array(
                'formatter'=>'js:function() { return "<b>"+ this.point.name +"</b>: "+ parseFloat(this.percentage).toFixed(2) +" %"; }'
                     ),
        'plotOptions'=>array(
            'pie'=>array(
                'allowPointSelect'=> true,
                'cursor'=>'pointer',
                'dataLabels'=>array(
                    'enabled'=> true,
                    'color'=>'#000000',
                    'connectorColor'=>'#000000',
                    'formatter'=>'js:function() { return "<b>"+ this.point.name +"</b>:"+ parseFloat(this.percentage).toFixed(2) +" %"; }'  
 
                                   )
                        )
                 ),
 
      'series' => array(
         array('type'=>'pie','name' => 'Ventas / Tiempo',
         		'data' => array(
         			array('Twitter',$tw), 
         			array('Facebook',$fb),
         			array(
                    	'name'=>'Normal',
                    	'y'=>$nor,
                    	'sliced'=>true,
                    	'selected'=>true
                    ))),
 
      )
 
   )
));
 
?>
	
         
      </div>
    </div>
  </div>
</div>
<!-- /container -->

