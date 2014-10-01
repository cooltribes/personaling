<?php

/**
 * This is the model class for table "{{color}}".
 *
 * The followings are the available columns in table '{{color}}':
 * @property integer $id
 * @property string $valor
 */
class Color extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Color the static model class
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
		return '{{color}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('padreID', 'numerical', 'integerOnly'=>true),
			array('valor', 'length', 'max'=>45),
			array('path_image', 'length', 'max'=>255),
			array('rgb', 'length', 'max'=>6),
			array('valor, padreID', 'required', 'message'=>'{attribute} No puede ser vacio.'),
			array('title, url', 'length', 'max'=>150),
			array('description, keywords', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, valor,path_image,rgb, padreID, title, description, keywords, url', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'valor' => 'Nombre',
			'padreID' => 'Color padre',
			'title' => 'Título',
			'description' => 'Descripción',
			'keywords' => 'Palabras clave',
			'url' => 'Url',
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
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('padreID',$this->padreID,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getColor($id)
	 {
		$color=Color::model()->findByPk($id);
		return $color->valor;
		 
	}
}