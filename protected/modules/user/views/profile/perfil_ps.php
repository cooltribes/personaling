<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");?>
<div class="container margin_top tu_perfil">
 <!-- <div class="page-header">
    <h1>Perfil</h1>
  </div>-->
  <div class="row">
    <aside class="span3">
      <div class="card">
      	<?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); //imagen 	
        
          //Metas de Twitter CARD ON

          Yii::app()->clientScript->registerMetaTag('summary', 'twitter:card', null, null, null);
          Yii::app()->clientScript->registerMetaTag('@personaling', 'twitter:site', null, null, null);
          Yii::app()->clientScript->registerMetaTag($model->profile->first_name." ".$model->profile->last_name." - Perfil", 'twitter:title', null, null, null);
          Yii::app()->clientScript->registerMetaTag($model->profile->bio, 'twitter:description', null, null, null);
          Yii::app()->clientScript->registerMetaTag('personaling.com', 'twitter:domain', null, null, null);
          Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$model->getAvatar(), 'twitter:image', null, null, null);
          //Metas de Twitter CARD OFF

          //Metas de Facebook CARD ON
          	Yii::app()->clientScript->registerMetaTag($model->profile->first_name." ".$model->profile->last_name." - Perfil", null, null, array('property' => 'og:title'), null);
			Yii::app()->clientScript->registerMetaTag($model->profile->bio, null, null, array('property' => 'og:description'), null);
  			Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  			Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  			Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$model->getAvatar(), 'og:image', null, null, null);

  			//Metas de Facebook CARD OFF
        ?>        
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

<?php 

$sql = "select count(*) as cant, d.id, d.nombre from tbl_look a, tbl_look_has_producto b, tbl_producto c, tbl_marca d where a.user_id=".$model->id." and a.id = b.look_id and b.producto_id = c.id and d.id = c.marca_id and d.padreId = 0 group by d.id order by cant DESC";

	$marcas = new CSqlDataProvider($sql, array(
		    'TotalItemCount'=>6,
		     'pagination'=>array(
				'pageSize'=>6,
			),		    
		));  

?>

      <h5>Marcas Preferidas</h5>
      <div class="card padding_xsmall">
        <ul class="row-fluid no_margin_left no_margin_bottom">
        	
        <?php
        foreach($marcas->getData() as $cadauna) {
        	
        	$marca = Marca::model()->findByPk($cadauna['id']); // Look::model()->findByPk($record['look_id']);
			$ima = CHtml::image(Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/marca/'.$marca->id.'_thumb.jpg', $marca->nombre, array('width'=>84, 'height'=>84));
 			
        
        	 echo '<li class="span4">'.$ima.'</li>'; 
          // <img width="84" alt="'.$marca->nombre.'" src="http://placehold.it/90">
        }
        // <li class="span4"><img width="84" alt="Nombre del usuario" src="http://placehold.it/90"></li>
        ?>	
          
        </ul>
      </div>
      <hr/>
	   
	   <?php /*?>
	    * 
	    * ----------------------------------------------------------------------------------------------
		  NOTA: Sidebar con marcas preferidas y seguidores que será implementado en futuras versiones
	   ----------------------------------------------------------------------------------------------
	    * 
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
    <div class="span9 "> 
    	
    	<?php echo CHtml::image($model->getBanner(),'Banner',array("width"=>"870", "height"=>"90")); //imagen ?>
    	
      <div class="well margin_top">
        <h3 class="muted margin_bottom_small">Looks Actuales</h3>
        <div class="row-fluid items" id="perfil_looks">
<?php

	$template = ' 
       {items}
	   </div>
	   </div>
	   <div class="clearfix">
        <div class="list-view">
      		{pager}
		</div>
		</div>
		
    ';
	
	$pagerParams=array(
            'header'=>'',
            'prevPageLabel' => Yii::t('contentForm','Previous'),
            'nextPageLabel' => Yii::t('contentForm','Next'),
            'firstPageLabel'=> Yii::t('contentForm','First'),
            'lastPageLabel'=> Yii::t('contentForm','Last'),
            'htmlOptions'=>array(
                'class'=>'pagination pagination-right'));
	
	$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-looks',
	    'dataProvider'=>$datalooks,
	    'itemView'=>'_datoslooks',
	    'afterAjaxUpdate'=>" function(id, data) {
						} ",
	    'template'=>$template,
	    'pager'=>$pagerParams,
	));   
	?>
	

      
      <div class="well">
        <h3 class="muted margin_bottom_small">Productos Recomendados</h3>
        <div class="items row-fluid tienda_productos">
        	
 	<?php

		$template2 = ' 
	       {items}
		   </div>
		   </div>

		   <div class="clearfix">
	        <div class="list-view">
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
		    'pager'=>$pagerParams,
		));   
	?>


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