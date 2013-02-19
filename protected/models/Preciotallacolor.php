<?php

/**
 * This is the model class for table "{{precioTallaColor}}".
 *
 * The followings are the available columns in table '{{precioTallaColor}}':
 * @property integer $id
 * @property integer $cantidad
 * @property integer $tbl_producto_id
 * @property integer $tbl_talla_id
 * @property integer $tbl_color_id
 */
class PrecioTallaColor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrecioTallaColor the static model class
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
		return '{{precioTallaColor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_producto_id, tbl_talla_id, tbl_color_id', 'required'),
			array('cantidad, tbl_producto_id, tbl_talla_id, tbl_color_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cantidad, tbl_producto_id, tbl_talla_id, tbl_color_id', 'safe', 'on'=>'search'),
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
			'cantidad' => 'Cantidad',
			'tbl_producto_id' => 'Tbl Producto',
			'tbl_talla_id' => 'Tbl Talla',
			'tbl_color_id' => 'Tbl Color',
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
		$criteria->compare('tbl_producto_id',$this->tbl_producto_id);
		$criteria->compare('tbl_talla_id',$this->tbl_talla_id);
		$criteria->compare('tbl_color_id',$this->tbl_color_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}