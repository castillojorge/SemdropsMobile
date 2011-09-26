<?php
namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;

class AttributeTags
{
public $uri; //uri de la pagina
public $attribute; //atributo de la uri
public $target;// numero o literal		
	
public function getUri()
{
   return $this-> uri;
}
public function setUri($aUri)
{
   $this-> uri = $aUri;
}
	
public function getAttributeTag()
{
    return $this-> attribute;
}
public function setAttributeTag($aAttribute)
{
    $this-> attribute = $aAttribute;
}
public function getTarget()
{
   return $this-> target;
}
public function setTarget($aTarget)
{
   $this-> target = $aTarget;
}
       
public function writeAttributeTag()
{
    $BD= new Sesame();
    $datos= '<'.$this->getUri().'> <http://semdrops.lifia.edu.ar/ns/attribute#'.$this->getAttributeTag().'> "'.$this->getTarget().'"@es-ar.';
    return ($BD->writeInSesameDataBase($datos)); 	

} 

public function getAttributes()
{
   $BD= new Sesame();
   $strQuery= array('queryLn' => "SPARQL",
							'query' => 	'select ?p ?o  
                                        where {
                                        <'.$this->getUri().'> ?p ?o
                                          FILTER regex(str(?p),"http://semdrops.lifia.edu.ar/ns/attribute#")}');
   return $this->cortarTextoParaAttribute($BD->getParsedResultsFromQuery($strQuery));
}

function cortarTextoParaAttribute($arreglo){
	 for ( $i =0; $i < count($arreglo) ; $i= $i+1) {
              $arreglo[$i]= substr($arreglo[$i], 51); 
         }       
     return $arreglo;
     }


}
