
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
		<?php $categorias = Categoria::model()->findAllByAttributes(array('padreId'=>'2')); ?>
        <?php 
        
        if(count($categorias))
				foreach($categorias as $categoria){
					
		?>              
              <li> 
        <?php echo CHtml::ajaxLink($categoria->nombre,
							 Yii::app()->createUrl( 'tienda/ocasiones'),
							 array( // ajaxOptions
						    'type' => 'POST',
						    'dataType'=>'json',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                   // alert(data.accion);
						                   $('.dropdown').removeClass('open');
						                    $('#div_ocasiones').html(data.div);
						                  }",
						    'data' => array( 'padreId' => $categoria->id )
						  ),
						  array( //htmlOptions
						   // 'href' => Yii::app()->createUrl( 'tienda/ocasiones' ),
						   'href'=>'#',
						    //'class' => 'thumbnail',
						    'id' => 'categoria'.$categoria->id,
						    'draggable'=>"false",
						  )
						  );    
		?>  	
              	 
              </li>
<?php } ?>              

            
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
       
        	<?php /** @var BootActiveForm $form */
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				     'id'=>'searchForm',
  					  'type'=>'search',
  					  'method'=>'get',
				    'htmlOptions'=>array( 'class'=>'navbar-search pull-right hidden-phone'),
				)); ?>
          <div class="input-append">
          <?php // Recordar que aqui va el componente Select2 de la extension del Bootstrap para Yii. La misma que esta en Talla y colores del admin ?>
          
            <?php // echo $form->textFieldRow($model, 'textField', array('placeholder'=>"Buscar por Personal Shopper",'class'=>'')); ?>
            <?php //echo CHtml::textField('search','',array('placeholder'=>"Buscar por Personal Shopper")); ?>
            	<?php
              	 $colores = User::model()->findAll(); //array('order'=>'first_name') ordena alfeticamente por nombre
				 foreach($colores as $i => $row){
					$data[$i]['text']= $row->profile->first_name.' '.$row->profile->last_name;
					$data[$i]['id'] = $row->id;
				 }
				$this->widget('bootstrap.widgets.TbSelect2',array(
				'asDropDownList' => false,
	'name' => 'clevertech',
	'options' => array(
		 'placeholder'=> "Buscar por Personal Shopper",
		 'multiple'=>true,
		 'data'=>$data,
		 //'data'=>array(array('id'=>1,'text'=>'rafa'),array('id'=>2,'text'=>'lore')),
		// 'data'=> CHtml::listData(Color::model()->findAll(),'id', 'valor'),
		// 'width' => '40%',
	),
			)
				);
				?>
            <div class="btn-group">
          
              <?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Buscar','type'=>'danger')); ?>
            </div>
          </div>
        <?php $this->endWidget(); ?>
      </nav>
      <!--/.nav-collapse --> 
    </div>
    <div class="navbar-inner sub_menu" id="div_ocasiones"  >
    
    <?php //Este submenu carga las categorias segun lo seleccinonado arriba, por ejemplo de fiesta: coctel, familia, etc ?>
     
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>

<!-- SUBMENU OFF -->
<div class="container" id="tienda_looks">
<?php 
$this->renderPartial('_look',array(
	'looks'=>$looks,
	'pages'=>$pages,
)); 
?>
</div>
  
<!-- /container -->

<script type="text/javascript">
// here is the magic
function refresh()
{
	
    <?php echo CHtml::ajax(array(
            'url'=>array('tienda/look'),
           // 'data'=> "js:$(this).serialize()",
            'data' => array( 'ocasiones' => 55 ),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogColor div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogColor div.divForForm form').submit(addColor);
                }
                else
                {
                   $('#tienda_looks').html(data.div);
                   // setTimeout(\"$('#dialogColor').modal('hide') \",3000);
                }
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>
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