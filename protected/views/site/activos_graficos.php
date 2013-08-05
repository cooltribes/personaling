<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Activos Graficos';
?>

<div class="row">
    <div class="span12">
        <h3>Activos Gráficos:</h3>
        <p>Desde aqui podrás descargar los logos y demás elementos gráficos de nuestro branding:</p>
        <ul class="thumbnails margin_top">
            <li class="span3">
                <div class="thumbnail"> <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/activos_graficos/logo_slogan.jpg"  alt="">
                   <div class="caption"> <h3>Logotipo con slogan</h3>
                    <p><a href="" class="btn btn-info btn-block" title="Logotipo en PNG">Descargar en PNG</a> <a href="" title="Logotipo en JPG" class="btn  btn-info btn-block">Descargar en 	JPG</a></p></div>
                </div>
            </li>
             <li class="span3">
                <div class="thumbnail"> <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/activos_graficos/icono.jpg"  alt="">
                  <div class="caption">  <h3>Icono</h3>
                    <p><a href="" class="btn  btn-info btn-block" title="Icono en PNG">Descargar en PNG</a> <a href="" title="Icono en JPG" class="btn  btn-info btn-block">Descargar en JPG</a></p></div>
                </div>
            </li>
             <li class="span3">
                <div class="thumbnail"> <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/activos_graficos/flyer.jpg"  alt="">
                  <div class="caption">  <h3>Flyer</h3>
                    <p><a href="<?php echo Yii::app()->theme->baseUrl ?>/images/activos_graficos/flyer/Personaling_flyer.zip" class="btn  btn-info btn-block" title="Icono en PNG">Descargar ZIP</a> </p></div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail"> <img src="<?php echo Yii::app()->theme->baseUrl ?>/images/activos_graficos/bag.jpg"  alt="">
                  <div class="caption">  <h3>Shopping Bag</h3>
                    <p><a href="<?php echo Yii::app()->theme->baseUrl ?>/images/activos_graficos/bag/Personaling_shopping_bag.zip" class="btn  btn-info btn-block" title="Icono en PNG">Descargar ZIP</a></p></div>
                </div>
            </li>
        </ul>
    </div>
</div>
