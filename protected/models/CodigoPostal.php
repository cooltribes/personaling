<?php

/**
 * This is the model class for table "{{codigo_postal}}".
 *
 * The followings are the available columns in table '{{codigo_postal}}':
 * @property integer $id
 * @property string $codigo
 * @property integer $ciudad_id
 */
class CodigoPostal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CodigoPostal the static model class
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
		return '{{codigo_postal}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, ciudad_id', 'required'),
			array('ciudad_id', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, ciudad_id', 'safe', 'on'=>'search'),
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
			'codigo' => 'Codigo',
			'ciudad_id' => 'Ciudad',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('ciudad_id',$this->ciudad_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getCode($ciudad, $attribute){
        $code=$this->findAllByAttributes(array('ciudad_id'=>$ciudad));
        if(isset($code)){
            if(count($code)==1)
                return $code[0]->$attribute;
            else
                return $code[0]->$attribute;
        }
        return null;   
    }
    
}