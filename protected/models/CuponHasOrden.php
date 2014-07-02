<?php

/**
 * This is the model class for table "{{cupon_has_orden}}".
 *
 * The followings are the available columns in table '{{cupon_has_orden}}':
 * @property integer $cupon_id
 * @property integer $orden_id
 * @property double $descuento
 *
 * The followings are the available model relations:
 * @property CodigoDescuento $cupon
 * @property Orden $orden
 */
class CuponHasOrden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CuponHasOrden the static model class
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
		return '{{cupon_has_orden}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cupon_id, orden_id, descuento', 'required'),
			array('cupon_id, orden_id', 'numerical', 'integerOnly'=>true),
			array('descuento', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cupon_id, orden_id, descuento', 'safe', 'on'=>'search'),
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
			'cupon' => array(self::BELONGS_TO, 'CodigoDescuento', 'cupon_id'),
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cupon_id' => 'Cupon',
			'orden_id' => 'Orden',
			'descuento' => 'Descuento',
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

		$criteria->compare('cupon_id',$this->cupon_id);
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('descuento',$this->descuento);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function clienteUsoCupon($id){
            
            $user = User::model()->findByPk(Yii::app()->user->id);
            $ordenesUsuario = $user->ordenes;
            
            foreach($ordenesUsuario as $orden){
                if($orden->hasCupon($id)){
                    return true;
                }
            }
            
            return false;
            
        }
        
}