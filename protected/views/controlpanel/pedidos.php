
<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Pedidos</h1>
  </div>
     <!-- SUBMENU ON -->
	<div class="navbar margin_top">
		<div class="navbar-inner">
    		<ul class="nav">
  				<li><a href="#" class="nav-header">Estadisticas:</a></li>
      			<li><a title="Transacciones" href="<?php echo Yii::app()->baseUrl."/controlpanel/ventas"; ?>">Transacciones</a></li>
      			<li class="active" ><a title="Pedidos" href="">Pedidos</a></li>
    		</ul>
  		</div>
	</div>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span12">
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
								'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
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
				       	
							   
      </div>
      <?php
      	
      	$proceso = Orden::model()->countByAttributes(array(), 'estado = :valor1 or estado = :valor2 or estado = :valor3', array(':valor1'=>1,':valor2'=>2,':valor3'=>7));
      	$vendidos = Orden::model()->countByAttributes(array('estado'=>3));
      	$cancelados = Orden::model()->countByAttributes(array(), 'estado = :valor1 or estado = :valor2', array(':valor1'=>5,':valor2'=>6));
      	$enviados = Orden::model()->countByAttributes(array('estado'=>4));
      	$completados = $vendidos + $enviados;
      	
      ?>
      <div class="row margin_top">
        <div class="span6 ">
         <h4 class="CAPS braker_bottom margin_bottom_small">ESTADO DE PEDIDOS</h4>
          <table width="100%" border="0" class="table table-bordered  table-striped"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>En proceso</strong>:</td>
              <td><?php echo $proceso; ?></td>
            </tr>
            <tr>
              <td><strong>Vendidos</strong>:</td>
              <td><?php echo $vendidos; ?></td>
            </tr>
            <tr>
              <td><strong>Cancelados y Devueltos</strong>:</td>
              <td><?php echo $cancelados; ?></td>
            </tr>
            <tr>
              <td><strong>Enviados</strong>:</td>
              <td><?php echo $enviados; ?></td>
            </tr>
            <tr>
              <td><strong>Completados</strong>:</td>
              <td><?php echo $completados; ?></td>
            </tr>
          </table>
        </div>
        <div class="span4 offset1">
        	<?php
        	
        		$this->Widget('ext.highcharts.HighchartsWidget', array(
				   'options'=>array(
				      	'chart'=> array(
				            'plotBackgroundColor'=> null,
				            'plotBorderWidth'=> null,
				            'plotShadow'=> false
				        ),
				      	'title' => array('text' => ''),
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
				         			array('En Proceso',(int)$proceso), 
				         			array('Vendidos',(int)$vendidos),
				         			array('Cancelados y Devueltos',(int)$cancelados),
				         			array('Enviados',(int)$enviados),
				         			array('Completados',(int)$completados)
									)),
				 
				      )
				 
				   )
			));
        	
        	?>
        </div>
      </div>
      
      
      
      
      <h2 class="braker_bottom margin_bottom_small">Pedidos</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Últimos 5 pedidos</a></li>
    
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab1">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Cliente</th>
              <th scope="col">Looks</th>
              <th scope="col">Productos</th>
              <th scope="col">Total</th>
            </tr>
      <?php      
      
      	$ultimasOrdenes = Orden::model()->findAll(array('limit'=>5,'order'=>'id DESC'));

		foreach($ultimasOrdenes as $each){			  
	 		$user = User::model()->findByPk($each->user_id);
			
			$compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$each->id));
			$tindiv = 0;
			$tlooks = 0;
			
			foreach ($compra as $tot) {
				if($tot->look_id == 0)
					$tindiv++;
				else
					$tlooks++;
				
			}

      ?>
      		<tr>
              <td><a href="#" title="Ver perfil"><?php echo $user->profile->first_name." ".$user->profile->last_name; ?></a></td>
              <td><?php echo $tlooks; ?></td>
              <td><?php echo $tindiv; ?></td>
              <td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$each->total); ?></td>
            </tr>
     <?php
		}
     ?>       
          </table>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- /container -->