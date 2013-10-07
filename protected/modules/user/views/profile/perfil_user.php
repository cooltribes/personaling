<?php 
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
?>
<div class="container margin_top tu_perfil">
  <div class="page-header">
    <h1><?php echo $model->profile->first_name.' '.$model->profile->last_name; ?></h1>
  </div>
  <div class="row">
    
    <aside class="span3">
      <div class="card">
      	<?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); //imagen ?>	
        
        <div class="card_content vcard">
          <h4 class="fn"><?php echo $model->profile->first_name.' '.$model->profile->last_name; ?></h4>          
          <p class="muted">Miembro desde: <?php echo date("d/m/Y",strtotime($model->create_at)); ?></p>
          
        </div>
      </div>
      <hr/>
      <h5>Actividad</h5>
      <aside class="card">      	
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $datalooks->getTotalItemCount(); ?></span>
          <p>Looks que te encantan</p>
        </div>
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $dataprods->getTotalItemCount(); ?></span>
          <p>Productos que te encantan</p>
        </div>
        <hr/>
      </aside>
        
    </aside>
      
    <div class="span9 "> 
      <div class="well">
        <h3 class="muted margin_bottom_small">Looks que te Encantan</h3>
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

            $this->widget('zii.widgets.CListView', array(
                'id' => 'list-looks',
                'dataProvider' => $datalooks,
                'itemView' => '_datoslooks',
                'afterAjaxUpdate' => " function(id, data) {
                                                        } ",
                'template' => $template,
            ));
            ?>
	 <!-- Perfil looks  --> 
        
      
        
      <div class="well">
        <h3 class="muted margin_bottom_small">Productos que te Encantan</h3>
        <div class="items row-fluid tienda_productos">        	
 	<?php
        //exit();
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
		));   
	?>


        </div>
        
        
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
