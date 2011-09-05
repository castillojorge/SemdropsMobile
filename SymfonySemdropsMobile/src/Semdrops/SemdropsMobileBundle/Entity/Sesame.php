<?php

namespace Semdrops\SemdropsMobileBundle\Entity;

class Sesame
{
	private $url = 'http://requiem.local:8080/openrdf-sesame/repositories/lalala'; //uri del server
			
	
    public function getUrl()
	{
	   return $this-> url;
	}
	
	public function setUrl($aUri)
	{
	   $this-> url = $aUri;
	}
	
	public function writeACategory($aCategory)
	{
    $datos= '<'.$aCategory->getUri().'> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#'.$aCategory->getCategory().'>.';//Se arman los datos para guardarlos en la base de datos
    return $this-> writeInSesameDataBase($datos);	
    }
    
	public function writeAProperty($aProperty)
	{
	$datos= '<'.$aProperty->getUri().'> <property:'.$aProperty->getPropertyTag().'> <'.$aProperty->getDestino().'>.';
    return $this-> writeInSesameDataBase($datos);
	} 
	
	function writeInSesameDataBase($datos)
    {
       $request_body =$datos;
       $ch = curl_init($this->getUrl().'/statements');
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
