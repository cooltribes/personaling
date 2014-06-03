<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Looks</h1>
  </div>
     <!-- SUBMENU ON -->
  
  <div class="navbar margin_top">
  <div class="navbar-inner">
    <ul class="nav">
  	<li><a href="#" class="nav-header">CATALOGO DE:</a></li>
      	<li class="active" ><a title="Looks" href="">Looks</a></li>
      	<li><a title="Productos" href="<?php echo Yii::app()->baseUrl."/controlpanel/productos"; ?>">Productos</a></li>
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
                            $this->Widget('ext.highcharts.HighchartsWidget', array(
                                       'options'=>array(
                                          'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
                                          'title' => array('text' => 'Estados de Looks en el último mes'),
                                          'xAxis' => array(
                                             'categories' => $datesM,
                                          ),
                                          'yAxis' => array(
                                             'title' => array('text' => 'Looks')
                                          ),
                                          'series' => array(                                                    
                                            // array('name' => 'Creados', 'data' => array($monthago,$ahora)),
                                             array('name' => 'Creados', 'data' => $mes[0]),
                                             array('name' => 'Enviados', 'data' => $mes[1]),
                                             array('name' => 'Enviados', 'data' => $mes[2])
                                          ),
                                          'credits' => array('enabled' => false),
                                       ),

                                    ));


                            ?>
        		</div>
              </div>
              
              <div class="tab-pane" id="semana">
                <div class="clearfix">
					<?php
                                        $this->Widget('ext.highcharts.HighchartsWidget', array(
							'options'=>array(
								'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
								'title' => array('text' => 'Estados de Looks en las últimas 4 semanas'),
								'xAxis' => array(
									'categories' => $datesW
									),
								'yAxis' => array(
										'title' => array('text' => 'Looks')
									),
								'series' => array(
										array('name' => 'Creados', 'data' => $semana[0]),
                                                                                array('name' => 'Enviados', 'data' => $semana[1]),
                                                                                array('name' => 'Aprobados', 'data' => $semana[2]),
									),
                                                             'credits' => array('enabled' => false),
							)
						));
						
						
						?>
              	</div>
              </div>
              
              <div class="tab-pane" id="dia">
	            <div class="clearfix">
	            	<?php
					                                        
                                        $this->Widget('ext.highcharts.HighchartsWidget', array(
							'options'=>array(
								'chart' => array('type' =>'areaspline','width'=>1100), // column, area, line, spline, areaspline, bar, pie, scatter
								'title' => array('text' => 'Estados de Looks en los últimos 30 días'),
								'xAxis' => array(
									'categories' => $datesD
									),
								'yAxis' => array(
										'title' => array('text' => 'Looks')
									),
								'series' => array(
										array('name' => 'Creados', 'data' => $dia[0]),
                                                                                array('name' => 'Enviados', 'data' => $dia[1]),
                                                                                array('name' => 'Aprobados', 'data' => $dia[2]),
									),
                                                             'credits' => array('enabled' => false),
							)
						));
						
						
						
						
						
					?>
	            </div>
	      </div>
	          
            </div>
      </div>
      
      <h2 class="braker_bottom margin_bottom_small">Looks</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Número de visitas</a></li>
        <li><a data-toggle="tab" href="#tab2">Status</a></li>
        
      </ul>
      <div class="tab-content">
      
        <div class="tab-pane active" id="tab1" >
            <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">Nombre del Look</th>
                <th scope="col">Número de visitas</th>
                <th scope="col">Cantidad vendida</th>
                <th scope="col">Total de ventas</th>
              </tr>

          <?php
                 
          foreach($views->getData() as $record) {
                  if (isset($record)){
          ?>
                    <tr>
                        <td><a href="<?php echo $record->getUrl(); ?>" title="Ver Look"><?php echo $record->title; ?></a></td>
                        <td><?php echo $record->view_counter; ?></td>
                        <td><?php echo $record->getCantVendidos(); ?></td>
                        <td><?php echo Yii::t('contentForm','currSym').' '.$record->getTotalVentas(); ?></td>
                    </tr>
          <?php
                  }
          }
          ?>  

          </table>
        </div>
              
        <div class="tab-pane" id="tab2">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">Status</th>
                <th scope="col">Cantidad de looks</th>
                <th scope="col">% de Looks</th>
              </tr>	
            <?php
                foreach($status as $record) {
                    if (isset($record)){
            ?>      
                <tr>
                  <td><?php echo $record['nombre']; ?></td>
                  <td><?php echo $record['total']; ?></td>
                  <td><div class="pull-right margin_left_small"><?php echo round($record['porcentaje'], 2); ?> % 
                    </div><div class="progress progress-danger margin_bottom_xsmall">
                      <div class="bar" style="width: <?php echo (int)$record['porcentaje']; ?>%;"></div>
                    </div>
                  </td>
                  
                </tr>
           <?php      
                     }
                 }
           ?>     
            </table>
        </div>

       
      </div>
    </div>
  </div>
</div>
<!-- /container -->