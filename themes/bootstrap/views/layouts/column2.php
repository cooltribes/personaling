<?php /* @var $this Controller */ ?>
<?php 
if (Yii::app()->language == "es_ve")
	$this->beginContent('//layouts/main_ve');
if (Yii::app()->language == "es_es") 
	$this->beginContent('//layouts/main_es');
 
?>
<div class="row">
    <div class="span12">
        <div id="content">
        	
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>