<?php

/**
 * This is the model class for table "{{precioTallaColor}}".
 * 
 * The followings are the available columns in table '{{precioTallaColor}}':
 * @property integer $id
 * @property integer $cantidad
 * @property integer $producto_id
 * @property integer $talla_id
 * @property integer $color_id
 * 
 */
class PrecioTallaColor extends CActiveRecord 
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrecioTallaColor the static model class
	 */
	 public $color = '';
	 public $talla = '';
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
			array('producto_id, talla_id, color_id', 'required'),
			array('sku','unique'),
			array('cantidad, producto_id, talla_id, color_id', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical','min'=>0), //,'tooSmall' => 'Debe seleccionar por lo menos un {attribute}','on'=>'update'
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cantidad, producto_id, talla_id, color_id,sku', 'safe', 'on'=>'search'),
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
			'mycolor' => array(self::BELONGS_TO,'Color','color_id'),
			'mytalla' => array(self::BELONGS_TO,'Talla','talla_id'), 
                        'producto' => array(self::BELONGS_TO,'Producto','producto_id'),
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
			'producto_id' => 'Tbl Producto',
			'talla_id' => 'Tbl Talla',
			'color_id' => 'Tbl Color',
			'sku'=>'Codigo/Sku',
		);
	}
	
	public function enOrdenes($id = null){
		if(is_null($id))
			$sql = "select count(*) from tbl_orden_has_productotallacolor o  where o.preciotallacolor_id =".$this->id;
		else
			$sql = "select count(*) from tbl_orden_has_productotallacolor o  where o.preciotallacolor_id =".$id;
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
		
		return $total;
	}
	
	public function enLooks($producto= null, $color = null){
		if(is_null($id))
			$sql = "select count(*) from tbl_look_has_producto l where l.producto_id = ".$this->producto_id." AND l.color_id = ".$this->color_id;
		else
			$sql =  "select count(*) from tbl_look_has_producto l where l.producto_id = ".$producto." AND l.color_id = ".$color;
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
		
		return $total;
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
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('talla_id',$this->talla_id);
		$criteria->compare('color_id',$this->color_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	protected function afterFind(){
		
   //$this->day = date('d', strtotime($this->birthday));
    //$this->month = date('m', strtotime($this->birthday));
    //$this->year = date('Y', strtotime($this->birthday));
	$this->color = Color::model()->findByPk($this->color_id)->valor;
	
	$this->talla = Talla::model()->findByPk($this->talla_id)->valor;	

		return parent::afterFind();
	}	
}