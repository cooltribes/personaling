<?php

/**
 * This is the model class for table "{{adorno}}".
 *
 * The followings are the available columns in table '{{adorno}}':
 * @property integer $id
 * @property string $nombre
 * @property string $path_image
 *
 * The followings are the available model relations:
 * @property LookHasAdorno[] $lookHasAdornos
 */
class Adorno extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Adorno the static model class
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
		return '{{adorno}}';
	}
	
	// Para compatibilidad con producto
	public function getImageUrl($opciones=array())
	{
		$opciones['ext'] = isset($opciones['ext'])?$opciones['ext']:'jpg'; // valor por defecto
		//$opciones['type'] = isset($opciones['type'])?$opciones['type']:''; // valor por defecto
		return $this->getUrl($opciones);
	}
	public function getUrl($opciones=array())
	{
		
		$opciones['ext'] = isset($opciones['ext'])?$opciones['ext']:'jpg'; // valor por defecto
		$opciones['type'] = isset($opciones['type'])?'_'.$opciones['type'].'.':'.'; // valor por defecto
		$extra_path = '/images/adorno/';
		
		$ext = pathinfo($this->path_image, PATHINFO_EXTENSION);
		//echo $ext; 
		if ($ext == $opciones['ext'] )
			return Yii::app()->baseUrl.$extra_path.str_replace(".",$opciones['type'],$this->path_image);
		
		//$info = pathinfo($this->path_image);
		//$new_file = $info['filename'] . '.' . $type;
		$new_file = preg_replace('/\..+$/', '.' . $opciones['ext'] , $this->path_image);
		$new_file_path = Yii::app()->basePath.'/..'.$new_file;
		//$new_file_path = $_SERVER['DOCUMENT_ROOT'].$new_file;
		
		//echo $new_file_path;
		//clearstatcache();
		if (file_exists ($new_file_path)){
			//echo 'sip';  
			return Yii::app()->baseUrl.$extra_path.str_replace(".",$opciones['type'],$new_file);
		}
		//echo 'nop';
		return Yii::app()->baseUrl.$extra_path.str_replace(".",$opciones['type'],$this->path_image);	
		
		
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>50),
			array('path_image,', 'file', 
			        'safe' => true,
			        'types'=> 'jpg, jpeg, png, gif',
			        'maxSize' => (1024 * 1000), // 1000 Kb
			),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, path_image', 'safe', 'on'=>'search'),
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
			'lookHasAdornos' => array(self::HAS_MANY, 'LookHasAdorno', 'adorno_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'path_image' => 'Imagen',
		);
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('path_image',$this->path_image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}