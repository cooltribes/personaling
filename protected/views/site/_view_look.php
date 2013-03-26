<?php
	$look = Look::model()->findByPk($data['id']);
	$look->matchOcaciones();
?>
              <div class="active item">
            <div class="row"> 
              <article class="span4"> 
              	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "370", "height" => "400", 'class'=>'img_1')); ?>
              	<?php echo CHtml::link($image); ?>
              	<!--
              	<a href="Look_seleccionado.php" title="look">
              	<img src="http://placehold.it/370x400"/>
              	
              </a>
              -->
                <div class="margin_top_small"><!-- <img class="pull-right" src="http://placehold.it/50x50"/> -->
                  <p class="pull-right margin_top_small margin_right_small"><?php echo $look->title; ?> Recomendado por: <?php echo $look->user->profile->first_name; ?></p>
                </div>
              </article>
            </div></div>