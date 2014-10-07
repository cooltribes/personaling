<?php 
/* @var $this SiteController */
// Open Graph

//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
//Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
//Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);

$seo = SeoStatic::model()->findByAttributes(array('name'=>'Home España'));
if(isset($seo)){
    $this->pageTitle = $seo->title;
    Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
	
	Yii::app()->clientScript->registerMetaTag($seo->title, null, null, array('property' => 'og:title'), null); 
	Yii::app()->clientScript->registerMetaTag($seo->description, null, null, array('property' => 'og:description'), null);
	 
}
else{
	Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'], null, null, array('property' => 'og:title'), null); 
	Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
}
Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'] , null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'], null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url .'images/icono_preview.jpg', null, null, array('property' => 'og:image'), null);


?>
</div>
</div>
<!-- /Hack para el layout del home  -->

<div class="no-backgrounds">
    
</div>



<?php
	$this->renderPartial(Yii::app()->language);
	
	if(Yii::app()->user->isGuest){
		echo'<div class="margin_top_large"></div><div class="braker_horz_top_less_space no_margin_bottom"></div>';
		
		
		$user = User::model()->findByPk(Yii::app()->user->id);
		$looks = new Look;
		$productos = new Producto;
		$psDestacados = new User;
                
                
                $psDestacados = User::model()->findAllByAttributes(array('ps_destacado' => '1'), new CDbCriteria(array(
                    'limit' => 4,
                    'order' => 'fecha_destacado DESC'
                )));
                
		$this->renderPartial('/site/top',array(
					'dataProvider' => $looks->masvendidos(3),
					'destacados' => $productos->destacados(6),
					'dataProvider_destacados' => $looks->lookDestacados(3),
					'user'=>$user,
                                        'psDestacados' => $psDestacados,
                                        'seo'=>$seo//->getPsDestacados(4),
				));	
		
		
	}
?>

<script type="text/javascript">
$('#sliderHome').carousel({
  interval: 6000,
});
$('#buttomCookies').on('click',function(){
    $('.message-cookies').css({display:'none',});
});
</script>