<?php

/**
 * This is the model class for table "{{user_promocion}}".
 *
 * The followings are the available columns in table '{{user_promocion}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $promocion_id
 * @property double $valor
 * @property string $fecha
 * @property string $observacion
 */
class UserPromocion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPromocion the static model class
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
		return '{{user_promocion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valor', 'required'),
			array('user_id, promocion_id', 'numerical', 'integerOnly'=>true),
			array('valor', 'numerical'),
			array('observacion', 'length', 'max'=>200),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, promocion_id, valor, fecha, observacion', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'promocion_id' => 'Promocion',
			'valor' => 'Valor',
			'fecha' => 'Fecha',
			'observacion' => 'Observacion',
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
		$criteria->compare('promocion_id',$this->promocion_id);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('observacion',$this->observacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function countxValor($valor){
        return count($this->findAllByAttributes(array('valor'=>$valor)));
    }
}