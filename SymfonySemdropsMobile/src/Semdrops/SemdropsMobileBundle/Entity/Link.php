<?php 
	namespace Semdrops\SemdropsMobileBundle\Entity;

	class Link {
	    private $uri;
		private $categories;
		private $father;
	
		public function getUri() {
	        return $this->uri;
	    }
	
	    public function setUri($uri) {
	        $this->uri = $uri;
	    }
	    
	    public function getCategories() {
	        return $this->categories;
	    }
	
	    public function setCategories($categories) {
	        $this->categories= $categories;
	    }
	    
		public function getFather() {
			return $this->father;
		}
		
		public function setFather($aFather) {
			$this->father= $aFather;
		}
	}
?>
