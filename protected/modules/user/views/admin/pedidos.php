<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>6)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend>Pedidos</legend>
            
            <?php
			$template = '{summary}
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered table-hover table-striped">
			  <tbody>
			    <tr>
			      <th scope="col">Fecha</th>
                  <th scope="col">Monto</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Método de pago</th>
                  <th scope="col">Acciones</th>
			    </tr>
			    {items}
				</tbody>
			    </table>
			    {pager}
				';
			
					$this->widget('zii.widgets.CListView', array(
				    'id'=>'list-pedidos',
				    'dataProvider'=>$dataProvider,
				    'itemView'=>'_view_pedido',
				    'template'=>$template,
				    'enableSorting'=>'true',
				    'afterAjaxUpdate'=>" function(id, data) {
										} ",
					'pager'=>array(
						'header'=>'',
						'htmlOptions'=>array(
						'class'=>'pagination pagination-right',
					)
					),					
				));    
				?>
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR OFF --> 
        <script > 
			// Script para dejar el sidebar fijo Parte 1
			function moveScroller() {
				var move = function() {
					var st = $(window).scrollTop();
					var ot = $("#scroller-anchor").offset().top;
					var s = $("#scroller");
					if(st > ot) {
						s.css({
							position: "fixed",
							top: "70px"
						});
					} else {
						if(st <= ot) {
							s.css({
								position: "relative",
								top: "0"
							});
						}
					}
				};
				$(window).scroll(move);
				move();
			}
		</script>
        <div>
          <div id="scroller-anchor"></div>
          <div id="scroller">
                  <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
            <ul class="nav nav-stacked nav-tabs margin_top">
                  <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
                  <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
                  <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
            </ul>
          </div>
        </div>
        <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });
		</script> 
        <!-- SIDEBAR OFF --> 
      
      
      
       
      </div>
    </div>
  </div>
</div>
<!-- /container -->
