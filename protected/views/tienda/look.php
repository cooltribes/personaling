
<div class="container">
  <div class="page-header">
    <h1>Todos los looks</h1>
  </div>
</div>

<!-- SUBMENU ON -->

<div class="container" id="scroller-anchor">
  <div class="navbar  nav-inverse" id="scroller">
    <div class="navbar-inner"  >
      <nav class="  ">
        <ul class="nav">
          <li class="filtros-header">Filtrar por:</li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ocasiones <b class="caret"></b></a>
            <ul class="dropdown-menu ">
              <li> <a href="#" title="De fiesta">De fiesta</a> </li>
              <li><a href="#" title="Oficina">Oficina</a> </li>
                <li><a ref="#" title="Haciendo Deporte">Haciendo Deporte </a></li>
              <li><a href="#" title="Diario">Diario</a> </li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Perfil <b class="caret"></b></a>
            <ul class="dropdown-menu ">
              <li><a href="#" title="Para Mama">Para Mamá</a> </li>
                <li><a ref="#" title="Para Tia Alberta">Para Tía Alberta </a></li>
              <li><a href="#" title="Para Maria">Para Maria</a> </li>
                            <li class="divider"> </li>

              <li><a href="Crear_Perfil_Secundario_Usuaria_Mi_Tipo.php" title="Crear nuevo perfil secundario"><i class="icon-plus"></i> Crear un nuevo perfil</a> </li>
            </ul>
          </li>
        </ul>
        <form class="navbar-search pull-right hidden-phone">
          <div class="input-append">
          <?php // Recordar que aqui va el componente Select2 de la extension del Bootstrap para Yii. La misma que esta en Talla y colores del admin ?>
            <input type="text" placeholder="Buscar por Personal Shopper">
            <div class="btn-group">
              <button tabindex="-1" class="btn btn-danger">Buscar</button>
            </div>
          </div>
        </form>
      </nav>
      <!--/.nav-collapse --> 
    </div>
    <div class="navbar-inner sub_menu"  >
    
    <?php //Este submenu carga las categorias segun lo seleccinonado arriba, por ejemplo de fiesta: coctel, familia, etc ?>
      <nav class="  ">
        <ul class="nav">
          <li>
            <label>
              <input type="checkbox">
              Reunion Familiar</label>
          </li>
          <li>
            <label>
              <input type="checkbox">
              Graduacion</label>
          </li>
          <li>
            <label>
              <input type="checkbox">
              Cita Romántica</label>
          </li>
          <li>
            <label>
              <input type="checkbox">
              Boda</label>
          </li>
          <li>
            <label>
              <input type="checkbox">
              Plan de amigas</label>
          </li>
          <li>
            <label>
              <input type="checkbox">
              Coctel </label>
          </li>
        </ul>
      </nav>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>

<!-- SUBMENU OFF -->

<div class="container" id="tienda_looks">
  <div class="row" id="looks">
  	
	
	<?php foreach($looks as $look): ?>

<div class="span4 look">
      <article > 
      	<?php echo CHtml::image('../images/loading.gif','Loading',array('id'=>"imgloading".$look->id)); ?>                            	
                  	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')), "Look", array("style"=>"display: none","id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'')); ?>
                  
                  	<?php echo CHtml::link($image,array('look/view', 'id'=>$look->id)); ?>
                  	<?php
                    //"style"=>"display: none",              	
                        $script = "$('#"."imglook".$look->id."').load(function(){
									//alert('cargo');
									$('#imgloading".$look->id."').hide();
									$(this).show();
									//$('#loader_img').hide();
						});";
  						Yii::app()->clientScript->registerScript('img_ps_script'.$look->id,$script);
  		?>
        <div class="hidden-phone margin_top_small vcard row-fluid">
          <div class="span2  ">
            <div class="avatar"> <?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?> </div>
          </div>
          <div class="span6"> <span class="muted">Look creado por: </span>
            <h5><a href="#" title="profile" class="url"><span class="fn"> <?php echo $look->user->profile->first_name; ?> </span></a></h5>
          </div>
          <div class="span4"><span class="precio"><small>Bs.</small><?php echo $look->getPrecio(); ?></span></div>
        </div>
        <div class="share_like">
          <button class="btn-link" title="Me encanta" href="#"><span class="entypo icon_personaling_big">♡</span></button>
          <div class="btn-group">
            <button data-toggle="dropdown" class="dropdown-toggle btn-link"><span class="entypo icon_personaling_big"></span></button>
            <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
            </ul>
            
            <!-- AddThis Button END --> 
            
          </div>
        </div>
        <span class="label label-important">Promoción</span> </article>
    </div>
    

	
	<?php endforeach; ?>
	</div>
	<?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
	    'contentSelector' => '#looks',
	    'itemSelector' => 'div.look',
	    'loadingText' => 'Loading...',
	    'donetext' => 'This is the end... my only friend, the end',
	    'pages' => $pages,
	)); ?>    
	
    
   
	
  </div>
</div>
<!-- /container -->


<script>
function moveScroller() {
    var move = function() {
        var st = $(window).scrollTop();
        var ot = $("#scroller-anchor").offset().top;
        var s = $("#scroller");
        if(st > ot) {
            s.css({
                position: "fixed",
                top: "60px",
            });
        } else {
            if(st <= ot) {
                s.css({
                    position: "relative",
                    top: ""
                });
            }
        }
    };
    $(window).scroll(move);
    move();
}
</script>
<script type="text/javascript"> 
  $(function() {
    moveScroller();
  });
</script>