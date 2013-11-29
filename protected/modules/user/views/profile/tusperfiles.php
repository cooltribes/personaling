<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Tus Perfiles");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta") => array('micuenta'),
	UserModule::t("Tus Perfiles"),
);

?>
<div class="container margin_top tu_perfil"> 
	<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
        ),
    )
); ?>	
<!-- FLASH OFF --> 	
  
  <div class="row">
  
  <!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 
    <div class="span9">
      <h1>Tus perfiles creados para otras personas</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
                
          
          <fieldset>
              <legend class="lead">Selecciona un perfil para alguien más</legend>
              <div class="row margin_bottom_medium margin_top_medium">
                  <div class="">                                     

                      <ul class="unstyled">

                          <?php
                          $otrosPerfiles = Filter::model()->findAllByAttributes(array('type' => '0', 'user_id' => Yii::app()->user->id), array('order' => 'id_filter DESC'));

                          $elementos = array();

                          foreach ($otrosPerfiles as $perfil) {
                              ?>
                              <li class="span2 card margin_bottom_medium" id="<?php echo $perfil->id_filter; ?>">
                                  
                                  <img width="270" height="270" src="/develop/images/avatar_provisional_2.jpg" alt="Avatar">
                                  
                                  <div class="card_content vcard">
                                      <h4 class="fn"><?php echo $perfil->name; ?></h4>
                                      <div class="span12">
                                          <div class="span6"></div>
                                          <div class="span6"></div>
                                      </div>
                                      
                                  </div>
                                  
                              </li>   
                          
                                  
                           <?php 
                             
                          }
                          ?>
                      </ul>

                  </div>
              </div>
            
          </fieldset>
         
      </article>
    </div>
  </div>
</div>
<!-- /container -->


