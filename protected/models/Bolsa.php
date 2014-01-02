<?php

/**
 * This is the model class for table "{{bolsa}}".
 *
 * The followings are the available columns in table '{{bolsa}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property LookHasTblBolsa[] $lookHasTblBolsas
 * @property LookHasTblBolsa[] $lookHasTblBolsas1
 * @property Orden[] $ordens
 * @property Orden[] $ordens1
 */
class Bolsa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bolsa the static model class
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
		return '{{bolsa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('created_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, created_on', 'safe', 'on'=>'search'),
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
			'lookHasTblBolsas' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_bolsa_id'),
			'lookHasTblBolsas1' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_bolsa_user_id'),
			'ordens' => array(self::HAS_MANY, 'Orden', 'tbl_bolsa_id'),
			'ordens1' => array(self::HAS_MANY, 'Orden', 'user_id'),
			'bolsahasproductos' => array(self::HAS_MANY,'BolsaHasProductotallacolor','bolsa_id'),
			'countproductos' => array(self::STAT, 'BolsaHasProductotallacolor', 'bolsa_id',
            		'select' => 'SUM(cantidad)'
        		),
		); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'created_on' => 'Created On',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function actualizar() //actualiza las cantidades a los productos
	{
		$bandera = false;	
		foreach($this->bolsahasproductos as $producto)
		{
				
			if ($producto->cantidad > $producto->preciotallacolor->cantidad)
			{
				$producto->cantidad = $producto->preciotallacolor->cantidad;
				$bandera = true;
				$producto->save();
			}
		}
		//if ($bandera)
		//	$this->save();
		return $bandera;
	}
	public function checkInventario(){
		foreach($this->bolsahasproductos as $producto)
		{
				
			if ($producto->cantidad > $producto->preciotallacolor->cantidad)
			{
				return false;
			}
		}
		return true;
	}
	public function looks()
	{
		
		$sql = "select look_id from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$this->id." group by look_id";
		return Yii::app()->db->createCommand($sql)->queryColumn();
		
	}
	
	public function deleteInactivos(){
		$return=false;
		foreach($this->bolsahasproductos as $productobolsa){
			if($productobolsa->preciotallacolor->producto->status==0 ||
                           $productobolsa->preciotallacolor->producto->estado==1 ||
                           $productobolsa->cantidad == 0){
				if($productobolsa->delete())
					$return=true; 
			}
		}
		return $return;
	}

 /*
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('bolsahasproducto');
		$criteria->group='bolsahasproducto.look_id';
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
*/	
	public function addProducto($producto_id,$talla_id,$color_id,$look_id=0)
	{
		
			$carrito = $this;
			$ptcolor = Preciotallacolor::model()->findByAttributes(array('producto_id'=>$producto_id,'talla_id'=>$talla_id,'color_id'=>$color_id));
			
			//revisar si está o no en el carrito
			
			$nuevo = BolsaHasProductotallacolor::model()->findByPk(array('bolsa_id'=>$this->id,'preciotallacolor_id'=>$ptcolor->id,'look_id'=>$look_id));
			
			if(isset($nuevo)) // existe
			{
				$cantidadnueva = $nuevo->cantidad + 1;
				BolsaHasProductotallacolor::model()->updateByPk(array('bolsa_id'=>$this->id,'preciotallacolor_id'=>$nuevo->preciotallacolor_id,'look_id'=>$look_id), array('cantidad'=>$cantidadnueva));
				return "ok";
							 
			}
			else{ // si el producto es nuevo en la bolsa
			
				$pn = new BolsaHasProductotallacolor;
				$pn->bolsa_id = $carrito->id;
				$pn->preciotallacolor_id = $ptcolor->id;
				$pn->cantidad = 1;
				if ($look_id != 0)
					$pn->look_id = $look_id;	
				if($pn->save())
				{// en bolsa tengo id de usuario e id de bolsa
				
					return "ok";
				}
					
			}  
		return "fail";	
	}
}