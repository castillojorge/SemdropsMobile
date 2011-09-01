<?php

namespace Semdrops\SemdropsMobileBundle\Entity;
        
 require_once ("QueryPath/QueryPath.php");  



class ConfigVar{
            
	public $BASECONSULTA= "http://requiem.local:8080/openrdf-workbench/repositories/lalala/query?";//constante que se utiliza para realizar consultas a la BBDD
	//http://requiem.local:8080/openrdf-workbench/repositories/NONE/repositories
	public $BASEINSERCION= "http://requiem.local:8080/openrdf-sesame/repositories/lalala/statements";//contante que se utiliza para realizar Post




public function getParsedResultsFromQuery($strQuery) {
			$encodedQuery= http_build_query($strQuery);
			$url= $BASECONSULTA.$encodedQuery.'&limit=100&infer=true';//UTILIZO LA CONSTANTE
			$querypath= qp($url, 'results'); //kind of "from url, get tag 'results'"
			$results= array();
			foreach ($querypath->children('result')->children('binding') as $res) {
				//from the previous tag, get its child 'result', and its child 'binding'
				$results[]= $res->text(); //from 'binding', 'results's grandchild, get its text
			}
			return $results;
		}
		
		public function getFathersFromFather($father, $results, $indentation) {
			$father= trim($father);
			$strQuery= array('queryLn' => 'SPARQL',
							'query' => "select ?o
										where {
    										<".str_replace('father#', 'soon#', $father)."> <semdrops:Subcategory> ?o
										}");
			foreach ($this->getParsedResultsFromQuery($strQuery) as $gFather) {
				$results[]= $indentation.substr($gFather, 48);
				$results= $this->getFathersFromFather($gFather, $results, '---'.$indentation);
			}
			return $results;
		}
		
		public function getFathersFromCategory($category, $results) {
			$category= trim($category);
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o
										where {
    										<".str_replace('category#', 'soon#', $category)."> <semdrops:Subcategory> ?o
										}");
			foreach ($this->getParsedResultsFromQuery($strQuery) as $father) {
				$results[]= '---- '.substr($father, 48);
				$results= $this->getFathersFromFather($father, $results, '-------- ');
			}
			return $results;
		}

		public function getCategoriesAndFathersFromUri($uri) {
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o 
										where {
    											<".$uri."> <rdf:Type> ?o
										}");
			$results= array();
			foreach ($this->getParsedResultsFromQuery($strQuery) as $category) {
				$results[]= '- '.substr($category, 50);
				$results= $this->getFathersFromCategory($category, $results);
			}
			return $results;
		}

//Metodo que guarda los datos en el repositorio sesame, utilizando curl.
 		function writeInSesameDataBase($url,$datos)
	        {
  			$request_body =$datos;
  			$ch = curl_init($url);
        		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//True
        		curl_setopt($ch, CURLOPT_HEADER, 0);//false
       			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/plain', 'charset=UTF-8'));
      		  	curl_setopt($ch, CURLOPT_POST, TRUE); 
      		  	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//true
     			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        		$response = curl_exec($ch);
        		curl_close($ch);
       			return $response;
 		}

	
	       
}
