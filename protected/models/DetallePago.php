<?php

/**
 * This is the model class for table "{{detallePago}}".
 *
 * The followings are the available columns in table '{{detallePago}}':
 * @property integer $id
 * @property string $nTransferencia
 * @property string $nTarjeta
 * @property string $nombre
 * @property string $cedula
 * @property string $banco
 * @property double $monto
 * @property string $fecha
 * @property string $comentario
 * @property integer $estado
 * @property integer $orden_id
 * @property integer $tipo_pago
 *
 * The followings are the available model relations:
 * @property OrdenGC $orden
 */
class DetallePago extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetallePago the static model class
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
		return '{{detallePago}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado, orden_id, tipo_pago', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
			array('nTransferencia, banco', 'length', 'max'=>45),
			array('nTarjeta', 'length', 'max'=>25),
			array('nombre', 'length', 'max'=>80),
			array('cedula', 'length', 'max'=>15),
			array('comentario', 'length', 'max'=>150),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nTransferencia, nTarjeta, nombre, cedula, banco, monto, fecha, comentario, estado, orden_id, tipo_pago', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'OrdenGC', 'orden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nTransferencia' => 'N Transferencia',
			'nTarjeta' => 'N Tarjeta',
			'nombre' => 'Nombre',
			'cedula' => 'Cedula',
			'banco' => 'Banco',
			'monto' => 'Monto',
			'fecha' => 'Fecha',
			'comentario' => 'Comentario',
			'estado' => 'Estado',
			'orden_id' => 'Orden',
			'tipo_pago' => 'Tipo Pago',
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
		$criteria->compare('nTransferencia',$this->nTransferencia,true);
		$criteria->compare('nTarjeta',$this->nTarjeta,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('banco',$this->banco,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('tipo_pago',$this->tipo_pago);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}