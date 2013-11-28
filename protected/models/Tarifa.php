<?php

/**
 * This is the model class for table "{{tarifa}}".
 *
 * The followings are the available columns in table '{{tarifa}}':
 * @property integer $id
 * @property double $minimo
 * @property double $maximo
 * @property double $precio
 * @property double $tasa_postal
 * @property double $iva
 * @property double $total
 * @property integer $ruta_id
 *
 * The followings are the available model relations:
 * @property Ruta $ruta
 */
class Tarifa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tarifa the static model class
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
		return '{{tarifa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruta_id', 'numerical', 'integerOnly'=>true),
			array('minimo, maximo, precio, tasa_postal, iva, total', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, minimo, maximo, precio, tasa_postal, iva, total, ruta_id', 'safe', 'on'=>'search'),
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
			'ruta' => array(self::BELONGS_TO, 'Ruta', 'ruta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'minimo' => 'Minimo',
			'maximo' => 'Maximo',
			'precio' => 'Precio',
			'tasa_postal' => 'Tasa Postal',
			'iva' => 'Iva',
			'total' => 'Total',
			'ruta_id' => 'Ruta',
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
		$criteria->compare('minimo',$this->minimo);
		$criteria->compare('maximo',$this->maximo);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('tasa_postal',$this->tasa_postal);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('ruta_id',$this->ruta_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function calcularEnvio($peso, $ruta){
		$sql="SELECT total from tbl_tarifa WHERE ".$peso."> minimo AND ".$peso."<= maximo AND ruta_id = ".$ruta;	
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}
}