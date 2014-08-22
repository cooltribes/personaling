<?php
/**
 * Helper para que se agreguen todas las funciones de uso general que puedan ser
 * usadas en cualquier lugar de la aplicación
 *
 * Nelson Ramírez nramirez@upsidecorp.ch
 * 2014-08-21 
 */

class Funciones {

	/**
	 * Para cuando se necesiten hacer cosas específicas en develop y test
         * 
	 * @return  boolean Si está en entorno de pruebas (Test o Develop)
	 */
	public static function isDevTest()
	{
		return strpos(Yii::app()->baseUrl, "develop") !== false 
                        || strpos(Yii::app()->baseUrl, "test") !== false;

	}

	

}