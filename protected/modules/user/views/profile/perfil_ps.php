<div class="container margin_top tu_perfil">
  <div class="page-header">
    <h1>Perfil</h1>
  </div>
  <div class="row">
    <aside class="span3">
      <div class="card">
      	<?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); //imagen ?>	
        
        <div class="card_content vcard">
          <h4 class="fn"><?php echo $model->profile->first_name.' '.$model->profile->last_name; ?></h4>
          <p><strong>Bio</strong>: <?php echo $model->profile->bio; ?> </p>
          <p class="muted">Miembro desde: <?php echo date("d/m/Y",strtotime($model->create_at)); ?></p>
          <?php /*?>
	   ----------------------------------------------------------------------------------------------
		  NOTA:   Boton de Seguir al PS que sera implementado en futuras versiones	
	   ----------------------------------------------------------------------------------------------
		  <a href="#" class="btn btn-success" title="seguir"><i class="icon-plus-sign icon-white"></i> Seguir</a><?php */?>
        </div>
      </div>
      <hr/>
      <h5>Actividad</h5>
      <aside class="card">
      	<?php
      		
			$looktotales = Look::model()->countByAttributes(array('user_id'=>$model->id));
      		
			$looks = Look::model()->findAllByAttributes(array('user_id'=>$model->id));
			$productos = Array();
			
			foreach($looks as $cada)
			{
				$xd = LookHasProducto::model()->findAllByAttributes(array('look_id'=>$cada->id));
				
				foreach($xd as $prod)
				{
					if(in_array($prod->producto_id, $productos)){
					}
					else{
						array_push($productos,$prod->producto_id);
					}
				}
				
			}
			
      	?>
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looktotales; ?></span>
          <p>Looks creados</p>
        </div>
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo count($productos); ?></span>
          <p>Productos usados</p>
        </div>
        <hr/>
      </aside>
      <?php /*?>
	   ----------------------------------------------------------------------------------------------
		  NOTA: Sidebar con marcas preferidas y seguidores que será implementado en futuras versiones
	   ----------------------------------------------------------------------------------------------
      <h5>Marcas Preferidas</h5>
      <div class="card padding_xsmall">
        <ul class="row-fluid no_margin_left no_margin_bottom">
          <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
          <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
          <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
          <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
          <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
          <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
        </ul>
      </div>
      <hr/>
      <h5>Seguid@s</h5>
      <div class="card padding_xsmall no_margin_left no_margin_bottom">
        <div class="row-fluid">
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>
          <div class="span4"><a href="#" title="Nombre del usuario"><img width="84" alt="Avatar de nombre del usuario" src="http://www.personaling.com/site/images/avatar_provisional_3.jpg" class=" img-circle"></a></div>

        </div>
      </div>
      <hr/><?php */?>
    </aside>
    <div class="span9 "> <img src="http://placehold.it/87	0x90" alt="Banner de Nombre del Personal Shopper"/>
      <div class="well margin_top">
        <h3 class="muted margin_bottom_small">Looks Actuales</h3>
        <div class="row-fluid items" id="perfil_looks">
