<?php

/**
 * This is the model class for table "{{precio}}".
 *
 * The followings are the available columns in table '{{precio}}':
 * @property integer $id
 * @property double $costo
 * @property double $precioVenta
 * @property integer $tipoDescuento
 * @property integer $valorTipo
 * @property double $ahorro
 * @property double $precioDescuento
 * @property integer $impuesto
 * @property double $precioImpuesto
 * @property integer $tbl_producto_id
 *
 * The followings are the available model relations:
 * @property Producto $tblProducto
 */
class tblprecio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return tblprecio the static model class
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
		return '{{precio}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, tbl_producto_id', 'required'),
			array('id, tipoDescuento, valorTipo, impuesto, tbl_producto_id', 'numerical', 'integerOnly'=>true),
			array('costo, precioVenta, ahorro, precioDescuento, precioImpuesto', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, costo, precioVenta, tipoDescuento, valorTipo, ahorro, precioDescuento, impuesto, precioImpuesto, tbl_producto_id', 'safe', 'on'=>'search'),
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
			'costo' => 'Costo',
			'precioVenta' => 'Precio Venta',
			'tipoDescuento' => 'Tipo Descuento',
			'valorTipo' => 'Valor Tipo',
			'ahorro' => 'Ahorro',
			'precioDescuento' => 'Precio Descuento',
			'impuesto' => 'Impuesto',
			'precioImpuesto' => 'Precio Impuesto',
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
		$criteria->compare('costo',$this->costo);
		$criteria->compare('precioVenta',$this->precioVenta);
		$criteria->compare('tipoDescuento',$this->tipoDescuento);
		$criteria->compare('valorTipo',$this->valorTipo);
		$criteria->compare('ahorro',$this->ahorro);
		$criteria->compare('precioDescuento',$this->precioDescuento);
		$criteria->compare('impuesto',$this->impuesto);
		$criteria->compare('precioImpuesto',$this->precioImpuesto);
		$criteria->compare('tbl_producto_id',$this->tbl_producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}