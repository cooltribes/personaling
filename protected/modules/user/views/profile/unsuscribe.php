<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Mi Cuenta");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Notificación"),
);
?>
<div class="container margin_top tu_perfil"> 
 
  <div class="row">
  
   <!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 
    <div class="span9">
      <h1>Lista de correos</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
                <!-- FLASH ON --> 
                <?php $this->widget('bootstrap.widgets.TbAlert', array(
                        'block'=>true, // display a larger alert block?
                        'fade'=>true, // use transitions?
                        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                        'alerts'=>array( // configurations per alert type
                            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                        ),
                    )
                ); ?>	
                <!-- FLASH OFF --> 
              <?php               



              //Si esta suscrito, mostrar el boton para desuscribir
              if($user->suscrito_nl == 1){ ?>
                <legend>Darme de baja:</legend>
                <label for="">Para confirmar haz click en el siguiente botón:</label>
                <?php echo CHtml::hiddenField("unsuscribe", true);
                    
                ?>
                <p class="margin_top text_align_center">
                    <?php
                        echo CHtml::submitButton("Darme de baja", array(
                            'class'=>'btn-large btn btn-danger'));
                    ?>                    
                </p>
              <?php }else{?>
                
                <p class="text_align_center margin_top">No estás suscrito a la lista de correos Personaling</p>
            
              <?php }?>
          </fieldset>
        </form>
      </article>
    </div>
  </div>
</div>
<!-- /container -->
