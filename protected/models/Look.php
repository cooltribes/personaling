<?php

/**
 * This is the model class for table "{{look}}".
 *
 * The followings are the available columns in table '{{look}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $altura
 * @property integer $contextura
 * @property integer $pelo
 * @property integer $ojos
 * @property integer $tipo_cuerpo
 * @property integer $piel
 * @property string $created_on
 * @property integer $tipo
 *
 * The followings are the available model relations:
 * @property LookHasTblBolsa[] $lookHasTblBolsas
 * @property Producto[] $tblProductos
 */
class Look extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Look the static model class
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
		return '{{look}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'required'),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
			array('description, created_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, altura, contextura, pelo, ojos, tipo_cuerpo, piel, created_on, tipo', 'safe', 'on'=>'search'),
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
			'lookHasTblBolsas' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_look_id'),
			'tblProductos' => array(self::MANY_MANY, 'Producto', '{{look_has_tbl_producto}}(tbl_look_id, tbl_producto_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'altura' => 'Altura',
			'contextura' => 'Contextura',
			'pelo' => 'Pelo',
			'ojos' => 'Ojos',
			'tipo_cuerpo' => 'Tipo Cuerpo',
			'piel' => 'Piel',
			'created_on' => 'Created On',
			'tipo' => 'Tipo',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('altura',$this->altura);
		$criteria->compare('contextura',$this->contextura);
		$criteria->compare('pelo',$this->pelo);
		$criteria->compare('ojos',$this->ojos);
		$criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);
		$criteria->compare('piel',$this->piel);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}