<?php

namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Constants;
require_once 'functions.php'; 
require_once ("QueryPath/QueryPath.php");  	
class Sesame {
	
	private $urls ;//= new Constants();
	
	    	
	public function writeACategory($aCategory) {
    $datos= '<'.$aCategory->getUri().'> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#'.$aCategory->getCategory().'>.';//Se arman los datos para guardarlos en la base de datos
    return $this-> writeInSesameDataBase($datos);	
    }
    
	public function writeAProperty($aProperty) {
	$datos= '<'.$aProperty->getUri().'> <http://semdrops.lifia.edu.ar/ns/property#'.$aProperty->getPropertyTag().'> <'.$aProperty->getDestino().'>.';
    return $this-> writeInSesameDataBase($datos);
	} 
	public function writeAAttribute($aAttribute) {
	$datos= '<'.$aAttribute->getUri().'> <http://semdrops.lifia.edu.ar/ns/attribute#'.$aAttribute->getAttributeTag().'> "'.$aAttribute->getTarget().'"@es-ar.';
    return $this-> writeInSesameDataBase($datos);
	} 
	public function getProperties($aLink){
	$urls = new Constants();	
	$strQuery= array('queryLn' => "SPARQL",
							'query' => 	'select ?p ?o  
                                        where {
                                        <'.$aLink->getUri().'> ?p ?o
                                          FILTER regex(str(?p),"http://semdrops.lifia.edu.ar/ns/property#")}');
	return cortarTextoParaProperty(getParsedResultsFromQuery($strQuery));
	   
	  
	  
	  							
     //return $this->curl_post($urls-> BASECONSULTA, $strQuery) ;  										
		}
		
	public function getAttributes($aLink){
	$urls = new Constants();	
	$strQuery= array('queryLn' => "SPARQL",
							'query' => 	'select ?p   
                                        where {
                                        <'.$aLink->getUri().'> ?p ?o
                                          FILTER regex(str(?p),"http://semdrops.lifia.edu.ar/ns/attribute#")}');
					
	  return cortarTextoParaAttribute(getParsedResultsFromQuery($strQuery));
	   
	  
	  
	  							
     //return $this->curl_post($urls-> BASECONSULTA, $strQuery) ;  										
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
/**
 * Send a POST requst using cURL
 * @param string $url to request
 * @param array $post values to send
 * @param array $options for cURL
 * @return string
 */
   
function curl_post($url, array $post = NULL, array $options = array())
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
}
