<?php

/**
 * This is the model class for table "{{masterData}}".
 *
 * The followings are the available columns in table '{{masterData}}':
 * @property integer $id
 * @property string $fecha_carga
 * @property integer $user_id
 * @property integer $prod_nuevos
 * @property integer $prod_actualizados
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class MasterData extends CActiveRecord
{
    
    const RUTA_ARCHIVOS = '/docs/xlsMasterData/';
    const TIPO_PRECIO = 1; // 0-sin iva, 1-con inva
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MasterData the static model class
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
		return '{{masterData}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_carga, user_id', 'required'),
			array('user_id, prod_nuevos, prod_actualizados', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha_carga, user_id, prod_nuevos, prod_actualizados', 'safe', 'on'=>'search'),
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
			'fecha_carga' => 'Fecha Carga',
			'user_id' => 'User',
			'prod_nuevos' => 'Prod Nuevos',
			'prod_actualizados' => 'Prod Actualizados',
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
		$criteria->compare('fecha_carga',$this->fecha_carga,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('prod_nuevos',$this->prod_nuevos);
		$criteria->compare('prod_actualizados',$this->prod_actualizados);
		$criteria->order = "fecha_carga DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /*Retorna la fecha de carga como timestamp*/
        public function getFecha() {
            return strtotime($this->fecha_carga);
        }  
        
        public function buscarProductos()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('masterdata_id',$this->id);        

            return new CActiveDataProvider("ItemMasterdata", array(
                'criteria'=>$criteria,
            ));
        }
        
        /**
         * @param SimpleXMLElement $docXml el documento ya construido
         * @param int $tipoArchivo para los distintos documentos que
         * se utilizan:
         * 1: MasterData
         * 2: Inbound
         * 3: Outbound
         * @param int $idSaved id o albaran del documento, usado para el nombre
         * del archivo xml enviado a LF
         * 
         * @return boolean para indicar si se pudosubir el archivo o no.
         * 
         */        
        public static function subirArchivoFtp($docXml, $tipoArchivo, $idSaved){

            /*
            URL: ftp.logisfashion.com
            usuario: personaling@ftp.logisfashion.com
            PAS: Personaling789
             */
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
            
            $nombre = "";
            $rutaArchivo = "";
            $fechaNombre = date("_Ymd_His");
            
            switch ($tipoArchivo){
                case 1:
                    $nombre = "MasterData";
                    $rutaArchivo = Yii::getPathOfAlias('webroot').self::RUTA_ARCHIVOS;                    
                break;
                
                case 2:
                    $nombre = "Inbound_".$idSaved;
                    $rutaArchivo = Yii::getPathOfAlias('webroot').Inbound::RUTA_ARCHIVOS;                    
                break;
            
                case 3:
                    $nombre = "Outbound_".$idSaved;
                    $rutaArchivo = Yii::getPathOfAlias('webroot').Outbound::RUTA_ARCHIVOS;                    
                break;
            
                default:
                    return false;            
            }
            
            // Armar el nombre del archivo con la fecha
            $nombre .= $fechaNombre."-001.xml";
            
            //Guardar en local
            $docXml->asXML($rutaArchivo.$idSaved.".xml");                                
            
            $nombreArchivo = $nombre;
            $archivo = tmpfile();
            fwrite($archivo, $docXml->asXML());
            fseek($archivo, 0);
            
            /* en pruebas dejarlos aparte, en produccion
             * subirlo a una carpeta especifica de produccion*/
            $directorio = "html/develop/develop/protected/data";
            if($enProduccion){                
                $directorio = "IN/";
            }            
            
            //realizar la conexion ftp
            $conexion = ftp_connect($ftpServer); 
            //loguearse
            $loginResult = ftp_login($conexion, $userName, $userPwd); 
            
            if ((!$conexion) || (!$loginResult)) {  
//                echo "¡La conexión FTP ha fallado!";
//                echo "Se intentó conectar al $ftpServer por el usuario $userName";
                fclose($archivo); 
                return false; 
            }
            //activar modo pasivo FTP
            ftp_pasv($conexion, true);            
//            echo "Conexión a $ftpServer realizada con éxito, por el usuario $userName";
            
            //ubicarse en el directorio a donde se subira el archivo
            ftp_chdir($conexion, $directorio);      
            
            //subir el archivo
            $upload = ftp_fput($conexion, $nombreArchivo, $archivo, FTP_BINARY);  

            // comprobar el estado de la subida
            if (!$upload) {  
//                echo "¡La subida FTP ha fallado!";
                fclose($archivo); 
                return false;               
            } else {
//                echo "<br>Subida de $nombreArchivo a $ftpServer con éxito";
            }

            // Cerrar/Borrar archivo
            fclose($archivo); 

            // cerrar la conexión ftp 
            ftp_close($conexion);
            
            //Marcar archivos como enviados
            if($tipoArchivo == 2) //Si es inbound
            {
                Inbound::model()->updateByPk($idSaved, array(
                   "estado" => 1, //Marcarlo como enviado 
                ));
            }    
            
            return true;
        }
        
}