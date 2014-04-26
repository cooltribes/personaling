<?php

/**
 * This is the model class for table "{{tarifa}}".
 *
 * The followings are the available columns in table '{{tarifa}}':
 * @property integer $id
 * @property double $minimo
 * @property double $maximo
 * @property double $precio
 * @property double $tasa_postal
 * @property double $iva
 * @property double $total
 * @property integer $ruta_id
 *
 * The followings are the available model relations:
 * @property Ruta $ruta
 */
class Tarifa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tarifa the static model class
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
		return '{{tarifa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruta_id', 'numerical', 'integerOnly'=>true),
			array('minimo, maximo, precio, tasa_postal, iva, total', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, minimo, maximo, precio, tasa_postal, iva, total, ruta_id', 'safe', 'on'=>'search'),
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
			'ruta' => array(self::BELONGS_TO, 'Ruta', 'ruta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'minimo' => 'Minimo',
			'maximo' => 'Maximo',
			'precio' => 'Precio',
			'tasa_postal' => 'Tasa Postal',
			'iva' => 'Iva',
			'total' => 'Total',
			'ruta_id' => 'Ruta',
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
		$criteria->compare('minimo',$this->minimo);
		$criteria->compare('maximo',$this->maximo);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('tasa_postal',$this->tasa_postal);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('total',$this->total);
		$criteria->compare('ruta_id',$this->ruta_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function calcularEnvio($peso, $ruta){
		$sql="SELECT total from tbl_tarifa WHERE ".$peso."> minimo AND ".$peso."<= maximo AND ruta_id = ".$ruta;	
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}
	
	public function envioSeur($ciudad,$postal,$peso){
		$soapclient = new SoapClient('https://ws.seur.com/WSEcatalogoPublicos/servlet/XFireServlet/WSServiciosWebPublicos?wsdl');	
		$xml = new SimpleXMLElement('<REG/>');
		//$xml->addChild("REG");
		$xml->USUARIO = "WSPERSONALING";
		$xml->PASSWORD = "ORACLE";
		$xml->NOM_POBLA_DEST = utf8_encode($ciudad); 
		$xml->CODIGO_POSTAL_DEST = $postal;
		$xml->Bultos = "1";
		$xml->Peso = $peso;
		$xml->CodContableRemitente = "32532-54";
		$xml->PesoVolumen = "1";
		$xml->CodServ = "1";
		$xml->CodProd = "2";
		$xml->FechaVigenciaTasacion = "20110918";
		$xml->SERVICIOS_COMPLEMENTARIOS = "";
		$xml->COD_IDIOMA = "ES";
		
		/*$in = array(
			'in0'=>$xml->asXML(),
		);*/
		$in = new stdClass();
		$in->in0 = $xml->asXML();
		$response=$soapclient->tarificacionPrivadaStr($in);
		$xmlresponse = simplexml_load_string($response->out);
		if(isset($xmlresponse->REG[2]))
		{			
			$return['porte']=$xmlresponse->REG[0]->VALOR[0];
			$return['iva']=$xmlresponse->REG[1]->VALOR[0];
			$return['combustible']=$xmlresponse->REG[2]->VALOR[0];
			return $return;
		}
		else 
			return;
		

		
	}
	
	

}