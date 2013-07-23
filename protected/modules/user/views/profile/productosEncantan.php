<div class="container margin_top">
<div class="page-header">
  <h1>Productos que te encantan</h1>
</div>
<div class="row">
<div class="span12 tienda_productos">
  <div class="row">
    <?php
	$template = '
			{items}
   		</div>
      		{pager}
	    </div>
    ';
	$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datos',
	    'template'=>$template,
	));    
	?>
  </div>
</div>
<!-- /container --> 

<script>

function encantar(id)
   	{
   		var idProd = id;
   		//alert("id:"+idProd);		
   		
   		$.ajax({
	        type: "post",
	        url: "../producto/encantar", // action Tallas de Producto
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
					alert("Debe primero ingresar como usuario");
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

<!-- Modal -->
<div id="myModal" class="modal hide tienda_modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
          <a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a> <a data-slide="next" href="#myCarousel" class="right carousel-control">›</a> </div>
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
