<?php

/**
 * This is the model class for table "{{logModificacion}}".
 *
 * The followings are the available columns in table '{{logModificacion}}':
 * @property integer $id
 * @property string $tabla
 * @property string $columna
 * @property integer $id_elemento
 * @property string $valor_anterior
 * @property string $valor_nuevo
 * @property string $fecha
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class LogModificacion extends CActiveRecord
{
    const T_PrecioTallaColor = "Preciotallacolor";

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogModificacion the static model class
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
		return '{{logModificacion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabla, columna, id_elemento, valor_anterior, valor_nuevo, fecha, user_id', 'required'),
			array('id_elemento, user_id', 'numerical', 'integerOnly'=>true),
			array('tabla, columna, valor_anterior, valor_nuevo', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tabla, columna, id_elemento, valor_anterior, valor_nuevo, fecha, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tabla' => 'Tabla',
			'columna' => 'Columna',
			'id_elemento' => 'Id Elemento',
			'valor_anterior' => 'Valor Anterior',
			'valor_nuevo' => 'Valor Nuevo',
			'fecha' => 'Fecha',
			'user_id' => 'User',
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
		$criteria->compare('tabla',$this->tabla,true);
		$criteria->compare('columna',$this->columna,true);
		$criteria->compare('id_elemento',$this->id_elemento);
		$criteria->compare('valor_anterior',$this->valor_anterior,true);
		$criteria->compare('valor_nuevo',$this->valor_nuevo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getCampo(){
            if($this->columna == "cantidad"){
                return "Cantidad";
            }           
            
            return $this->columna;
        }
}