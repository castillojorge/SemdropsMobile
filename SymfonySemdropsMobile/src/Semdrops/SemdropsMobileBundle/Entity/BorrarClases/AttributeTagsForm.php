<?php

namespace Semdrops\SemdropsMobileBundle\Entity;

class AttributeTagsForm
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
        
}
