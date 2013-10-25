<?php

/**
 * This is the model class for table "{{tarjetaCredito}}".
 *
 * The followings are the available columns in table '{{tarjetaCredito}}':
 * @property integer $id
 * @property string $nombre
 * @property string $numero
 * @property string $codigo
 * @property string $vencimiento
 * @property string $direccion
 * @property string $ciudad
 * @property string $zip
 * @property string $estado
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class TarjetaCredito extends CActiveRecord
{
	public $month;
	public $year;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarjetaCredito the static model class
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
		return '{{tarjetaCredito}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, numero, codigo, vencimiento, ci, direccion, ciudad, zip, estado, user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>80),
			array('numero', 'length', 'min'=>14, 'max'=>16),
			array('codigo', 'length', 'min'=>3, 'max'=>4),
			array('zip', 'length', 'max'=>5),
			array('direccion', 'length', 'max'=>150),
			array('ciudad', 'length', 'max'=>50),
			array('estado', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, numero, codigo, vencimiento, ci, direccion, ciudad, zip, estado, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
			'numero' => 'Numero',
			'codigo' => 'Codigo',
			'vencimiento' => 'Vencimiento',
			'ci' => 'Cedula',
			'direccion' => 'Direccion',
			'ciudad' => 'Ciudad',
			'zip' => 'Zip',
			'estado' => 'Estado',
			'user_id' => 'User',
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
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('vencimiento',$this->vencimiento,true);
		$criteria->compare('ci',$this->ci,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeValidate()
	{
	   $this->vencimiento = $this->month .'/'. $this->year;
	   //echo $this->birthday;
	   return parent::beforeValidate();
	}
	
	
}