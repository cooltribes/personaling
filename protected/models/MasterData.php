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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function subirArchivoFtp($xml, $nombre){

            /*
            URL: ftp.logisfahion.com
            usuario: personaling@ftp.logisfashion.com
            PAS: Personaling789
             */
            
            $ftpServer = "localhost";
            $userName = "personaling";
            $userPwd = "P3rs0n4l1ng";
            
            $nombreArchivo = $nombre;//"Outbound.xml";
            $archivo = tmpfile();
            fwrite($archivo, $xml->asXML());
            fseek($archivo, 0);
            
            $directorio = "html/develop/develop/protected/data";
            
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
            } else {
//                echo "<br>Subida de $nombreArchivo a $ftpServer con éxito";
            }
            
//            echo "<br>Directorio: ".ftp_pwd($conexion);

            // Cerrar/Borrar archivo
            fclose($archivo); 

            // cerrar la conexión ftp 
            ftp_close($conexion);
            
            return true;
        }
        
}