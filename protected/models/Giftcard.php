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
 * @property integer $orden_id
 *
 * The followings are the available model relations:
 * @property User $UserComprador
 * @property User $UserBeneficiario
 * @property OrdenGC $Orden
 */
class Giftcard extends CActiveRecord
{
    
        /*CAMBIAR ESTA CONSTANTE CUANDO SE REQUIERA CAMBIAR LA LONGITUD DEL CODIGO DE UNA TARJETA*/
        const DIGITOS_CODIGO = 16;
        
        const MAX_MONTO = 1000;
    
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
                        
                        array( 'inicio_vigencia','compare','compareValue' => date("Y-m-d"),'operator'=>'>=', 'allowEmpty'=>'false', 
                            'message' => 'La fecha de inicio de vigencia debe ser mayor o igual a la fecha de hoy.', 'on' => 'insert'),
			array( 'fin_vigencia','compare','compareAttribute' => 'inicio_vigencia', 'operator'=>'>=', 'allowEmpty'=>'false', 
                            'message' => 'La fecha de fin de vigencia debe ser mayor o igual a la fecha de inicio.', 'on' => 'insert'),
                    
                        array('codigo', 'unique', 'message'=>'Código de gift card ya registrado.'),
			array('estado, comprador, beneficiario', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical', 'max' => self::MAX_MONTO),
			array('codigo', 'length', 'max'=>25),
			array('fecha_uso', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, monto, estado, inicio_vigencia, fin_vigencia, fecha_uso, comprador, beneficiario, orden_id', 'safe', 'on'=>'search'),
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
			'Orden' => array(self::BELONGS_TO, 'OrdenGC', 'orden_id'),
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
			'orden_id' => 'Orden',
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
		$criteria->compare('orden_id',$this->orden_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Busca las Giftcards del usuario
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function giftcardsUser()
	{
		
		$criteria=new CDbCriteria;

		
		$criteria->compare('comprador',  Yii::app()->user->id);
		//$criteria->compare('beneficiario',$this->beneficiario);
		

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
        
        /*Retorna los ultimos 4 digitos del codigo con formato*/
        public function getMascaraCodigo() {
            
            return 'XXXX-XXXX-XXXX-'.substr($this->codigo, 12,14);
        }
        
        static function generarCodigo(){
            $cantNum = 8;
            $cantLet = 8;
            
            $l = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            $LETRAS = str_split($l);
            $NUMEROS = range(0, 9);

            $codigo = array();
            //Seleccionar cantLet letras
            for ($i = 0; $i < $cantLet; $i++) {
                $codigo[] = $LETRAS[array_rand($LETRAS)];
            }
            for ($i = 0; $i < $cantNum; $i++) {
                $codigo[] = array_rand($NUMEROS);
            }
            
            shuffle($codigo);

            $codigo = implode("", $codigo);
            
            return $codigo;
        }

}