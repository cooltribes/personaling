<?php
// Estado: 0 -> default, 1 -> Aprobado, 2 -> rechazado
/**
 * This is the model class for table "{{detalle}}".
 *
 * The followings are the available columns in table '{{detalle}}':
 * @property integer $id
 * @property string $nTransferencia
 * @property string $nTarjeta
 * @property string $codigo
 * @property string $vencimiento
 * @property string $nombre
 * @property string $cedula
 * @property double $monto
 * @property string $fecha
 * @property string $comentario
 * @property integer $estado
 * 
 * The followings are the available model relations:
 * @property Pago[] $pagos
 */
class Detalle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Detalle the static model class
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
		return '{{detalle}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('monto', 'numerical'),
			array('nTransferencia', 'length', 'max'=>45),
			array('nTarjeta', 'length', 'max'=>25),
			array('codigo', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>80),
			array('cedula', 'length', 'max'=>15),
			array('comentario', 'length', 'max'=>150),
			array('vencimiento, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nTransferencia, nTarjeta, codigo, vencimiento, nombre, cedula, monto, fecha, comentario', 'safe', 'on'=>'search'),
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
			'pagos' => array(self::HAS_MANY, 'Pago', 'tbl_detalle_id'),
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
			'codigo' => 'Codigo',
			'vencimiento' => 'Vencimiento',
			'nombre' => 'Nombre',
			'cedula' => 'Cedula',
			'monto' => 'Monto',
			'fecha' => 'Fecha',
			'comentario' => 'Comentario',
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
		$criteria->compare('nTransferencia',$this->nTransferencia,true);
		$criteria->compare('nTarjeta',$this->nTarjeta,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('vencimiento',$this->vencimiento,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}