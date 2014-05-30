<?php
/* ESTADOS
 * 0. Esperando confirmacion
 * 1. ...
 * 2. Confirmado
 * 3. Con discrepancias 
 * 4. Corregido
 * 
 */
/**
 * This is the model class for table "{{itemInbound}}".
 *
 * The followings are the available columns in table '{{itemInbound}}':
 * @property integer $id
 * @property integer $producto_id
 * @property integer $inbound_id
 * @property integer $cant_enviada
 * @property integer $cant_recibida
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Inbound $inbound
 * @property PrecioTallaColor $producto
 */
class ItemInbound extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItemInbound the static model class
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
		return '{{itemInbound}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('producto_id, inbound_id, cant_enviada', 'required'),
			array('producto_id, inbound_id, cant_enviada, cant_recibida, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, producto_id, inbound_id, cant_enviada, cant_recibida, estado', 'safe', 'on'=>'search'),
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
			'inbound' => array(self::BELONGS_TO, 'Inbound', 'inbound_id'),
			'producto' => array(self::BELONGS_TO, 'Preciotallacolor', 'producto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'producto_id' => 'Producto',
			'inbound_id' => 'Inbound',
			'cant_enviada' => 'Cant Enviada',
			'cant_recibida' => 'Cant Recibida',
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
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('inbound_id',$this->inbound_id);
		$criteria->compare('cant_enviada',$this->cant_enviada);
		$criteria->compare('cant_recibida',$this->cant_recibida);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /*Retorna la fecha de carga como timestamp*/
        public function getEstado() {
            $status = "No Enviado";
            switch ($this->estado){
                case 0: 
                case 1: $status = "Enviado"; break;
                case 2: $status = "Confirmado"; break;
                case 3: $status = "Con Discrepancias"; break;
                case 4: $status = "Corregido"; break;
            }
            return $status;
        }
}