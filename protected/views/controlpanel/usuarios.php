<div class="container margin_top">
  <div class="page-header">
    <div class="row">
      <div class="span10">
        <h1>Panel de Control de Usuarios</h1>
      </div>
      <div class="span2">
        <div class="bg_color10 padding_small color1 text_align_center"><span class="T_large">1844</span><br/>
          usuarios registrados</div>
      </div>
    </div>
  </div>

  <!-- SUBMENU ON -->

	<div class="navbar margin_top">
  		<div class="navbar-inner">
    		<ul class="nav">
  				<li><a href="" class="nav-header">Estadisticas:</a></li>
		      	<li><a title="Por Registro" href="">Registro de Usuarios</a></li>
		      	<li><a title="Por Ingreso" href="<?php echo  Yii::app()->baseUrl; ?>/controlpanel/ingresos">Ingreso de Usuarios</a></li>
      		</ul>
     		<ul class="nav pull-right">
				<li><a href="<?php echo Yii::app()->baseUrl."/user/admin" ?>" title="Administrar Usuarios">Admininstrar usuarios</a></li> 
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
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -2 month'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
					$monthago = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					/*
					$sql = "select count(*) from tbl_orden where fecha between '".$primera."' and '".date('Y-m-d H:i:s', strtotime($ya. ' -1 month'))."' ";
					$monthago = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					*/
					
					// de un mes hasta hoy		
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".$ya."' ";
					$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					$uno = date('d-m-Y', strtotime($ya. ' -1 month'));
					$dos = date('d-m-Y', strtotime('now'));
					
					      	$this->Widget('ext.highcharts.HighchartsWidget', array(
							   'options'=>array(
							   	  'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
							      'title' => array('text' => 'Registros en el último mes.'),
							      'xAxis' => array(
							         'categories' => array($uno, $dos)
							      ),
							      'yAxis' => array(
							         'title' => array('text' => 'Ventas')
							      ),
							      'series' => array(
							        // array('name' => 'Jane', 'data' => array(1, 0, 4)),
							         array('name' => 'Nuevos usuarios', 'data' => array($monthago,$ahora))
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
					      	
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 month -1 week'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
					$cuatrosem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					//  a 3 semanas
					      	
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".date('Y-m-d', strtotime($ya. ' -3 week'))."' ";
					$tressem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// a 2 semanas
					      	
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -3 week'))."' and '".date('Y-m-d', strtotime($ya. ' -2 week'))."' ";
					$dossem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// a una semana
					      	
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -2 week'))."' and '".date('Y-m-d', strtotime($ya. ' -1 week'))."' ";
					$unosem = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// de la primera venta hasta hoy
					
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 week'))."' and '".$ya."' ";
					$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar(); 	
					
					
					$uno = date('d-m-Y', strtotime($ya. ' -1 month'));
					$dos = date('d-m-Y', strtotime('now'));
					$tres = date('d-m-Y', strtotime('-3 week'));
					$cuatro = date('d-m-Y', strtotime('-2 week'));
					$cinco = date('d-m-Y', strtotime('-1 week'));
					
					
						$this->Widget('ext.highcharts.HighchartsWidget', array(
							'options'=>array(
								'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
								'title' => array('text' => 'Registros por semanas'),
								'xAxis' => array(
									'categories' => array($uno, $tres, $cuatro, $cinco, $dos)
									),
								'yAxis' => array(
										'title' => array('text' => 'Ventas')
									),
								'series' => array(
										array('name' => 'Nuevos usuarios', 'data' => array($cuatrosem, $tressem, $dossem, $unosem, $ahora))
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
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 month -1 day'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
					$treintaun = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					// de aqui en adelante diario
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".date('Y-m-d', strtotime($ya. '-1 month +1 day'))."' ";
					$treinta = (int) Yii::app()->db->createCommand($sql)->queryScalar();
					
					$todos = Array();
					$fecha = Array();
					
					for($i=30 ; $i>0 ; $i--)
					{		
						$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. '-'.$i.' day'))."' and '".date('Y-m-d', strtotime($ya. '-'.($i-1).' day'))."' ";
						array_push($todos, (int) Yii::app()->db->createCommand($sql)->queryScalar());
						
						//echo $sql."<br>";
						
						array_push($fecha,date('d-m', strtotime($ya. '-'.($i-1).' day')));
					}				
					
					$sql = "select count(*) from tbl_users where create_at between '".date('Y-m-d', strtotime($ya. ' -1 day'))."' and '".$ya."' ";
					$ahora = (int) Yii::app()->db->createCommand($sql)->queryScalar(); 	
					
					$uno = date('d-m', strtotime($ya. ' -1 month'));
					$tres = date('d-m', strtotime('-1 month +1 day'));

						$this->Widget('ext.highcharts.HighchartsWidget', array(
							'options'=>array(
								'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
								'title' => array('text' => 'Registros diarios del mes.'),
								'xAxis' => array(
									'categories' => array($uno,$tres,$fecha[0],$fecha[1],$fecha[2],$fecha[3],$fecha[4],$fecha[5],$fecha[6],$fecha[7],$fecha[8],$fecha[9],$fecha[10],
															$fecha[11],$fecha[12],$fecha[13],$fecha[14],$fecha[15],$fecha[16],$fecha[17],$fecha[18],$fecha[19],$fecha[20],
															$fecha[21],$fecha[22],$fecha[23],$fecha[24],$fecha[25],$fecha[26],$fecha[27],$fecha[28],$fecha[29])
									),
								'yAxis' => array(
										'title' => array('text' => 'Ventas')
									),
								'series' => array(
									array('name' => 'Usuarios', 'data' => array($treintaun, $treinta,$todos[0],$todos[1],$todos[2],$todos[3],$todos[4],$todos[5],$todos[6],$todos[7],$todos[8],$todos[9],$todos[10]
																			,$todos[11],$todos[12],$todos[13],$todos[14],$todos[15],$todos[16],$todos[17],$todos[18],$todos[19],$todos[20]
																			,$todos[21],$todos[22],$todos[23],$todos[24],$todos[25],$todos[26],$todos[27],$todos[28],$todos[29]))
								)
							)
						));
						
						
					?>
	            </div>
	          </div>
	          
            </div>	
 
      <div class=" margin_top">
        <div class="">
          <h4 class="CAPS braker_bottom margin_bottom_small">REGISTROS</h4>
	      <ul class="nav nav-tabs">
	        <li class="active"><a data-toggle="tab" href="#tab1">Tipos</a></li>
	        <li><a data-toggle="tab" href="#tab2">Estatura</a></li>
	        <li><a data-toggle="tab" href="#tab3">Contextura</a></li>
	        <li><a data-toggle="tab" href="#tab4">Color de cabello</a></li>
	        <li><a data-toggle="tab" href="#tab5">Color de Ojos</a></li>
	        <li><a data-toggle="tab" href="#tab6">Color de Piel</a></li>
	        <li><a data-toggle="tab" href="#tab7">Tipo de Cuerpo</a></li>
	        <li><a data-toggle="tab" href="#tab8">Género</a></li>
	        <li><a data-toggle="tab" href="#tab9">Edades</a></li>
	      </ul>    
		    <div class="tab-content">
		        <div class="tab-pane active" id="tab1">	            
		          <?php $us= new User;?>
		          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
		            <tr>
		              <th scope="col">Tipos</th>
		              <th scope="col">Registros</th>
		              <th scope="col">% Registros</th>
		            </tr>
		            <tr>
		              <td>Clientes</td>
		              <td><?php echo $us->getTotalClients(); ?></td>
		              <td><?php echo $us->getPercent('Client')." %"; ?></td>
		            </tr>
		            <tr>
		              <td>Personal Shoppers</td>
		              <td><?php echo $us->getTotalPS(); ?></td>
		              <td><?php echo $us->getPercent('PS')." %"; ?></td>
		            </tr>
		            <tr>
		              <td>Administradores</td>
		              <td><?php echo $us->getTotalAdmin(); ?></td>
		              <td><?php echo $us->getPercent('Admin')." %"; ?></td>
		            </tr>
		            <tr> 
		              <td>Aplicantes</td>
		              <td><?php echo $us->getAplicantes(); ?></td>
		              <td><?php echo $us->getPercent('App')." %"; ?></td>
		            </tr>
		          </table>
		        </div>
		        <div class="tab-pane" id="tab2">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Estatura</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>1.55-1.65</td>
						  <td><?php $alts=Profile::model()->countXestatura(); if(!isset($alts[1]))$alts[1]=0; echo $alts[1];?></td>
						  <td><?php echo round($alts[1]*$alts[0],2)?>%</td>
						</tr>
						<tr>
						  <td>1.66-1.75</td>
						  <td><?php if(!isset($alts[2]))$alts[2]=0;echo $alts[2];?></td>
						  <td><?php echo round($alts[2]*$alts[0],2)?>%</td>
						</tr>
						<tr>
						  <td>1.76 -1.85</td>
						  <td><?php if(!isset($alts[4]))$alts[4]=0; echo $alts[4];?></td>
						  <td><?php echo round($alts[4]*$alts[0],2)?>%</td>
						</tr>
						<tr> 
						  <td>1.86-1.95</td>
						  <td><?php if(!isset($alts[8]))$alts[8]=0;echo $alts[8];?></td>
						  <td><?php echo round($alts[8]*$alts[0],2)?>%</td>
						</tr>
					</table>
		        </div>
		        <div class="tab-pane" id="tab3">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Contextura</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>Delgada</td>
						  <td><?php $conts=Profile::model()->countXcontextura(); if(!isset($conts[1]))$conts[1]=0; echo $conts[1];?></td>
						  <td><?php echo round($conts[1]*$conts[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Media</td>
						  <td><?php if(!isset($conts[2]))$conts[2]=0; echo $conts[2];?></td>
						  <td><?php echo round($conts[2]*$conts[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Gruesa</td>
						  <td><?php if(!isset($conts[4]))$conts[4]=0; echo $conts[4];?></td>
						  <td><?php echo round($conts[4]*$conts[0],2)?>%</td>
						</tr>
						<tr> 
						  <td>Muy Gruesa</td>
						  <td><?php if(!isset($conts[8]))$conts[8]=0; echo $conts[8];?></td>
						  <td><?php echo round($conts[8]*$conts[0],2)?>%</td>
						</tr>
					</table>
		        </div>
		        <div class="tab-pane" id="tab4">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Cabello</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>Rubio</td>
						  <td><?php $pelo=Profile::model()->countXpelo(); if(!isset($pelo[1]))$pelo[1]=0; echo $pelo[1];?></td>
						  <td><?php echo round($pelo[1]*$pelo[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Castaño Claro</td>
						  <td><?php if(!isset($pelo[2]))$pelo[2]=0; echo $pelo[2];?></td>
						  <td><?php echo round($pelo[2]*$pelo[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Castaño Oscuro</td>
						  <td><?php if(!isset($pelo[4]))$pelo[4]=0; echo $pelo[4];?></td>
						  <td><?php echo round($pelo[4]*$pelo[0],2)?>%</td>
						</tr>
						<tr> 
						  <td>Negro</td>
						  <td><?php if(!isset($pelo[8]))$pelo[8]=0; echo $pelo[8];?></td>
						  <td><?php echo round($pelo[8]*$pelo[0],2)?>%</td>
						</tr>
						<tr> 
						  <td>Rojo</td>
						  <td><?php if(!isset($pelo[16]))$pelo[16]=0; echo $pelo[16];?></td>
						  <td><?php echo round($pelo[1]*$pelo[16],2)?>%</td>
						</tr>
						<tr> 
						  <td>Blanco</td>
						  <td><?php if(!isset($pelo[32]))$pelo[32]=0; echo $pelo[32];?></td>
						  <td><?php echo round($pelo[1]*$pelo[32],2)?>%</td>
						</tr>												
					</table>
		        </div>
		        <div class="tab-pane" id="tab5">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Color</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>Verdes</td>
						  <td><?php $ojos=Profile::model()->countXojos(); if(!isset($ojos[1]))$ojos[1]=0; echo $ojos[1];?></td>
						  <td><?php echo round($ojos[1]*$ojos[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Azul</td>
						  <td><?php if(!isset($ojos[2]))$ojos[2]=0; echo $ojos[2];?></td>
						  <td><?php echo round($ojos[2]*$ojos[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Ambar</td>
						  <td><?php if(!isset($ojos[4]))$ojos[4]=0; echo $ojos[4];?></td>
						  <td><?php echo round($ojos[4]*$ojos[0],2)?>%</td>
						</tr>
						<tr> 
						  <td>Marrón</td>
						  <td><?php if(!isset($ojos[8]))$ojos[8]=0; echo $ojos[8];?></td>
						  <td><?php echo round($ojos[8]*$ojos[0],2)?>%</td>
						</tr>
						<tr> 
						  <td>Gris</td>
						  <td><?php if(!isset($ojos[16]))$ojos[16]=0; echo $ojos[16];?></td>
						  <td><?php echo round($ojos[1]*$ojos[16],2)?>%</td>
						</tr>
						<tr> 
						  <td>Negro</td>
						  <td><?php if(!isset($ojos[32]))$ojos[32]=0; echo $ojos[32];?></td>
						  <td><?php echo round($ojos[32]*$ojos[0],2)?>%</td>
						</tr>												
					</table>		        	
		        </div>
		        <div class="tab-pane" id="tab6">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Tono de Piel</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>Blanca</td>
						  <td><?php $piel=Profile::model()->countXpiel(); if(!isset($piel[1]))$piel[1]=0; echo $piel[1];?></td>
						  <td><?php echo round($piel[1]*$piel[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Morena</td>
						  <td><?php if(!isset($piel[2]))$piel[2]=0; echo $piel[2];?></td>
						  <td><?php echo round($piel[2]*$piel[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Mulata</td>
						  <td><?php if(!isset($piel[4]))$piel[4]=0; echo $piel[4];?></td>
						  <td><?php echo round($piel[4]*$piel[0],2)?>%</td>
						</tr>												
					</table>
		        </div>	
		        <div class="tab-pane" id="tab7">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Tipo</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>Rectangular</td>
						  <td><?php $cuerpo=Profile::model()->countXcuerpo(); 
						  if(!isset($cuerpo[1]))$cuerpo[1]=0;echo $cuerpo[1];?></td>
						  <td><?php echo round($cuerpo[1]*$cuerpo[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Reloj Arena</td>
						  <td><?php if(!isset($cuerpo[2]))$cuerpo[2]=0;echo $cuerpo[2];?></td>
						  <td><?php echo round($cuerpo[2]*$cuerpo[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Triángulo</td>
						  <td><?php if(!isset($cuerpo[4]))$cuerpo[4]=0;echo $cuerpo[4];?></td>
						  <td><?php echo round($cuerpo[4]*$cuerpo[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Triángulo Invertido</td>
						  <td><?php if(!isset($cuerpo[8]))$cuerpo[8]=0;echo $cuerpo[8];?></td>
						  <td><?php echo round($cuerpo[8]*$cuerpo[0],2)?>%</td>
						</tr>																			
					</table>
		        </div>	
		        <div class="tab-pane" id="tab8">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Género</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
						  <td>Mujeres</td>
						  <td><?php $genero=Profile::model()->countXgenero(); 
						  if(!isset($genero[1]))$genero[1]=0;echo $genero[1];?></td>
						  <td><?php echo round($genero[1]*$genero[0],2)?>%</td>
						</tr>
						<tr>
						  <td>Hombres</td>
						  <td><?php if(!isset($genero[2]))$genero[2]=0;echo $genero[2];?></td>
						  <td><?php echo round($genero[2]*$genero[0],2)?>%</td>
						</tr>
																								
					</table>
		        </div>
		        <div class="tab-pane" id="tab9">
					<table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
						<tr>
						  <th scope="col">Edades</th>
						  <th scope="col">Cantidad de Usuarios</th>
						  <th scope="col">% Usuarios</th>
						</tr>
						<tr>
							<?php 
							$edades=Profile::model()->countxedad();
							$porcedad=100/$edades[0];
							unset($edades[0]);
							foreach($edades as $edad){
								echo"<tr><td>Entre ".$edad['edad1']." y ".$edad['edad2']." Años </td>
								<td>".$edad['total']."</td><td>".round($edad['total']*$porcedad,2)."%</td></tr>";
								
							}
						  
				
						  ?></td>
						 
																								
					</table>
		        </div>			                		        
		    </div>
        </div>
      </div>
      <h2 class="braker_bottom margin_bottom_small margin_top">Últimos usuarios registrados</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Clientes</a></li>
        <li><a data-toggle="tab" href="#tab2">Personal Shoppers</a></li>
        <li><a data-toggle="tab" href="#tab3">Administradores</a></li>
        <li><a data-toggle="tab" href="#tab4">Aplicantes a PS</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab1">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Numero de Pedidos</th>
              <th scope="col">Promedio de Pedidos</th>
              <th scope="col">Total de Pedidos</th>
            </tr>
            <?php
            $last3=User::model()->getLast3("Client");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
            	$T=Orden::model()->countOrdersByUser($last); 
            	echo "<td>".$T." Bs.</td>";
				if($T>0)
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(round(Orden::model()->getPurchasedByUser($last)/Orden::model()->countOrdersByUser($last),2))." Bs</td>";
				else
					echo "<td>0</td>";
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(Orden::model()->getPurchasedByUser($last))." Bs.</td></tr>";
            	
            }
            ?>
            
          </table>
        </div>
        <div class="tab-pane" id="tab2">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre del PS</th>
              <th scope="col">Numero de Pedidos</th>
              <th scope="col">Promedio de Pedidos</th>
              <th scope="col">Total de Pedidos</th>
            </tr>
            <?php
            $last3=User::model()->getLast3("PS");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
            	$T=Orden::model()->countOrdersByUser($last); 
            	echo "<td>".$T." Bs.</td>";
				if($T>0)
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(round(Orden::model()->getPurchasedByUser($last)/Orden::model()->countOrdersByUser($last),2))." Bs</td>";
				else
					echo "<td>0</td>";
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(Orden::model()->getPurchasedByUser($last))." Bs.</td></tr>";
            	
            }
            ?>
          </table>
        </div>
        <div class="tab-pane" id="tab3">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Administrador</th>
              <th scope="col">Numero de Pedidos</th>
              <th scope="col">Promedio de Pedidos</th>
              <th scope="col">Total de Pedidos</th>
            </tr>
            <?php
            $last3=User::model()->getLast3("Admin");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
            	$T=Orden::model()->countOrdersByUser($last); 
            	echo "<td>".$T." Bs.</td>";
				if($T>0)
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(round(Orden::model()->getPurchasedByUser($last)/Orden::model()->countOrdersByUser($last),2))." Bs</td>";
				else
					echo "<td>0</td>";
            	echo "<td>".Yii::app()->numberFormatter->formatDecimal(Orden::model()->getPurchasedByUser($last))." Bs.</td></tr>";
            	
            }
            ?>
          </table>
        </div>
        <div class="tab-pane" id="tab4">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Aplicante</th>
              <th scope="col">Fecha de Registro</th>
              
            </tr>
            <?php
            $last3=User::model()->getLast3("App");
            foreach($last3 as $last){
            	echo " <tr><td><a href='#' title='Ver perfil'>".Profile::model()->getNombre($last)."</a></td>";
				echo " <td>".User::model()->getCreate_at($last)."</td>";           	
            	
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->