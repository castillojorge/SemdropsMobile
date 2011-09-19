<?php

namespace Semdrops\SemdropsMobileBundle\Entity;

class CategoryForm
{
	public $uri; //uri de la pagina
	public $category; //categoria de la uri
	public $father;// padre de la categoria si tiene		
	
        public function getUri()
	{
	   return $this-> uri;
	}
	public function setUri($aUri)
	{
	   $this-> uri = $aUri;
	}
	
	public function getCategory()
	{
	  return $this-> category;
	}
	public function setCategory($aCategory)
	{
      $this-> category = $aCategory;
    }
        public function getFather()
	{
	   return $this-> father;
	}
	public function setFather($aFather)
	{
	   $this-> father = $aFather;
       }
        
}
