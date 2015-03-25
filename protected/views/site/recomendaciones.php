<div class="container margin_top">
	
	
	
	 <div class=" margin_bottom">
            <div class="row">
                <div class="span12" align="center">
                    <h2 class="margin_bottom_small text_align_center"><?php echo Yii::t('contentForm','Products for you'); ?></h2>
                    <div class="thumbnails">
                        <div style="margin:0 auto">
                            <?php
                            foreach($pRecomendados as $producto){?>
                                 <li class="span2"> 
                                     
                                    <?php $image = CHtml::image($producto->getImageUrl(), "Imagen", array("width" => "180", "height" => "180"));    ?>
                                    <?php echo CHtml::link($image, $producto->getUrl() ); ?>  
                                </li>
                           <?php }
                            
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
	<div class=" margin_bottom_large braker_horz_top_less_space personal_shoppers_list"> </div>
	

	 <div class=" margin_bottom">
            <div class="row">
                <div class="span12" align="center">
                    <h2 class="margin_bottom_small text_align_center"><?php echo Yii::t('contentForm','Brands for you'); ?></h2>
                    <div class="thumbnails">
                        <div style="margin:0 auto">
                            <?php
                            foreach($pRecomendadosMarca as $producto){?>
                                 <li class="span2"> 
                                     
                                    <?php $image = CHtml::image($producto->getImageUrl(), "Imagen", array("width" => "180", "height" => "180"));    ?>
                                    <?php echo CHtml::link($image, $producto->getUrl() ); ?>  
                                </li>
                           <?php }
                            
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
	<div class=" margin_bottom_large braker_horz_top_less_space personal_shoppers_list"> </div>


 <div class=" margin_bottom">
            <div class="row">
                <div class="span12" align="center">
                    <h2 class="margin_bottom_small text_align_center"><?php echo Yii::t('contentForm','Categories for you'); ?></h2>
                    <div class="thumbnails">
                        <div style="margin:0 auto">
                            <?php
                            foreach($pRecomendadosCategoria as $producto){?>
                                 <li class="span2"> 
                                     
                                    <?php $image = CHtml::image($producto->getImageUrl(), "Imagen", array("width" => "180", "height" => "180"));    ?>
                                    <?php echo CHtml::link($image, $producto->getUrl() ); ?>  
                                </li>
                           <?php }
                            
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
</div>	