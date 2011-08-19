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
	
	//Metodo que guarda los datos en el repositorio sesame, utilizando curl.
	function writeInSesameDataBase($datos) {
		$cons= new Constants();
		$request_body =$datos;
		$ch = curl_init($cons->BASEINSERCION);
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
?>
