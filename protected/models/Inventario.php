<?php

/**
 * This is the model class for table "{{inventario}}".
 *
 * The followings are the available columns in table '{{inventario}}':
 * @property integer $id
 * @property integer $cantidad
 * @property integer $tope
 * @property integer $minimaCompra
 * @property integer $maximaCompra
 * @property integer $disponibilidad
 * @property integer $tbl_producto_id
 *
 * The followings are the available model relations:
 * @property Producto $tblProducto
 */
class Inventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventario the static model class
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
		return '{{inventario}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad, tope, minimaCompra, maximaCompra, disponibilidad, tbl_producto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cantidad, tope, minimaCompra, maximaCompra, disponibilidad, tbl_producto_id', 'safe', 'on'=>'search'),
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
			'tblProducto' => array(self::BELONGS_TO, 'Producto', 'tbl_producto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cantidad' => 'Cantidad',
			'tope' => 'Cantidad tope para salir de inventario',
			'minimaCompra' => 'Cantidad Minima permitida en el carrito de compras',
			'maximaCompra' => 'Cantidad Maxima permitida por compra',
			'disponibilidad' => 'Disponibilidad en inventario',
			'tbl_producto_id' => 'Tbl Producto',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('tope',$this->tope);
		$criteria->compare('minimaCompra',$this->minimaCompra);
		$criteria->compare('maximaCompra',$this->maximaCompra);
		$criteria->compare('disponibilidad',$this->disponibilidad);
		$criteria->compare('tbl_producto_id',$this->tbl_producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}