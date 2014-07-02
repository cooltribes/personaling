<?php

/**
 * ----------------------
 * ESTADOS DE LOGIS FASHION
 * 0 - enviado a lf
 * 1 - confirmado por lf
 * 2 - anulada checking
 * 3 - anulada picking
 * 4 - finalizada (paquete armado para enviar)
 * 5 - enviada
 * 
 * This is the model class for table "{{outbound}}".
 *
 * The followings are the available columns in table '{{outbound}}':
 * @property integer $id
 * @property integer $orden_id
 * @property integer $estado
 * @property integer $discrepancias
 * @property integer $cantidad_bultos
 *
 * The followings are the available model relations:
 * @property Orden $orden
 */
class Outbound extends CActiveRecord
{
    
    const RUTA_ARCHIVOS = '/docs/xlsOutbound/';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Outbound the static model class
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
		return '{{outbound}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orden_id', 'required'),
			array('orden_id, estado, discrepancias, cantidad_bultos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orden_id, estado, discrepancias, cantidad_bultos', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orden_id' => 'Orden',
			'estado' => 'Estado',
			'discrepancias' => 'Discrepancias',
			'cantidad_bultos' => 'Cantidad Bultos',
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
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('discrepancias',$this->discrepancias);
		$criteria->compare('cantidad_bultos',$this->cantidad_bultos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}