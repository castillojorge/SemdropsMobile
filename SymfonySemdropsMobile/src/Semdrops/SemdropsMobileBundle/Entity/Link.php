<?php 
	namespace Semdrops\SemdropsMobileBundle\Entity;
	use Semdrops\SemdropsMobileBundle\Entity\Constants;
	
	require_once 'functions.php';  	
	
	class Link {
	    private $uri;
		private $categories;
				
		public function __construct($uri) {
			$this->setUri($uri);
			$this->categories= array();
			$CONFIGVAR= new ConfigVar();
		}
		
		public function setCategory($aCategory) {
			$datos='<'.$this->getUri().'> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#'.$aCategory.'>.';//Se arman los datos para guardarlos en la base de datos
			return $estado= writeInSesameDataBase($datos);			
		}

		private function saveACategory($aCategory) {
			//saves a category in the array
			$this->categories[]= $aCategory;
		}
	
		public function getUri() {
	        return $this->uri;
	    }
	
	    public function setUri($uri) {
	        $this->uri = $uri;
	    }
	    
	    public function getCategories() {
	    	$cons= new Constants();
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o 
										where {
    											<".$this->uri."> <rdf:Type> ?o
										}");
			foreach (getParsedResultsFromQuery($strQuery) as $category) {
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