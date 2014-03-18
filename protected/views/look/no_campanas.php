<div class="container margin_top">
  <div class="row">
    <div class="span8 offset2">
      <section class="box_1 bg_mancha_1  margin_top  margin_bottom_small padding_small">
        <div class="page-header">
          <h1><?php echo Yii::t('contentForm','Campaigns don\'t have available at this time'); ?></h1>
        </div>
        <p><?php echo  Yii::t('contentForm','We will notify you via email when a new looks to create. Meanwhile we invite you to stroll through  <a href="#" title="Store">our store</a>'); ?> </p>
      </section>
      <hr/>
      <?php
      echo CHtml::link(Yii::t('contentForm','Keep buying'), $this->createUrl('/tienda/index'), array('class'=>'btn'));
      ?>
      </div>
  </div>
</div>
<!-- /container -->