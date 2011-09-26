<?php
	namespace Semdrops\SemdropsMobileBundle\Entity;
	use Semdrops\SemdropsMobileBundle\Entity\Constants;
	 use Semdrops\SemdropsMobileBundle\Entity\Sesame;
	//require_once 'functions.php';  	
	
	class Category {
	    private $name; //substr of fullname
	    private $fullname; //the whole link
		private $fathers; //an array of Category
			
		public function __construct($aCategory) {
			$this->name= trim(substr($aCategory, 0));
			$this->fullname= trim($aCategory);
			$this->fathers= array();
		} 
	
		public function getName() {
	        return $this->name;
	    }
	
	    public function setName($name) {
	        $this->name = $name;
	    }
	    
		public function getFullname() {
	        return $this->fullame;
	    }
	
	    public function setFullame($fullname) {
	        $this->fullname = $fullname;
	    }
	    
	    public function getFathers() {
	        return $this->fathers;
	    }
	
	    public function setFathers($fathers) {
	        $this->fathers= $fathers;
	    }
	    				
		private function saveAFather($father) {
			$this->fathers[]= $father;
		}
		
		private function setAllMyGrandFathers() {
			$BD= new Sesame();
			$strQuery= array('queryLn' => 'SPARQL',
							'query' => "select ?o
										where {
    										<".str_replace('father#', 'soon#', preg_replace('/\s/', 'a22', $this->fullname))."> <semdrops:Subcategory> ?o
										}");
			foreach ($BD->getParsedResultsFromQuery($strQuery) as $gFather) {
				$c_gFather= new Category($gFather);
				$c_gFather->setAllMyGrandFathers();
				$c_gFather->saveAFather($gFather);
			}
		}
		
	    public function setAllMyFathers($depth) {
			$strToReplace= 'father#';
		/*	if (substr_compare($this->fullname, 'category#', 0)) { //----- siempre entra!
				$strToReplace= 'category#';
				$this->saveAFather(new Category($strToReplace)); //----- debug
			}*/
			//lin 66-69: para checkear que string es el que cambio, si la profundidad no cambio, significa que buscaba categorias y no padres
			//pero seria mejor creo yo que funcionara con las lineas de codigo que estan arriba
			$cons= new Constants();
			$BD= new Sesame();
			if ($depth == $cons->TREEDEPTH) {
				$strToReplace= 'category#';
			}
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o
										where {
    										<".str_replace($strToReplace, 'soon#', $this->fullname)."> <semdrops:Subcategory> ?o
										}");
			foreach ($BD->getParsedResultsFromQuery($strQuery) as $father) {	
				$c_father= new Category($father);
				$depth= $depth - 1;
				if ($depth > 0) {
					$c_father->setAllMyFathers($depth);
				}
				$this->saveAFather($c_father);
	    	}
		}
	}
?>
