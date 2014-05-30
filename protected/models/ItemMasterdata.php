<?php
/* ESTADOS
 * 0. Nuevo
 * 1. Actualizado 
 */

/**
 * This is the model class for table "{{itemMasterdata}}".
 *
 * The followings are the available columns in table '{{itemMasterdata}}':
 * @property integer $id
 * @property integer $producto_id
 * @property integer $masterdata_id
 * @property integer $estado
 * @property integer $tipo_actualizacion
 *
 * The followings are the available model relations:
 * @property PrecioTallaColor $producto
 * @property MasterData $masterdata
 */
class ItemMasterdata extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItemMasterdata the static model class
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
		return '{{itemMasterdata}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('producto_id, masterdata_id', 'required'),
			array('producto_id, masterdata_id, estado, tipo_actualizacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, producto_id, masterdata_id, estado, tipo_actualizacion', 'safe', 'on'=>'search'),
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
			'producto' => array(self::BELONGS_TO, 'Preciotallacolor', 'producto_id'),
			'masterdata' => array(self::BELONGS_TO, 'MasterData', 'masterdata_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'producto_id' => 'Producto',
			'masterdata_id' => 'Masterdata',
			'estado' => 'Estado',
			'tipo_actualizacion' => 'Tipo Actualizacion',
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
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('masterdata_id',$this->masterdata_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('tipo_actualizacion',$this->tipo_actualizacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /*Retorna El estado*/
        public function getEstado() {
            $status = "Nuevo";
            switch ($this->estado){                
                case 1: $status = "Actualizado"; break;                
            }
            return $status;
        }
        
}