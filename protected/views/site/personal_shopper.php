
<?php
		$this->pageTitle=Yii::app()->name . ' - Tu Personal Shopper';
		/* @var $this TiendaController */
		//
		$this->breadcrumbs=array(
			'Tu Personal Shopper',
		);
?>
<?php  
  $baseUrl = Yii::app()->baseUrl;
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/slider.js');
  //$cs->registerCssFile($baseUrl.'/css/yourcss.css');
?><div class="page-header ">
      <h1>Looks recomendados para ti</h1>
</div>
  <div class="row">
      
      <!-- Carousel items -->
    <div id="carousel_looks_recomendados" class="carousel slide ">

       
     <div class="carousel-inner">

          <?php          	
        /*    	
		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_look', 
'template'=>"{items}",

		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array( 
			'class'=>'pagination pagination-right',
		)
		),					
	));    */
	?>
          <div id="list-auth-items" class="list-view">
            <div id="b" class="items">
              <?php
 foreach($dataProvider->getData() as $record) {
 	
 ?>
              <?php	
	$look = Look::model()->findByPk($record['id']);
	//echo  $record['id'];
	//echo Yii::app()->user->id;
	if($look->matchOcaciones(User::model()->findByPk(Yii::app()->user->id))){
		
?>
              <div class="span4">
                <article class="item" >
					<?php echo CHtml::image(Yii::app()->baseUrl .'/images/loading.gif','Loading',array('id'=>"imgloading".$look->id)); ?>                            	
                  	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')), "Look", array("style"=>"display: none","id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'')); ?>
                  
                  	<?php echo CHtml::link($image,array('look/view', 'id'=>$look->id)); ?>
                  	<?php
                    //"style"=>"display: none",              	
                        /*
                        $script = "$('#"."imglook".$look->id."').load(function(){
									//alert('cargo');
									$('#imgloading".$look->id."').hide();
									$(this).show();
									//$('#loader_img').hide();
						});";
						 * 
						 */
						 $script = "
							var load_handler = function() {
							    $('#imgloading".$look->id."').hide();
							    $(this).show();
							}
							$('#"."imglook".$look->id."').filter(function() {
							    return this.complete;
							}).each(load_handler).end().load(load_handler);						 
						 ";
						 
  						Yii::app()->clientScript->registerScript('img_ps_script'.$look->id,$script);
  					?>
                  <div class="hidden-phone margin_top_small vcard row-fluid">
                    <div class="span2 avatar ">
                    	<a href="<?php echo $look->user->profile->getUrl(); ?>">
                    	<?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?>
                    	</a>
                    </div>
                    <div class="span4"> <span class="muted">Look creado por: </span>
                      <h5>
                      	
                      	<?php echo CHtml::link('<span class="fn">'.$look->user->profile->getNombre().'</span>',$look->user->profile->getUrl()); ?>
                      	</h5>
                    </div>
                    <div class="span6"><span class="precio"> <small>Bs.</small> <?php echo $look->getPrecio(true); ?></span></div>
                  </div>
                  <div class="share_like">
          <button id="meEncanta<?php echo $look->id; ?>" onclick='encantar(<?php echo $look->id; ?>)' title="Me encanta" class="btn-link <?php echo $look->meEncanta()?"btn-link-active":""; ?>">
          	<span id="like<?php echo $look->id; ?>" class="entypo icon_personaling_big"><?php echo $look->meEncanta()?"♥":"♡"; ?></span>
          </button>
                    <div class="btn-group">
                      <button class="dropdown-toggle btn-link" data-toggle="dropdown"><span class="entypo icon_personaling_big"></span></button>
                      <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                        <!-- AddThis Button BEGIN -->
                        
                        <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                        <li><a class="addthis_button_tweet"></a></li>
                        <li><a class="addthis_button_pinterest_pinit"></a></li>
                      </ul>
                      <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                      <!-- AddThis Button END --> 
                      
                    </div>
                  </div>
                  <span class="label label-important">Promoción</span> </article>
              </div>
              <?php } ?>
            
              <?php } ?>
            </div>
          </div>
        </div>

        <!-- Carousel nav --> 
        <a class="carousel-control left margin_top_small margin_left_xsmall_minus bx-prev" href="#carousel_looks_recomendados" data-slide="prev">&lsaquo;</a> 
        <a class="carousel-control right margin_top_small  margin_right_xsmall_minus bx-next" href="#carousel_looks_recomendados" data-slide="next">&rsaquo;</a> 

      </div>

       <div class="row"><div class="padding_xsmall span6 offset3"> 
        <a class="btn btn-danger btn-block btn-morado-tiffany" href="<?php echo Yii::app()->getBaseUrl(); ?>/tienda/look" >Ver todos los looks <i class="icon-chevron-right icon-white"></i> </a>
       </div>

      </div>
      <div class="braker_horz_top_1 hidden-phone">
        <div class="row">
          <div class="span6">
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/banner_blanco.jpg" width="571" height="75" alt="Banner blanco" /> 
          </div>
          <div class="span6">

            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/banner_blanco.jpg" width="571" height="75" alt="Banner blanco" /> 
          </div>
        </div>
      </div>
   </div>
