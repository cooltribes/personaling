<?php

/**
 * This is the model class for table "{{precio}}".
 *
 * The followings are the available columns in table '{{precio}}':
 * @property integer $id
 * @property double $costo
 * @property integer $combinacion
 * @property double $precioVenta
 * @property integer $tipoDescuento
 * @property integer $valorTipo
 * @property double $ahorro
 * @property double $precioDescuento
 * @property integer $impuesto
 * @property double $precioImpuesto
 * @property integer $tbl_producto_id
 * @property double $ganancia
 * @property integer $gananciaImpuesto
 *
 * The followings are the available model relations:
 * @property Producto $tblProducto
 */
class Precio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Precio the static model class
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
			array('tbl_producto_id', 'required'),
			array('combinacion, tipoDescuento, impuesto, tbl_producto_id, ganancia', 'numerical', 'integerOnly'=>true),
			
			array('ahorro, precioDescuento, precioImpuesto', 'numerical'),
			array('costo, precioVenta','numerical',
				    'integerOnly'=>false,
				    'min'=>0,
				    'tooSmall'=>'El valor del producto debe ser mayor a cero',
					),
			array('valorTipo','numerical',
				    'integerOnly'=>false,
				    'min'=>0,
				    'tooSmall'=>'El descuento debe ser mayor o igual a cero',
					),
			array('costo, precioVenta', 'required'),		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, costo, combinacion, precioVenta, tipoDescuento, valorTipo, ahorro, precioDescuento, impuesto, precioImpuesto, tbl_producto_id', 'safe', 'on'=>'search'),
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
			'anteriores' => array(self::HAS_MANY, 'HistoricoPrecio', 'precio_id'),
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
			'combinacion' => 'Combinación',
			'precioVenta' => 'Precio Venta',
			'tipoDescuento' => 'Tipo de Descuento',
			'valorTipo' => 'Valor: (% o '.Yii::t('contentForm','currSym').')',
			'ahorro' => 'Ahorro para el usuario ('.Yii::t('contentForm','currSym').')',
			'precioDescuento' => 'Precio con descuento para el usuario ('.Yii::t('contentForm','currSym').')',
			'impuesto' => 'Regla de Impuestos',
			'precioImpuesto' => 'Precio con impuesto para el usuario ('.Yii::t('contentForm','currSym').')',
			'tbl_producto_id' => 'Tbl Producto',
			'ganancia'=>'Margen de Ganancia (%)',
			'gananciaImpuesto'=>'La ganancia es sobre el precio con impuesto',
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
		$criteria->compare('combinacion',$this->combinacion);
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
	/*
	public function beforeValidate()
	{

		$fmt = new \NumberFormatter( 'VEF', NumberFormatter::CURRENCY );
		$num = $this->costo;
		$this->costo = $fmt->parseCurrency($num, 'VEF');

		//$fmt = new NumberFormatter( 'VEF', NumberFormatter::CURRENCY );
		$num = $this->precioVenta;
		$this->precioVenta = $fmt->parseCurrency($num, 'VEF');
		
		//$fmt = new NumberFormatter( 'VEF', NumberFormatter::CURRENCY );
		$num = $this->valorTipo;
		$this->valorTipo = $fmt->parseCurrency($num, 'VEF');
		
		//$fmt = new NumberFormatter( 'VEF', NumberFormatter::CURRENCY );
		$num = $this->ahorro;
		$this->ahorro = $fmt->parseCurrency($num, 'VEF');
		
		//$fmt = new NumberFormatter( 'VEF', NumberFormatter::CURRENCY );
		$num = $this->precioDescuento;
		$this->precioDescuento = $fmt->parseCurrency($num, 'VEF');
		
		//$fmt = new NumberFormatter( 'VEF', NumberFormatter::CURRENCY );
		$num = $this->precioImpuesto;
		$this->precioImpuesto = $fmt->parseCurrency($num, 'VEF');

		
		return parent::beforeValidate();
	}
	*/
	public function afterFind()
	{
			
		setlocale(LC_MONETARY, 've_VE');
		$this->costo = money_format('%i', $this->costo);
		
		$this->precioVenta = money_format('%i', $this->precioVenta);
		
		$this->valorTipo = money_format('%i', $this->valorTipo);
		
		$this->ahorro = money_format('%i', $this->ahorro);
		
		$this->precioDescuento = money_format('%i', $this->precioDescuento);
		
		$this->precioImpuesto = money_format('%i', $this->precioImpuesto);
		
		/*
		$this->costo = Yii::app()->numberFormatter->formatDecimal($this->costo); 
		$this->precioVenta = Yii::app()->numberFormatter->formatDecimal($this->precioVenta); 
		$this->valorTipo = Yii::app()->numberFormatter->formatDecimal($this->valorTipo);
		$this->ahorro = Yii::app()->numberFormatter->formatDecimal($this->ahorro);
		$this->precioDescuento = Yii::app()->numberFormatter->formatDecimal($this->precioDescuento);
		$this->precioImpuesto = Yii::app()->numberFormatter->formatDecimal($this->precioImpuesto); 
		*/
		return parent::afterFind();
	}
	
	public function beforeSave()
	{
		
		if($this->tipoDescuento==0){ // si es porcentaje no puede ser mayor a 100
			
			if($this->valorTipo>100 || $this->valorTipo<0)
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("El porcentaje no puede ser menor a 0% o mayor a 100%"));
			}
			else
				return parent::beforeSave();
		}
		
		if($this->tipoDescuento==1) // si es descuento en dinero no puede ser mayor al precio de venta
		{
			if($this->precioVenta < $this->valorTipo)
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("El monto de descuento no puede ser mayor al precio de venta"));
			}
			else
				return parent::beforeSave();			
		}

	}
	public function afterSave()
	{
		$historico=new HistoricoPrecio;
		$historico->costo =$this->costo;
		$historico->precioVenta =$this->precioVenta;
		$historico->precioDescuento =$this->precioDescuento ;
		$historico->precio_id =$this->id ;
		$historico->precioImpuesto =$this->precioImpuesto;
		$historico->fecha=date("Y-m-d h:i:s");
		$historico->user_id=Yii::app()->user->id;
		$historico->save();
		return parent::afterSave();			
	
	}
	
	public function getPrecioDescuento($producto)
	 {
		$precio= new Precio;	
		if($precio=Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto)))
			return $precio->precioDescuento;
		else
			return 0; 
		
	}
	 
	public function getLimites(){
		$sql="SELECT MAX(p.precioVenta) as maximo, MIN(p.precioVenta) as minimo from tbl_precio p WHERE p.tbl_producto_id IN( select id from tbl_producto where estado=0 and status=1)";
		return Yii::app()->db->createCommand($sql)->queryRow();
	}
	
	public function countxRango($min, $max){
		$sql="SELECT count(p.id) from tbl_precio p JOIN tbl_producto pr ON pr.id=p.tbl_producto_id  where pr.estado=0 AND pr.`status`=1 
		AND p.precioVenta >".$min." AND p.precioVenta <".$max;
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	
	
	
}