<?php
namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;

class PropertyTags
{
public $uri; //uri de la pagina
public $property; //propiedad de la uri
public $destino;// destino de la pagina		
	
public function getUri()
	{
	   return $this-> uri;
	}
public function setUri($aUri)
	{
	   $this-> uri = $aUri;
	}
	
public function getPropertyTag()
	{
	  return $this-> property;
	}
public function setPropertyTag($aProperty)
	{
      $this-> property = $aProperty;
    }
public function getDestino()
	{
	   return $this-> destino;
	}
public function setDestino($aDestino)
	{
	   $this-> destino = $aDestino;
       }

public function writeAProperty()
{
    $BD= new Sesame();
    $datos='<'.$this->getUri().'> <http://semdrops.lifia.edu.ar/ns/property#'.$this->getPropertyTag().'> <'.$this->getDestino().'>.';
    return ($BD->writeInSesameDataBase($datos)); 	

} 

public function getAProperty()
{
   $BD= new Sesame();
   $strQuery= array('queryLn' => "SPARQL",
							'query' => 	'select ?p ?o  
                                        where {
                                        <'.$this->getUri().'> ?p ?o
                                          FILTER regex(str(?p),"http://semdrops.lifia.edu.ar/ns/property#")}');;
   return $this->cortarTextoParaProperty($BD->getParsedResultsFromQuery($strQuery));
}

public function cortarTextoParaProperty($arreglo){
		 for ( $i =0; $i < count($arreglo) ; $i= $i+2) {
                 $arreglo[$i]= substr($arreglo[$i], 50); 
         }       
         return $arreglo;
     }

}
