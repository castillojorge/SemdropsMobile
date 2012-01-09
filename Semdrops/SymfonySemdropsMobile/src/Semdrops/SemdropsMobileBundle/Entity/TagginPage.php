<?php 
	namespace Semdrops\SemdropsMobileBundle\Entity;
	use Semdrops\SemdropsMobileBundle\Entity\TaggingPage;
	
	require_once 'simple_html_dom.php';  	
	
	class TaggingPage {
	    private $uri;
				
		public function getUri() {
	        return $this->uri;
	    }
	
	    public function setUri($uri) {
	        $this->uri = $uri;
	    }
	    
	    public function getCategories() {
	    	$cons= new Constants();
	    	$BD= new Sesame();
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o 
										where {
    											<".$this->uri."> <rdf:Type> ?o
										}");
			foreach ($BD->getParsedResultsFromQuery($strQuery) as $category) {
				$category= new Category($category);
				$category->setAllMyFathers($cons->TREEDEPTH);
				$this->saveACategory($category);
			}
			return $this->categories;
		}
	
	    public function setCategories($categories) {
	        $this->categories= $categories;
	    }
	}
?>
