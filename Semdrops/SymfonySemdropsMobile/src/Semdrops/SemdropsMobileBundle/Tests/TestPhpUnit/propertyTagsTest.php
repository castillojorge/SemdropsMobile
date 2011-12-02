<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;
use Semdrops\SemdropsMobileBundle\Entity\PropertyTags;

Class propertyTagsTest extends TestCase
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
    $this -> assertTrue($this->propertyTags->writeAProperty()); //escribe una property en la BD
    $p=$this->propertyTags->getAProperty();//guarda en la variable un arreglo con las property
    $this-> assertContains('OleAscenso', $p[0]);
    $this-> assertNotContains('TestFailure', $p[0]);
	}
   public function testGetProperties()
 {
	$this->propertyTags ->setUri('http://www.ole.com.ar'); 
    $this->propertyTags ->setPropertyTag('Ascenso');
    $this->propertyTags ->setDestino('http://www.ole.com.ar/futbol-ascenso/b-nacional');
    $Ok=$this->propertyTags->writeAProperty();//escribe una property en la BD
    $p=$this->propertyTags->getAProperty();//guarda en la variable un arreglo con las property
    $this-> assertContains('Ascenso', $p[0]);
    $this-> assertNotContains('TestFailure', $p[0]);
  }
 }
?>
