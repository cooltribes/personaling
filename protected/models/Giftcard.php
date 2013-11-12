<?php

/*
 * ESTADOS DE LA GIFTCARD
 * 1. Inactiva
 * 2. Activa
 * 3. Aplicada
 */


/**
 * This is the model class for table "{{giftcard}}".
 *
 * The followings are the available columns in table '{{giftcard}}':
 * @property integer $id
 * @property string $codigo
 * @property double $monto
 * @property integer $estado
 * @property string $inicio_vigencia
 * @property string $fin_vigencia
 * @property string $fecha_uso
 * @property integer $comprador
 * @property integer $beneficiario
 *
 * The followings are the available model relations:
 * @property User $UserComprador
 * @property User $UserBeneficiario
 */
class Giftcard extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Giftcard the static model class
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
		return '{{giftcard}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, monto, estado, comprador', 'required'),
                        array('inicio_vigencia', 'required', 'message' => '¿Desde cuándo es válida la giftcard?'),
                        array('fin_vigencia', 'required', 'message' => '¿Hasta cuándo es válida la giftcard?'),
                        
                        array( 'inicio_vigencia','compare','compareValue' => date("Y-m-d"),'operator'=>'>=', 'allowEmpty'=>'false', 'message' => 'La fecha de inicio de vigencia debe ser mayor o igual a la fecha de hoy.'),
			array( 'fin_vigencia','compare','compareAttribute' => 'inicio_vigencia', 'operator'=>'>=', 'allowEmpty'=>'false', 'message' => 'La fecha de fin de vigencia debe ser mayor o igual a la fecha de inicio.'),
                    
                        array('codigo', 'unique', 'message'=>'Código de gift card ya registrado.'),
			array('estado, comprador, beneficiario', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
			array('codigo', 'length', 'max'=>25),
			array('fecha_uso', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, monto, estado, inicio_vigencia, fin_vigencia, fecha_uso, comprador, beneficiario', 'safe', 'on'=>'search'),
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
			'UserComprador' => array(self::BELONGS_TO, 'User', 'comprador'),
			'UserBeneficiario' => array(self::BELONGS_TO, 'User', 'beneficiario'),
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
			'monto' => 'Monto',
			'estado' => 'Estado',
			'inicio_vigencia' => 'Válida desde',
			'fin_vigencia' => 'Válida hasta',
			'fecha_uso' => 'Fecha Uso',
			'comprador' => 'Comprador',
			'beneficiario' => 'Beneficiario',
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
		$criteria->compare('monto',$this->monto);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('inicio_vigencia',$this->inicio_vigencia,true);
		$criteria->compare('fin_vigencia',$this->fin_vigencia,true);
		$criteria->compare('fecha_uso',$this->fecha_uso,true);
		$criteria->compare('comprador',$this->comprador);
		$criteria->compare('beneficiario',$this->beneficiario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         /**
         * This method is invoked before validation starts.
         * @return boolean whether validation should be executed. Defaults to true.
         */
        protected function beforeValidate() {

            if($this->inicio_vigencia){
                $this->inicio_vigencia = strtotime($this->inicio_vigencia);
                $this->inicio_vigencia = date('Y-m-d', $this->inicio_vigencia); 
            }
            
            
            if($this->fin_vigencia){
                $this->fin_vigencia = strtotime($this->fin_vigencia);
                $this->fin_vigencia = date('Y-m-d', $this->fin_vigencia); 
            }
            
            return parent::beforeValidate();
            
        }
        
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getInicioVigencia() {
            return strtotime($this->inicio_vigencia);
        }
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getFinVigencia() {
            return strtotime($this->fin_vigencia);
        }
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getFechaUso() {
            return strtotime($this->fecha_uso);
        }
        
        /*Si la GC fue creada por un admin*/
        public function comesFromAdmin() {
            return $this->UserComprador->superuser;
        }
        
        /*Retorna el codigo con formato*/
        public function getCodigo() {
            
            return implode("-", str_split($this->codigo, 4));
        }
}