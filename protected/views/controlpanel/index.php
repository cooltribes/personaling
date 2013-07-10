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

$promedio = $sumatoria / $ventas;

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Control</h1>
  </div>
  <div>
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
	$url = "https://api.instapago.com/api/payment";
	$data_array = array(
		"KeyId"=> "069C794A-6917-4283-B26F-2AFC7F685A96",
		"PublicKeyId"=>"5274e829763cd383270512b87a6c947e",
		"Amount"=>"200.00",
		"Description"=>"Compra de Look de Pruea",
		"CardHolder"=>"Rafael Angel Palma C",
		"CardNumber"=>"5412474301594501",
		"CVV"=>"108",
		"ExpirationDate"=>"08/2017",
		"StatusId"=>"2",
		"Address"=>"Calle 16 Carrera 22 Qta Reina",
		"City"=>"San Cristobal",		
		"ZipCode"=>"5001",
		"State"=>"Tachira",
	);
	$data = json_encode($data_array);
	
	$string = "KeyId=069C794A-6917-4283-B26F-2AFC7F685A96&PublicKeyId=5274e829763cd383270512b87a6c947e&Amount=200.00&Description=Compra+de+Look+de+Pruea&CardHolder=Rafael+Angel+Palma+C&CardNumber=5412474301594501&CVC=108&ExpirationDate=08%2F2017&StatusId=2&Address=Calle+16+Carrera+22+Qta+Reina&City=San+Cristobal&ZipCode=5001&State=Tachira";
	//$output = Yii::app()->curl->put($url, $data);
	//$output = Yii::app()->curl->put($url, $data,$data_array);
	$output = Yii::app()->curl->put2($url, $string);
	//$output = Yii::app()->curl->put2($url, $data);
	//$output = Yii::app()->curl->put2($url, $data_array);
	
	echo $output;
	//echo Yii::app()->curl->getstatus();
  	?>
  	
  </div>
  <div class="row">
    <div class="span12">
      <div class="bg_color3 margin_bottom_small padding_small box_1">


<?php
      	
      	$this->Widget('ext.highcharts.HighchartsWidget', array(
		   'options'=>array(
		   	  'chart' => array('type' =>'areaspline'), // column, area, line, spline, areaspline, bar, pie, scatter
		      'title' => array('text' => 'Ventas / Tiempo'),
		      'xAxis' => array(
		         'categories' => array('Abril', 'Mayo', 'Junio', 'Julio', 'Agosto')
		      ),
		      'yAxis' => array(
		         'title' => array('text' => 'Ventas')
		      ),
		      'series' => array(
		        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
		         array('name' => 'Totales', 'data' => array(110, 240, 587, 452, 241))
		      )
		   )
		));


?>

      	<img src="<?php echo Yii::app()->baseUrl; ?>/images/stats_sample.png" alt="estadisticas"/> </div>
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
        	
        	<?php
 
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
      'chart'=> array(
            'plotBackgroundColor'=> null,
            'plotBorderWidth'=> null,
            'plotShadow'=> false
        ),
      'title' => array('text' => 'Ventas / Tiempo'),
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
         			array('Abril',110), 
         			array('Mayo',240),
         			array('Junio',587),
         			array('Julio',452),
         			array(
                    	'name'=>'Agosto',
                    	'y'=>241,
                    	'sliced'=>true,
                    	'selected'=>true
                    ))),
 
      )
 
   )
));
 
?>
        	
          <h4 class="margin_bottom_small">FUENTE DE REGISTROS</h4>
          <img src="<?php echo Yii::app()->baseUrl; ?>/images/stats2.png" alt="estadisticas "> </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->

