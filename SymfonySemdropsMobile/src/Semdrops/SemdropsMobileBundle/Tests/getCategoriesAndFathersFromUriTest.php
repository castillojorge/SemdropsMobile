<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Controller\SemdropsController;

Class getCategoriesAndFathersFromUriTest extends TestCase
{
   protected $semdrops;
   
  public function setUp()
   {
    $this -> semdrops = new SemdropsController();
    $url='http://requiem:8080/openrdf-sesame/repositories/lalala/statements';
	$datos='<http://es.wikipedia.org/wiki/Africa> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#TestContinente>.';   
    $this->semdrops->writeInSesameDataBase($url,$datos);
    }
   public function testGetCategoriesAndFathersFromUri()
   {
	$this->assertEquals($this->semdrops->getCategoriesAndFathersFromUri('<http://es.wikipedia.org/wiki/Africa>'), '- TestContinente');
	}
}
?>
