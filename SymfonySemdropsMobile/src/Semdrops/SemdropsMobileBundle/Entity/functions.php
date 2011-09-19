<?php
	namespace Semdrops\SemdropsMobileBundle\Entity;
	use Semdrops\SemdropsMobileBundle\Entity\Constants;
	        
	require_once ("QueryPath/QueryPath.php");  	            
		
	function getParsedResultsFromQuery($strQuery) {
		$cons= new Constants();
		$encodedQuery= http_build_query($strQuery);
		$url= $cons->BASECONSULTA.$encodedQuery.'&limit=100&infer=true'; //UTILIZO LA CONSTANTE
		$querypath= qp($url, 'results'); //kind of "from url, get tag 'results'"
		$results= array();
		foreach ($querypath->children('result')->children('binding') as $res) {
			//from the previous tag, get its child 'result', and its child 'binding'
			$results[]= $res->text(); //from 'binding', 'results's grandchild, get its text
		}
		return $results;
	}
	
	 function cortarTextoParaProperty($arreglo){
		 for ( $i =0; $i < count($arreglo) ; $i= $i+2) {
                 $arreglo[$i]= substr($arreglo[$i], 50); 
         }       
         return $arreglo;
     }
      function cortarTextoParaAttribute($arreglo){
		 for ( $i =0; $i < count($arreglo) ; $i= $i+1) {
                 $arreglo[$i]= substr($arreglo[$i], 51); 
         }       
         return $arreglo;
     }
		 
		 
		 
		 
?>
