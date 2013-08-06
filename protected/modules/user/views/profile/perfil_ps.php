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
	   <div class="clearfix">
        <div class="pagination pull-right">
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
	
 		</div>
      </div>
      
      <div class="well">
        <h3 class="muted margin_bottom_small">Productos Recomendados</h3>
        <div class="items row-fluid tienda_productos">
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
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/11/78.jpg" id="img-11" class="img_hover"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Medias veladas" href="../producto/detalle/11">Medias veladas</a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/11">ðŸ”</a></header>
              <span class="precio">Bs. 150</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(11)" id="like11">â™¡</a></div>
          </article>
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/15/80.jpg" id="img-15" class="img_hover"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Top multicolor" href="../producto/detalle/15">Top multicolor</a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/15">ðŸ”</a></header>
              <span class="precio">Bs. 300</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(15)" id="like15">â™¡</a></div>
          </article>
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/20/93.jpg" id="img-20" class="img_hover" style="display: inline;"><img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/20/94.jpg" style="display: none;" class="img_hover_out"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Tacones de Corcho " href="../producto/detalle/20">Tacones de Corcho </a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/20">ðŸ”</a></header>
              <span class="precio">Bs. 180</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(20)" id="like20">â™¡</a></div>
          </article>
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/24/101.jpg" id="img-24" class="img_hover"><img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/24/102.jpg" style="display:none" class="img_hover_out"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Tshirt" href="../producto/detalle/24">Tshirt</a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/24">ðŸ”</a></header>
              <span class="precio">Bs. 400</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(24)" id="like24">â™¡</a></div>
          </article>
           <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/15/80.jpg" id="img-15" class="img_hover"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Top multicolor" href="../producto/detalle/15">Top multicolor</a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/15">ðŸ"</a></header>
              <span class="precio">Bs. 300</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(15)" id="like15">â™¡</a></div>
          </article>
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/20/93.jpg" id="img-20" class="img_hover" style="display: inline;"><img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/20/94.jpg" style="display: none;" class="img_hover_out"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Tacones de Corcho " href="../producto/detalle/20">Tacones de Corcho </a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/20">ðŸ"</a></header>
              <span class="precio">Bs. 180</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(20)" id="like20">â™¡</a></div>
          </article>
          <article class="span4 item_producto">
            <div class="producto"> <img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/24/101.jpg" id="img-24" class="img_hover"><img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/24/102.jpg" style="display:none" class="img_hover_out"> <a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Tshirt" href="../producto/detalle/24">Tshirt</a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/24">ðŸ"</a></header>
              <span class="precio">Bs. 400</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(24)" id="like24">â™¡</a></div>
          </article>
        </div>
        <div class="clearfix">
          <div class="pagination pull-right">
            <ul>
              <li><a href="#">Prev</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">Next</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /container --> 

<!-------------- MODAL ON ---------------->
<div id="myModal" class="modal hide tienda_modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
    <h3 id="myModalLabel">Nombre del producto</h3>
  </div>
  <div class="modal-body">
    <div class="row-fluid">
      <div class="span7">
        <div class="carousel slide" id="myCarousel">
          <ol class="carousel-indicators">
            <li class="" data-slide-to="0" data-target="#myCarousel"></li>
            <li data-slide-to="1" data-target="#myCarousel" class="active"></li>
            <li data-slide-to="2" data-target="#myCarousel" class=""></li>
          </ol>
          <div class="carousel-inner">
            <div class="item"> <img alt="Nombre del producto" src="http://www.personaling.com/site/images/producto/54/149_orig.jpg" width="450px" height="450px" /> </div>
            <div class="item active"> <img alt="Nombre del producto" src="http://www.personaling.com/site/images/producto/25/129_orig.jpg"  width="450px" height="450px" /> </div>
            <div class="item"> <img alt="Nombre del producto" src="http://www.personaling.com/site/images/producto/15/80.jpg"  width="450px" height="450px" /> </div>
          </div>
          <a data-slide="prev" href="#myCarousel" class="left carousel-control">â€¹</a> <a data-slide="next" href="#myCarousel" class="right carousel-control">â€º</a> </div>
      </div>
      <div class="span5">
        <div class="row-fluid call2action">
          <div class="span7">
            <h4 class="precio"><span>Subtotal</span> Bs. 
              150</h4>
          </div>
          <div class="span5"> <a class="btn btn-warning btn-block" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a> </div>
        </div>
        <p class="muted t_small CAPS">Selecciona Color y talla </p>
        <div class="row-fluid">
          <div class="span6">
            <h5>Colores</h5>
            <div class="clearfix colores" id="vCo">
              <div title="Rojo" class="coloress" style="cursor: pointer" id="8"><img src="/site/images/colores/C_Rojo.jpg"></div>
            </div>
          </div>
          <div class="span6">
            <h5>Tallas</h5>
            <div class="clearfix tallas" id="vTa">
              <div title="talla" class="tallass" style="cursor: pointer" id="10">S</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>

<!-------------- MODAL OFF ---------------->