<?php
/*
 * Tipos de Pago 
 * 0:Paypal
 * 1:Cuenta
 */

/*
 * Estados del pago
 * 0:Solicitado
 * 1:Aprobado
 * 2:Rechazado
 */


/**
 * This is the model class for table "{{pago}}".
 *
 * The followings are the available columns in table '{{pago}}':
 * @property integer $id
 * @property integer $estado
 * @property double $monto
 * @property string $fecha_solicitud
 * @property string $fecha_respuesta
 * @property integer $user_id
 * @property integer $admin_id
 * @property integer $tipo
 * @property integer $entidad
 * @property string $cuenta
 * @property integer $id_transaccion
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Users $admin
 */
class Pago extends CActiveRecord
{
    //Tipos de pago
    public static $tiposPago = array(
                        "PayPal",
                        "Cuenta Bancaria",        
                        );
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Pago the static model class
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
        return '{{pago}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, admin_id, tipo, entidad, cuenta', 'required'),
            array('estado, user_id, admin_id, tipo, entidad, id_transaccion', 'numerical', 'integerOnly'=>true),
            array('monto', 'numerical'),
            array('cuenta', 'length', 'max'=>140),
            array('fecha_solicitud, fecha_respuesta', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, estado, monto, fecha_solicitud, fecha_respuesta, user_id, admin_id, tipo, entidad, cuenta, id_transaccion', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'admin' => array(self::BELONGS_TO, 'Users', 'admin_id'),
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
            'monto' => 'Monto',
            'fecha_solicitud' => 'Fecha Solicitud',
            'fecha_respuesta' => 'Fecha Respuesta',
            'user_id' => 'User',
            'admin_id' => 'Admin',
            'tipo' => 'Tipo',
            'entidad' => 'Entidad',
            'cuenta' => 'Cuenta',
            'id_transaccion' => 'Id Transaccion',
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
        $criteria->compare('monto',$this->monto);
        $criteria->compare('fecha_solicitud',$this->fecha_solicitud,true);
        $criteria->compare('fecha_respuesta',$this->fecha_respuesta,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('admin_id',$this->admin_id);
        $criteria->compare('tipo',$this->tipo);
        $criteria->compare('entidad',$this->entidad);
        $criteria->compare('cuenta',$this->cuenta,true);
        $criteria->compare('id_transaccion',$this->id_transaccion);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
     public static function getTiposPago() {
            
        return self::$tiposPago; 
    }
    
}