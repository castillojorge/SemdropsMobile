<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;
use Semdrops\SemdropsMobileBundle\Entity\AttributeTags;

Class propertiesTest extends TestCase
{
   protected $attribute;
   
   
  public function setUp()
   {
    $this -> attribute = new AttributeTags();
    }
  public function testAddAttributes()
   {
	$this-> attribute-> setUri('http://www.webTest.com.ar/');
	$this-> attribute-> setAttributeTag('TestAttribute');
	$this-> attribute-> setTarget('2011');
	$this -> assertTrue($this->attribute->writeAttributeTag());//escribe un attribute en la BD
	$a= $this-> attribute-> getAttributes();//guarda en la variable un arreglo con las attributes
    $this-> assertContains('TestAttribute', $a[0]);
    $this-> assertNotContains('TestFailure', $a[0]);
	}
    public function testGetAttributes()
 { 
	$this-> attribute-> setUri('http://www.TestSemdrops.com.ar/');
	$this-> attribute-> setAttributeTag('TestAttribute');
	$this-> attribute-> setTarget('2011');
	$Ok= $this->attribute->writeAttributeTag();//escribe un attribute en la BD
   	$a= $this-> attribute-> getAttributes();//guarda en la variable un arreglo con las attributes
    $this-> assertContains('TestAttribute', $a[0]);
    $this-> assertNotContains('TestFailure', $a[0]);
  }
 }
?>
