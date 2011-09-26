<?php
class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost/SymfonySemdropsMobile/web/app_dev.php/semdrops/");
  }

  public function testMyTestCase()
  {
    $this->open("/SymfonySemdropsMobile/web/app_dev.php/semdrops/");
    $this->click("link=Add Categories");
    $this->waitForPageToLoad("30000");
    $this->type("id=form_uri", "http://es.wikipedia.org/wiki/Honduras");
    $this->type("id=form_category", "countryPrueba");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->verifyTextPresent("Category: countryPrueba");
    $this->click("name=gobackButton");
    $this->waitForPageToLoad("30000");
  }
}
?>