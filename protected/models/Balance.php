<?php

/**
 * This is the model class for table "{{balance}}".
 *
 * The followings are the available columns in table '{{balance}}':
 * @property integer $id
 * @property double $total
 * @property integer $orden_id 
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 */
 
 //UN BALANCE CON ORDER_ID = 0; REPRESENTA UNA CARGA DE SALDO DESDE ADMIN
 
 /* TIPO:
  * 
  * 0: Balance Positivo
  * 1: Balance Negativo
  * 2: Tarjeta de Regalo
  * 3: Carga desde Admin
  * 4: Saldo por devolución // DEVALUACION?
  * 5: Saldo por comision de ventas (Personal Shoppers)
  * 6: Regalo por registro completo
  * 
  */
 
class Balance extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Balance the static model class
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
		return '{{balance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, orden_id', 'required'),
			array('user_id, orden_id, tipo', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, total, orden_id, user_id, tipo', 'safe', 'on'=>'search'),
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
			'total' => 'Total',
			'orden_id' => 'Orden',
			'user_id' => 'User',
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
		$criteria->compare('total',$this->total);
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getOrigen($id = null){
		if(!is_null($id))
			$balance=$this->findByPk($id);
		else
			$balance=$this;
		if($balance->tipo==0)
			return "Excedente de pago";
		if($balance->tipo==1)
			return "Descuento de Saldo";
		if($balance->tipo==2)
			return "Carga por Tarjeta de Regalo";
		if($balance->tipo==3)
			return "Carga desde Administrador";
		if($balance->tipo==4)
			return "Saldo por devolución";
		
		return "Desconocido";

  
		
	}
}