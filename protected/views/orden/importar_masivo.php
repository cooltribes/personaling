<?php
$this->breadcrumbs=array(
    Yii::t('backEnd', 'Orders')=>array('admin'),
    Yii::t('backEnd', 'Import bulk shipments'),
);
?>
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

  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action' => CController::createUrl('importarmasivo'),
	'id'=>'excel-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>


 <?php echo CHtml::hiddenField('valido','1'); ?> 

	<div class="row margin_top">
    	<div class="span12">
    		<div class="page-header">
                    <h1><?php echo Yii::t('backEnd', 'Import Shipments'); ?></h1>
  			</div>
      		<div class="bg_color3   margin_bottom_small padding_small box_1">
        		<fieldset>
                            <legend><?php echo Yii::t('backEnd', 'Upload file'); ?></legend>
            
		            <div class="well well-large">
		              <?php
		            	$this->widget('CMultiFileUpload', array(
		                'name' => 'url',
		                'accept' => 'xls|xlsx', // useful for verifying files
		                'duplicate' => Yii::t('backEnd', 'Duplicated file'), // useful, i think
		                'denied' => Yii::t('backEnd', 'Invalid file'), // useful, i think
		            ));
					
					?>
	              	
	              	<div class="margin_top_small">
	              		    
			            <?php $this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'submit',
							'type'=>'danger',
							'label'=>  Yii::t('backEnd', 'Upload'),
						)); ?>
			        </div>
	            
            		</div>
            </fieldset>
        </div>	
   	  </div>
	</div>
	<?php $this->endWidget(); ?>

<hr/>

<?php

	echo "</br></br>".$tabla;
?>