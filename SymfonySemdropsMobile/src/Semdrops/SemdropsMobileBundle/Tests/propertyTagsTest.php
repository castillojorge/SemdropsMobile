<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;
use Semdrops\SemdropsMobileBundle\Entity\PropertyTags;

Class propertiesTest extends TestCase
{
   protected $propertyTags;
   
  public function setUp()
   {
    $this -> propertyTags = new PropertyTags();

    }
   public function testAddProperties()
   {
    $this->propertyTags ->setUri('http://www.ole.com.ar');
    $this->propertyTags ->setPropertyTag('OleAscenso');
    $this->propertyTags ->setDestino('http://www.ole.com.ar/futbol-ascenso/b-nacional');
    $this -> assertTrue($this->propertyTags->writeAProperty()); 
    $s=$this->propertyTags->getAProperty();
    $this-> assertContains('OleAscenso', $s[0]);
	}
   public function testGetProperties()
 {
	$this->propertyTags ->setUri('http://www.ole.com.ar'); 
    $this->propertyTags ->setPropertyTag('Ascenso');
    $this->propertyTags ->setDestino('http://www.ole.com.ar/futbol-ascenso/b-nacional');
    $Ok=$this->propertyTags->writeAProperty();//escribe la property en la BD
    $s=$this->propertyTags->getAProperty();
    $this-> assertContains('Ascenso', $s[0]);
  }
 }
?>