</div>
<script>
	       function encantar(idLook)
       {
           //var idLook = $("#idLook").attr("value");
           //alert("id:"+idLook);

           $.ajax({
            type: "post",
            url: "<?php echo $this->createUrl("look/encantar"); ?>", // action Tallas de look
            data: { 'idLook':idLook},
            success: function (data) {

                if(data=="ok")
                {
                    var a = "♥";

                    //$("#meEncanta").removeClass("btn-link");
                    $("#meEncanta"+idLook).addClass("btn-link-active");
                    $("span#like"+idLook).text(a);

                }

                if(data=="no")
                {
                    alert("Debe primero ingresar como usuario");
                    //window.location="../../user/login";
                }

                if(data=="borrado")
                {
                    var a = "♡";

                    //alert("borrando");

                    $("#meEncanta"+idLook).removeClass("btn-link-active");
                    $("span#like"+idLook).text(a);

                }

               }//success
           })


       }
</script>
<!------------------- DETECT BROWSER -----------------> 
<style>
    body .buorg{
        position: absolute;
        z-index: 111111;
        width: 100%;
        top: 0px;
        left: 0px;
        border-bottom: 1px solid #A29330;
        background: #FDF2AB;
        text-align: left;
        cursor: pointer;
        font-family: Arial,Helvetica,sans-serif;
        color: #000;
        font-size: 12px;
    }
    body .buorg div {
        padding: 15px 36px 15px 10px;
    }
    body .buorg div i{
       margin: 0px 20px;
    }
    
    body #buorgclose {
        position: absolute;
        right: 1.5em;
        top: 1em;
        height: 20px;
        width: 19px;
        padding-left: 12px;
        font-weight: bold;
        font-size: 14px;
        padding: 0;
    }
    
</style>
<script type="text/javascript"> 
    var $buoop = {
        vs: {i:9,f:21,o:15,s:3,n:19},
        test: false,
        reminder: 0.1,  //horas para recordatorio                 
        text: "Tu navegador (%s) <b>no soporta</b> las funcionalidades de ésta página. \n\
            Es posible que algunas características para crear un look <b>no funcionen correctamente</b>. Puedes\n\
            <b>continuar bajo tu riesgo</b> o <a %s >Actualizar tu navegador</a>",                       
        newwindow: true,
        //url: "youtube",
       
    };
    
    $buoop.ol = window.onload; 
    
    window.onload=function(){ 
     try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
     var e = document.createElement("script"); 
     e.setAttribute("type", "text/javascript"); 
     e.setAttribute("src", "<?php echo Yii::app()->baseUrl . "/js/updateBrowser.js"; ?>"); 
     document.body.appendChild(e); 
    } 
    
</script>
