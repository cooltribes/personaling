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
	*/ 
	//$url = "https://api.instapago.com/api/payment";
	
/*
	$data_array = array(
		"Amount"=>"200.00", // MONTO DE LA COMPRA
		"Description"=>"Compra de Look de Pruea", // DESCRIPCION 
		"CardHolder"=>"Rafael Angel Palma C", // NOMBRE EN TARJETA
		"CardNumber"=>"1234123412341234", // NUMERO DE TARJETA
		"CVC"=>"124", //CODIGO DE SEGURIDAD
		"ExpirationDate"=>"10/2016", // FECHA DE VENCIMIENTO
		"StatusId"=>"2", // 1 = RETENER 2 = COMPRAR
		"Address"=>"Calle 16 Carrera 22 Qta Reina", // DIRECCION
		"City"=>"San Cristobal", // CIUDAD
		"ZipCode"=>"5001", // CODIGO POSTAL
		"State"=>"Tachira", //ESTADO
	);

	$output = Yii::app()->curl->putPago($data_array);

	echo "Success: ".$output->success."<br>"; // 0 = FALLO 1 = EXITO
	echo "Message:".$output->success."<br>"; // MENSAJE EN EL CASO DE FALLO
	echo "Id: ".$output->id."<br>"; // EL ID DE LA TRANSACCION
	echo "Code: ".$output->code."<br>"; // 201 = AUTORIZADO 400 = ERROR DATOS 401 = ERROR AUTENTIFICACION 403 = RECHAZADO 503 = ERROR INTERNO	
	*/
  	?>
  	
  
  <div class="row">
    <div class="span12">
      <div class="bg_color3 margin_bottom_small padding_small box_1">


<?php
 
$ya = date('Y-m-d H:i:s', strtotime('now'));
      	
$sql = "select fecha from tbl_orden limit 1";
$primera = Yii::app()->db->createCommand($sql)->queryScalar();
      	
// de la primera venta hasta hace un mes
      	
$sql = "select count(*) from tbl_orden where fecha between '".$primera."' and '".date('Y-m-d H:i:s', strtotime($ya. ' -1 month'))."' ";
$monthago = (int) Yii::app()->db->createCommand($sql)->queryScalar();

// de la primera venta hasta hoy

$sql = "select count(*) from tbl_orden where fecha between '".$primera."' and '".$ya."' ";
$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar(); 	

$uno = date('d-m-Y', strtotime($ya. ' -1 month'));
$dos = date('d-m-Y', strtotime('now'));

echo $primera."<br>".$ya;
      	
      	$this->Widget('ext.highcharts.HighchartsWidget', array(
		   'options'=>array(
		   	  'chart' => array('type' =>'areaspline'), // column, area, line, spline, areaspline, bar, pie, scatter
		      'title' => array('text' => 'Ventas / Tiempo'),
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
              <td><strong>Numero de Looks Activos</strong>:</td>
              <td>24</td>
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
              <td><strong> Looks por publicar</strong>:</td>
              <td>35</td>
            </tr>
            <tr>
              <td><strong>Mensajes por leer</strong>:</td>
              <td>8</td>
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

$tw = $a / $total; // porcentaje por twitter
$fb = $b / $total; // porcentaje por facebook
$nor = ($total - $a - $b) / $total; // via normal por email
		 
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
      'chart'=> array(
            'plotBackgroundColor'=> null,
            'plotBorderWidth'=> null,
            'plotShadow'=> false
        ),
      'title' => array('text' => 'Fuentes de Registros'),
        'tooltip'=>array(
                'formatter'=>'js:function() { return "<b>"+ this.point.name +"</b>: "+ this.percentage +" %"; }'
                     ),
        'plotOptions'=>array(
            'pie'=>array(
                'allowPointSelect'=> true,
                'cursor'=>'pointer',
                'dataLabels'=>array(
                    'enabled'=> true,
                    'color'=>'#000000',
                    'connectorColor'=>'#000000',
                    'formatter'=>'js:function() { return "<b>"+ this.point.name +"</b>:"+this.percentage +" %"; }'  
 
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

