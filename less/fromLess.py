#!/usr/bin/env python
#
	# Autor: Carlos Linares @calosth
	# Fecha: 5 de Agosto 2013
#

import os
import sys

#ejecutar comando para generar el .css
try:

	if( len(sys.argv) > 1):
		nameDelArchivo = sys.argv[1]
		ruta = "../themes/bootstrap/css/"
		#ruta por defecto de
		if(len(sys.argv) > 2):
			ruta = sys.argv[2]

		os.system("lessc " +nameDelArchivo+ ".less > "+nameDelArchivo+".css -x --yui-compress" )
		fileOrigen = open( "%s.css" %nameDelArchivo , "r" ) #leer archivo
		fileDestino = open("%s%s.css" %(ruta ,nameDelArchivo) , "w" )
		fileDestino.write(fileOrigen.read()) #ecribir archivo
		os.system("rm %s.css" %nameDelArchivo )
		print "Listo! CSS generado :)"
	else:
		print "\t\tError"
		print "\tPrimer parametro: nombre del archivo"
		print "\tSegundo parametro: ruta del archivo (Default es: )\n"


except Exception, e:
	print "Hubo un problema con la ruta"
	# raise " Problema"+e

# f.close()