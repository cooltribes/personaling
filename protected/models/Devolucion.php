<?php

/**
 * This is the model class for table "{{devolucion}}".
 *
 * The followings are the available columns in table '{{devolucion}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $orden_id
 * @property string $fecha
 * @property integer $estado
 * @property double $montodevuelto
 * @property double $montoenvio
 *
 * The followings are the available model relations:
 * @property Orden $orden
 * @property Users $user
 */
class Devolucion extends CActiveRecord
{
	const RUTA_RETURN = '/docs/xlsReturn/';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Devolucion the static model class
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
		return '{{devolucion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, orden_id, fecha, estado, montodevuelto, montoenvio', 'required'),
			array('user_id, orden_id, estado', 'numerical', 'integerOnly'=>true),
			array('montodevuelto, montoenvio', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, orden_id, fecha, estado, montodevuelto, montoenvio', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'dptcs' => array(self::HAS_MANY, 'Devolucionhaspreciotallacolor','devolucion_id'),

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
			'orden_id' => 'Orden',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
			'montodevuelto' => 'Montodevuelto',
			'montoenvio' => 'Montoenvio',
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
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('montodevuelto',$this->montodevuelto);
		$criteria->compare('montoenvio',$this->montoenvio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	 
	public function getReasons($id = null){
		$reasons=array("No se parece a la imagen de la web",
							"Se ve de baja calidad  producto defectuoso",
							"No es mi talla","No me gusta como me queda la prenda",
							"El producto que he recibido esta equivocado",
							"He comprado mas de una talla");
		if(is_null($id)||$id>=count($reasons))
			return $reasons; 
		else 
			return $reasons[$id];
	}
	public function getStatus($id = null){
		$statuses=array("Devolucion solicitada",
							"Notificado a Almacén",
							"Confirmado por Almacén",
							"Devolución Completada",
							"Devolución Rechazada por Administrador",
							"Devolución Aceptada por Administrador");
		if(is_null($id)||$id>=count($statuses))
			return $statuses; 
		else 
			return $statuses[$id];
	}
	public function devueltosxOrden($orden,$ptcid,$lookid){
		$sql="select sum(cantidad) from tbl_devolucion_has_preciotallacolor dh 
		JOIN tbl_devolucion d  where dh.preciotallacolor_id=".$ptcid." 
		AND dh.look_id=".$lookid." AND d.orden_id=".$orden;
		$cant=Yii::app()->db->createCommand($sql)->queryScalar();
		if(is_null($cant))
			return 0;
		else
			return $cant;
		
	}
	function sendXML(){
            
            $return = new SimpleXMLElement('<Return/>');
            $returnDB=new Retturn;
			$returnDB->setAttributes(array('devolucion_id'=>$this->id,'motivo'=>'Ropa Fea'));
			$returnDB->save();
			
            //Codigo de Albaran

            $return->addChild('Albaran', $this->id);
            
            //Fecha de Albaran
            $fecha = date("Y-m-d", strtotime($this->fecha));
            $return->addChild("FechaAlbaran", "{$fecha}");
			$return->addChild("MotivoDevolucion", $this->motivosString);
			$return->addChild("Outbound", $this->orden_id);             
            //Cliente - Usuario

            
            foreach ($this->dptcs as $dhptc) {
                $itemR=new ItemReturn;
				$itemR->setAttributes(array('return_id'=>$returnDB->id,'devolucionhaspreciotallacolor_id'=>$dhptc->id,'cantidad'=>$dhptc->cantidad));
                $itemR->save();
                $item = $return->addChild("Item");                
                //Agregar el SKU
                $item->addChild("EAN", "{$dhptc->preciotallacolor->sku}");
                //Agregar la cantidad vendida.                
                $item->addChild("Cantidad", "{$dhptc->cantidad}");                
                
            }            

            //Guardar return en la BD
         //   $returnBD = new ReturnXSD();
           // $returnBD->orden_id = $orden->id;
            //discrep, estado, cantBultos por defecto en 0
            
            
            //Enviar return a LF y guardarlo en local para respaldo
            $subido = MasterData::subirArchivoFtp($return, 4, $this->id);
           	if($subido){
           		$returnDB->enviado=1;
				$returnDB->save();
				return true;
           	}
            return false;
        }
		public function getMotivosString(){
			$motivos="";	
			foreach ($this->dptcs as $key=>$dhptc) {
				$motivos=$motivos."[".$dhptc->preciotallacolor->sku."]=>".$dhptc->motivo;
				if($key<count($this->dptcs)-1){
					$motivos=$motivos.",";
				}
			}
			return $motivos;
			
		}
	
}