<?php

/**
 * This is the model class for table "{{return}}".
 *
 * The followings are the available columns in table '{{return}}':
 * @property integer $id
 * @property integer $devolucion_id
 * @property string $estado
 * @property string $fechaEstado
 * @property string $motivo
 * @property integer $enviado
 */
class Retturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Retturn the static model class
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
		return '{{return}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('devolucion_id, enviado', 'numerical', 'integerOnly'=>true),
			array('estado', 'length', 'max'=>50),
			array('motivo', 'length', 'max'=>500),
			array('fechaEstado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, devolucion_id, estado, fechaEstado, motivo, enviado', 'safe', 'on'=>'search'),
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
			'devolucion_id' => 'Devolucion',
			'estado' => 'Estado',
			'fechaEstado' => 'Fecha Estado',
			'motivo' => 'Motivo',
			'enviado' => 'Enviado',
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
		$criteria->compare('devolucion_id',$this->devolucion_id);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fechaEstado',$this->fechaEstado,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('enviado',$this->enviado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	function getConfirmation($id){
            
            $enProduccion = strpos(Yii::app()->baseUrl, "develop") == false 
                && strpos(Yii::app()->baseUrl, "test") == false;
            
            $ftpServer = "localhost";
            $userName = "personaling";
            $userPwd = "P3rs0n4l1ng";            

            if($enProduccion){
                $ftpServer = "ftp.logisfashion.com";
                $userName = "personaling@ftp.logisfashion.com";
                $userPwd = "Personaling789"; 
            }       
            
            $tipoArchivo = "ReturnStatus_";
            $rutaArchivo = Yii::getPathOfAlias('webroot').Devolucion::RUTA_RETURN;        
            
            /* Directorio OUT donde estan los confirmation*/
            $directorio = "html/develop/develop/protected/OUT/";
            if($enProduccion){
                $directorio = "OUT/"; // En LogisFashion
            }
            
            //realizar la conexion ftp
            $conexion = ftp_connect($ftpServer); 
            $loginResult = ftp_login($conexion, $userName, $userPwd); 
            
            if ((!$conexion) || (!$loginResult)) {  
                return false; 
            }        
            
            //ubicarse en el directorio y obtener un listado
            ftp_chdir($conexion, $directorio);  
            $listado = ftp_nlist($conexion, "");
            $nombreArchivo =  $tipoArchivo.$id."_";

            $encontrado = false;
            
            foreach ($listado as $arch){
                
                //Si ya ha sido cargado el inbound                
                if(strpos($arch, $nombreArchivo) !== false){                                       
                    //Descargar el archivo
                    if(ftp_get($conexion, $rutaArchivo.$arch, $arch, FTP_BINARY)){
                       
                    }            
                    
                    $xml = simplexml_load_file($rutaArchivo.$arch);   
                    $conDiscrepancias = false;                    
                    
                    foreach ($xml as $elemento){
                        
                        if($elemento->getName() == "Item"){
                            
                            //Consultar en BD
                            $item = ItemReturn::model()->with(array(
                                        "producto" => array(
                                            "condition" => "sku = '".$elemento->EAN."'",
                                        )
                                    ))->findByAttributes(array(
                                        "return_id"=>$id,
                                        ));
                            //Guardar lo que viene en el XML
                            $item->cantidadConfirmation = $elemento->Cantidad;
                            
                            if($item->cantidadConfirmation != $item->cant_enviada){
                                $conDiscrepancias = true; //para marcar el inbound completo
                                                       
                            $item->save();   
                        }                        
                    }
                    
                    //Marcar inbound con estado
                    $return= Retturn::model()->findByPk($id);
                    if($conDiscrepancias){
                        $return->estado = 3;
                    }else{
                        $return->estado = 2;                        
                    }
                    $return->save();
                    
                    $encontrado = true;
                    break;
                }
            }
            // cerrar la conexión ftp 
            ftp_close($conexion);
            
        }
}
	
}