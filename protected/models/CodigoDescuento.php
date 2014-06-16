<?php
/*
 * ESTADOS DEL CODIGO:
 * 0. Inactivo
 * 1. Activo
 * 
 * TIPO DE DESCUENTO:
 * 0 - Porcentaje
 * 1 - Fijo
 */
/**
 * This is the model class for table "{{codigoDescuento}}".
 *
 * The followings are the available columns in table '{{codigoDescuento}}':
 * @property integer $id
 * @property integer $estado
 * @property string $codigo
 * @property double $descuento
 * @property integer $tipo_descuento
 * @property integer $creador
 * @property string $inicio_vigencia
 * @property string $fin_vigencia
 * @property string $plantilla_url
 * 
 * The followings are the available model relations:
 * @property Users $userCreador
 */
class CodigoDescuento extends CActiveRecord
{   
    
    //Estados
    public static $estados = array(0 => "Inactivo", 1 => "Activo");
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CodigoDescuento the static model class
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
		return '{{codigoDescuento}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo', 'required', "message" => "Debes ingresar el código de descuento"),
			array('descuento', 'required', "message" => "Debes ingresar un monto o porcentaje"),
			array('estado, tipo_descuento, creador', 'required'),
                        array('inicio_vigencia', 'required', 'message' => '¿Desde cuándo es válido el código?'),
                        array('fin_vigencia', 'required', 'message' => '¿Hasta cuándo es válido el código?'),
                    
                        array( 'inicio_vigencia','compare','compareValue' => date("Y-m-d"),'operator'=>'>=', 'allowEmpty'=>'false', 
                            'message' => 'La fecha de inicio de vigencia debe ser mayor o igual a la fecha de hoy.', 'on' => 'insert'),
			array( 'fin_vigencia','compare','compareAttribute' => 'inicio_vigencia', 'operator'=>'>=', 'allowEmpty'=>'false', 
                            'message' => 'La fecha de fin de vigencia debe ser mayor o igual a la fecha de inicio.', 'on' => 'insert'),                    
                    
                        array('codigo', 'unique', 'message'=>'Código de Descuento ya registrado.'),
			array('estado, tipo_descuento', 'numerical', 'integerOnly'=>true),			
                        array('descuento', 'numerical'),
//                        array('descuento', 'numerical', 'max' => self::getMontoMaximo()),

			array('codigo', 'length', 'max'=>256),
			array('plantilla_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, estado, codigo, descuento, tipo_descuento, creador, inicio_vigencia, fin_vigencia, plantilla_url', 'safe', 'on'=>'search'),
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
                    'userCreador' => array(self::BELONGS_TO, 'User', 'creador'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estado' => 'Estado',
			'codigo' => 'Código',
			'descuento' => 'Descuento',
			'tipo_descuento' => 'Tipo de Descuento',
			'inicio_vigencia' => 'Válido desde',
			'fin_vigencia' => 'Válido hasta',
			'plantilla_url' => 'Plantilla Url',
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
		$criteria->compare('estado',$this->estado);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('tipo_descuento',$this->tipo_descuento);
                $criteria->compare('creador',$this->creador);
		$criteria->compare('inicio_vigencia',$this->inicio_vigencia,true);
		$criteria->compare('fin_vigencia',$this->fin_vigencia,true);
		$criteria->compare('plantilla_url',$this->plantilla_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public static function getTiposDescuento($value = null) {
           $array  = array(0 => "Porcentaje (%)",
                    1 => "Fijo (" . Yii::t('backEnd', 'currSym') . ")");                   

           return $array;
        }
        public static function getEstados() {
           
           return self::$estados;
        }
        public function getEstado() {
           
           return self::$estados[$this->estado];
        }
        public function getDescuento() {
           
           $array  = array(0 => "%",
                    1 => Yii::t('backEnd', 'currSym')); 
           
           return Yii::app()->numberFormatter->formatCurrency($this->descuento, ''). $array[$this->tipo_descuento];
           
        }
        
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getInicioVigencia() {
            return strtotime($this->inicio_vigencia);
        }
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getFinVigencia() {
            return strtotime($this->fin_vigencia);
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
        
        //Revisa fechas y estado
        public function esValido(){
            
            $now = time();
            $validoFecha = $this->getInicioVigencia() < $now && $now < $this->getFinVigencia();
            
                    
            return $this->estado == 1 && $validoFecha;
        }
                
        
}