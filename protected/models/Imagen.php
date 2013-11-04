<?php

/**
 * This is the model class for table "{{imagen}}".
 *
 * The followings are the available columns in table '{{imagen}}':
 * @property integer $id
 * @property string $url
 * @property integer $principal
 * @property integer $orden
 * @property integer $tbl_producto_id
 */
class Imagen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Imagen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{imagen}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_producto_id', 'required'), 
			array('principal, orden, tbl_producto_id,color_id', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, principal, orden, tbl_producto_id,color_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'producto' => array(self::BELONGS_TO, 'Producto', 'tbl_producto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => '',
			'principal' => 'Principal',
			'orden' => 'Orden',
			'tbl_producto_id' => 'Tbl Producto', 
			'color_id' => 'Color',
		);
	}

	public function scopes()
	    {
	        return array(
	            'published'=>array(
	                'condition'=>'status=1', 
	            ),
	            'ordenadas'=>array(
	                'order'=>'orden DESC',
	            ),
	        );
	    }
	/**
	 * Obtener el Url de la imagen
	 * ext = jpg / png
	 * type = thumb / orig / 
	 */	
	public function getUrl($opciones=array())
	{
		
		$opciones['ext'] = isset($opciones['ext'])?$opciones['ext']:'jpg'; // valor por defecto jpg
		$opciones['type'] = isset($opciones['type'])?'_'.$opciones['type'].'.':'.'; // valor por defecto .
		$opciones['baseUrl'] = isset($opciones['baseUrl'])?$opciones['baseUrl']:true; // valor por defecto true
		
		$baseUrl = '';
		if ($opciones['baseUrl'])
			$baseUrl = Yii::app()->baseUrl;
		$ext = pathinfo($this->url, PATHINFO_EXTENSION);
		//echo $ext; 
		if ($ext == $opciones['ext'] )
			return $baseUrl.str_replace(".",$opciones['type'],$this->url);
		
		//$info = pathinfo($this->url);
		//$new_file = $info['filename'] . '.' . $type;
		$new_file = preg_replace('/\..+$/', '.' . $opciones['ext'] , $this->url);
		$new_file_path = $baseUrl.'/..'.$new_file;
		//$new_file_path = $_SERVER['DOCUMENT_ROOT'].$new_file;
		
		//echo $new_file_path;
		//clearstatcache();
		if (file_exists ($new_file_path)){
			//echo 'sip';  
			return $baseUrl.str_replace(".",$opciones['type'],$new_file);
		}
		//echo 'nop';
		return $baseUrl.str_replace(".",$opciones['type'],$this->url);	
		
		
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('principal',$this->principal);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('tbl_producto_id',$this->tbl_producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getImagen($producto,$color)
	 {
		$url= new Imagen;	
		if($url=Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto,'color_id'=>$color)))
			return $url->url;
		else
			return "http://placehold.it/180x180"; 
		
	}
	 

}