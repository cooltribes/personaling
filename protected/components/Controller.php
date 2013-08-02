<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	 /* SEO Vars */
    //public $pageTitle = 'Personaling';
    public $pageDesc = '';
	public $keywords = '';
    public $pageRobotsIndex = true;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function display_seo()
	{
	    // STANDARD TAGS
	    // -------------------------
	    // Title/Desc
	    echo "\t".''.PHP_EOL;
	    echo "\t".'<meta name="description" content="',CHtml::encode($this->pageDesc),'">'.PHP_EOL;
		echo "\t".'<meta name="keywords" content="',CHtml::encode($this->keywords),'">'.PHP_EOL;
	
	    // Option for NoIndex
	    if ( $this->pageRobotsIndex == false ) {
	        echo '<meta name="robots" content="noindex">'.PHP_EOL;
	    }
	}

	public function behaviors() {
		return array(
	              'BodyClassBehavior' => array( 
	                     'class' => 'ext.BodyClassBehavior.BodyClassBehavior'
	              ),
		);
	}	
}