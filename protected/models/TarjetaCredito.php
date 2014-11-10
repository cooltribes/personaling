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
	public $check;
	
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
			array('nombre, numero, codigo, vencimiento, ci, direccion, ciudad, estado, user_id', 'required','message' => '{attribute} es un campo obligatorio.'),
			array('user_id, numero, ci', 'numerical', 'integerOnly'=>true,'message' => '{attribute} debe ser numérico'),
			array('nombre', 'length', 'max'=>80),
			array('ci', 'length', 'max'=>8,'tooLong'=>'{attribute} permite un máximo de 8 números'), 
			array('numero', 'length', 'min'=>14, 'max'=>16,'tooShort' => '{attribute} es muy corto (mínimo 14 números)','tooLong'=>'{attribute} es muy largo (máximo 16 números)'),
			array('codigo', 'length', 'min'=>3, 'max'=>3,'tooShort' => '{attribute} es muy corto (mínimo 3 números)','tooLong'=>'{attribute} es muy largo (máximo 3 números)'),
			//array('month','compare','compareValue'=>'0','operator'=>'>','allowEmpty'=>false, 'message'=>'Seleccione un mes.'),
			//array('year','compare','compareValue'=>'0','operator'=>'>','allowEmpty'=>false, 'message'=>'Seleccione un año.'),
			//array('month','compare','compareValue'=>'Mes','operator'=>'!=','message'=>'Seleccione un mes.'),
			//array('year','compare','compareValue'=>'Año','operator'=>'==','message'=>'Seleccione un año.'),
			array('zip', 'length', 'max'=>5,'tooLong'=>'{attribute} es muy largo (máximo 5 números)'), 
			array('direccion', 'length', 'max'=>150,'tooLong'=>'{attribute} es muy largo (máximo 150 letras)'),
			array('ciudad', 'length', 'max'=>50,'tooLong'=>'{attribute} es muy largo (máximo 50 letras)'),
			array('estado', 'length', 'max'=>45,'tooLong'=>'{attribute} es muy largo (máximo 45 letras)'), 
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
			'numero' => 'Número',
			'codigo' => 'Código',
			'vencimiento' => 'Vencimiento',
			'ci' => 'Cédula de Identidad',
			'direccion' => 'Dirección',
			'ciudad' => 'Ciudad',
			'zip' => 'Código Postal',
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