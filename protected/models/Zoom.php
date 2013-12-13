<?php

/**
 * This is the model class for table "{{zoom}}".
 *
 * The followings are the available columns in table '{{zoom}}':
 * @property integer $id
 * @property integer $cod
 * @property string $ciudad
 * @property string $estado
 */
class Zoom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Zoom the static model class
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
		return '{{zoom}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cod', 'numerical', 'integerOnly'=>true),
			array('ciudad, estado', 'length', 'max'=>70),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cod, ciudad, estado', 'safe', 'on'=>'search'),
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
			'cod' => 'Cod',
			'ciudad' => 'Ciudad',
			'estado' => 'Estado',
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
		$criteria->compare('cod',$this->cod);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getCities(){			
		
		$cliente = new ZoomJsonService("http://www.grupozoom.com/servicios/webservices/");
	 	return $cliente->call("getCiudades", array("filtro"=>"cod")); 
		//Devuelve array de tracking si lo consigue o null si no
	} 
	
}