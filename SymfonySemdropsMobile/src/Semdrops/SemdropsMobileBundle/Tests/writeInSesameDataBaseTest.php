<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;

Class writeInSesameDataBaseTest extends TestCase
{
   protected $semdrops;
   
  public function setUp()
   {
    $this -> semdrops = new Sesame();
    }
   public function testWriteInSesameDataBase()
   {
	$url='http://requiem:8080/openrdf-sesame/repositories/lalala/statements';
	$datos='<http://es.wikipedia.org/wiki/Argentina> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#TestPais>.';   
	$this -> assertTrue($this->semdrops->writeInSesameDataBase($datos));
	}
    public function testSesameDataBaseFailure()
 {
    $url='http://failure:8080/openrdf-sesame/repositories/lalala/statements';
    $this->semdrops->setUrl($url);
	$datos='<http://es.wikipedia.org/wiki/Argentina> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#TestPais>.';   
    $this-> assertFalse($this->semdrops->writeInSesameDataBase($datos));
  }
 }
?>