<?php

	$template = ' 
       {items}
	   </div>
	   </div>
	   <div class="clearfix">
        <div class="pull-right">
      		{pager}
		</div>
		</div>
		
    ';
	
	$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-looks',
	    'dataProvider'=>$datalooks,
	    'itemView'=>'_datoslooks',
	    'afterAjaxUpdate'=>" function(id, data) {
						} ",
	    'template'=>$template,
	));   
	?>
	

      
      <div class="well">
        <h3 class="muted margin_bottom_small">Productos Recomendados</h3>
        <div class="items row-fluid tienda_productos">
        	
 	<?php

		$template2 = ' 
	       {items}
		   </div>

		   <div class="clearfix">
	        <div class="pull-right">
	      		{pager}
			</div>
			</div>
			
	    ';
		
		$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-prods',
		    'dataProvider'=>$dataprods,
		    'itemView'=>'_datosprod',
		    'afterAjaxUpdate'=>" function(id, data) {
						
					$(document).ready(function() {
  
						var imag;
						var original;
						var segunda;

						$('.producto').hover(function(){		
							if ($(this).find('img').length > 1){
								$(this).find('img').eq(0).hide();
		
								$(this).find('img').eq(0).next().show();
							}
						},function(){
							if ($(this).find('img').length > 1){
								$(this).find('img').eq(0).show();
		
								$(this).find('img').eq(0).next().hide();
							}
						});
	
				});


			function encantar(id)
   			{
   				var idProd = id;

   			
   				$.ajax({
			        type: 'post',
			        url: '<?php echo Yii::app()->baseUrl; ?>/producto/encantar', // action Tallas de Producto
			        data: { 'idProd':idProd}, 
			        success: function (data) {
				
						if(data=='ok')
						{					
							var a = '♥';
						
							//$('#meEncanta').removeClass('btn-link');
							$('a#like'+id).addClass('like-active');
							$('a#like'+id).text(a);
						
						}
					
						if(data=='no'){
							alert('Debes ingresar con tu cuenta de usuario o registrarte antes de dar Me Encanta a un producto');
						}
					
						if(data=='borrado')
						{
							var a = '♡';
							
							$('a#like'+id).removeClass('like-active');
							$('a#like'+id).text(a);
						}
					
	       			}//success
	       		})
   		
   		}	 
				
							} ",
		    'template'=>$template2,
		));   
	?>
      <!--  	
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/1/87.jpg" id="img-1" class="img_hover"><img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/1/88.jpg" style="display:none" class="img_hover_out"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Blusa Roja " href="../producto/detalle/1">Blusa Roja </a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/1">ðŸ”</a></header>
              <span class="precio">Bs. 200</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(1)" id="like1">â™¡</a></div>
          </article>
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/10/75.jpg" id="img-10" class="img_hover" style="display: inline;"><img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/10/76.jpg" style="display: none;" class="img_hover_out"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Jeans prelavado" href="../producto/detalle/10">Jeans prelavado</a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/10">ðŸ”</a></header>
              <span class="precio">Bs. 2.500</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(10)" id="like10">â™¡</a></div>
          </article>
-->

      </div>
    </div>
  </div>
</div>

    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

	<?php $this->endWidget(); ?>

<!-- /container --> 


<script>

$(document).ready(function() {
  // Handler for .ready() called.
  
	var imag;
	var original;
	var segunda;

	$('.producto').hover(function(){		
		if ($(this).find("img").length > 1){
		$(this).find("img").eq(0).hide();
		
		$(this).find("img").eq(0).next().show();
		}
	},function(){
		if ($(this).find("img").length > 1){
		$(this).find("img").eq(0).show();
		
		$(this).find("img").eq(0).next().hide();
		}
	});
	
});


function encantar(id)
   	{
   		var idProd = id;
   		//alert("id:"+idProd);		
   		
   		$.ajax({
	        type: "post",
	        url: "<?php echo Yii::app()->baseUrl; ?>/producto/encantar", // action Tallas de Producto
	        data: { 'idProd':idProd}, 
	        success: function (data) {
				
				if(data=="ok")
				{					
					var a = "♥";
					
					//$("#meEncanta").removeClass("btn-link");
					$("a#like"+id).addClass("like-active");
					$("a#like"+id).text(a);
					
				}
				
				if(data=="no")
				{
					alert("Debes ingresar con tu cuenta de usuario o registrarte antes de dar Me Encanta a un producto");
					//window.location="../../user/login";
				}
				
				if(data=="borrado")
				{
					var a = "♡";
					
					//alert("borrando");
					
					$("a#like"+id).removeClass("like-active");
					//$("#meEncanta").addClass("btn-link-active");
					$("a#like"+id).text(a);

				}
					
	       	}//success
	       })
   		
   		
   	}  
   	

	
</script>