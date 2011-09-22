<?php

namespace Semdrops\SemdropsMobileBundle\Entity;

class PropertyTagsForm
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
        
}
