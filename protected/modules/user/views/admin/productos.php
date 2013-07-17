<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>9)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend>Productos Favoritos</legend>
            <?php
			$template = '{summary}
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <tbody>
			    <tr>
			      <th scope="col" width="10%">Imagen</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Categoria</th>
                  
                  <th scope="col" width="10%"></th>
			    </tr>
			    {items}
				</tbody>
			    </table>
			    {pager}
				';
			
					$this->widget('zii.widgets.CListView', array(
				    'id'=>'list-productos',
				    'dataProvider'=>$dataProvider,
				    'itemView'=>'_view_producto',
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
  </div>
</div>
<!-- /container -->
