<?php
	namespace Semdrops\SemdropsMobileBundle\Entity;
	
	class Constants {
		public $BASECONSULTA= "http://localhost:8080/openrdf-workbench/repositories/Semdrops/query?";
		public $BASEINSERCION= "http://localhost:8080/openrdf-sesame/repositories/Semdrops/statements";
		//public $BASECONSULTA= "http://cobani:8080/openrdf-workbench/repositories/semdrops/query?"; Para base de datos con Mysql
		//public $BASEINSERCION= "http://cobani:8080/openrdf-sesame/repositories/semdrops/statements"; Para base de datos con Mysql
		public $TREEDEPTH= 2; //profundidad del arbol de categorias, cantidad de padres
	}
?>
