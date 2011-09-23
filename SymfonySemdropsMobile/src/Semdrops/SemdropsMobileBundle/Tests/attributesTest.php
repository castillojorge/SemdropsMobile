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
	$this-> attribute-> setUri('http://www.ole.com.ar/');
	$this-> attribute-> setAttributeTag('DiarioOle');
	$this-> attribute-> setTarget('DiarioOle');
	$this -> assertTrue($this->attribute->writeAttributeTag());
	}
    public function testGetAttributes()
 { 
    $url='http://requiem.local:8080/openrdf-workbench/repositories/lalala/query?';
	$this-> attribute-> setUri('http://www.ole.com.ar/');
	$a= $this-> attribute-> getAttributes();
	//$b= $a[0];
    $this-> assertContains("DiarioOlett", $a[0]);
  }
 }
?>
