<?php

/**
 * This is the model class for table "{{ciudad}}".
 *
 * The followings are the available columns in table '{{ciudad}}':
 * @property integer $id
 * @property string $nombre
 * @property integer $provincia_id
 * @property integer $ruta_id
 *
 * The followings are the available model relations:
 * @property Provincia $provincia
 * @property Ruta $ruta
 */
class Ciudad extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ciudad the static model class
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
		return '{{ciudad}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, provincia_id, ruta_id', 'required'),
			array('provincia_id, ruta_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, provincia_id, ruta_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
	if(Yii::app()->language=='es_es')
	{
		 $array = array(self::HAS_MANY, 'CodigoPostal', 'ciudad_id');
	}else
	{
		if(Yii::app()->language=='es_ve')
		{
			$array = array(self::HAS_ONE, 'CodigoPostal', 'ciudad_id');
		}
		else 
		{
			$array = array(self::HAS_MANY, 'CodigoPostal', 'ciudad_id');
		}
			
	}
           
        
            
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		
		    'codigosPostales' => $array,
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
			'ruta' => array(self::BELONGS_TO, 'Ruta', 'ruta_id'),
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
			'provincia_id' => 'Provincia',
			'ruta_id' => 'Ruta',
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
		$criteria->compare('provincia_id',$this->provincia_id);
		$criteria->compare('ruta_id',$this->ruta_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}