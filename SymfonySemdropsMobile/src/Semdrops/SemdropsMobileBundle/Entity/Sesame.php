<?php

namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Constants;
class Sesame {
	
	private $urls; // = new Constants();
	
	    	
	public function writeACategory($aCategory) {
    $datos= '<'.$aCategory->getUri().'> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#'.$aCategory->getCategory().'>.';//Se arman los datos para guardarlos en la base de datos
    return $this-> writeInSesameDataBase($datos);	
    }
    
	public function writeAProperty($aProperty) {
	$datos= '<'.$aProperty->getUri().'> <http://semdrops.lifia.edu.ar/ns/property#'.$aProperty->getPropertyTag().'> <'.$aProperty->getDestino().'>.';
    return $this-> writeInSesameDataBase($datos);
	} 
	
	function writeInSesameDataBase($datos) {
	   $urls = new Constants(); 	
       $request_body =$datos;
       $ch = curl_init($urls->BASEINSERCION);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//True
       curl_setopt($ch, CURLOPT_HEADER, 0);//false
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/plain', 'charset=UTF-8'));
       curl_setopt($ch, CURLOPT_POST, TRUE); 
       //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//true
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       $response = curl_exec($ch);
       curl_close($ch);
       return $response;
	}
}
