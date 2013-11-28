<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Productos</h1>
  </div>
     <!-- SUBMENU ON -->
  
  <div class="navbar margin_top">
  <div class="navbar-inner">
    <ul class="nav">
  	<li><a href="#" class="nav-header">CATALOGO DE</a></li>
      	<li><a title="Looks" href="<?php echo Yii::app()->baseUrl."/controlpanel/looks"; ?>">Looks</a></li>
      	<li class="active" ><a title="Productos" href="">Productos</a></li>
    </ul>
  </div>
</div>
 

  
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span12">
      
      
      <h2 class="braker_bottom margin_bottom_small">Productos</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Número de visitas</a></li>
<!--        <li><a data-toggle="tab" href="#tab2">Status</a></li>-->
        
      </ul>
      <div class="tab-content">
      
        <div class="tab-pane active" id="tab1" >
            <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">Nombre del Producto</th>
                <th scope="col">Número de visitas</th>
                <th scope="col">Cantidad vendida</th>
                <th scope="col">Total de ventas</th>
              </tr>

          <?php
                 
          foreach($views->getData() as $record) {
                  if (isset($record)){
          ?>
                    <tr>
                        <td><a href="<?php echo $record->getUrl(); ?>" title="Ver Producto"><?php echo $record->nombre; ?></a></td>
                        <td><?php echo $record->view_counter; ?></td>
                        <td><?php echo $record->getCantVendidos(); ?></td>
                        <td>Bs. <?php echo $record->getTotalVentas(); ?></td>
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