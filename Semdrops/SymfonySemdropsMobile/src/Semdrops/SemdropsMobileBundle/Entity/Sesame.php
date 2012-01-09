<?php

namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Constants;
require_once ("QueryPath/QueryPath.php");  	
class Sesame {
	
private $urls ;
	
	    	
public function writeACategory($aCategory) {
    $datos= '<'.$aCategory->getUri().'> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#'.$aCategory->getCategory().'>.';//Se arman los datos para guardarlos en la base de datos
    return $this-> writeInSesameDataBase($datos);	
    }
   
function writeInSesameDataBase($datos) {
	   $urls = new Constants();
       $request_body =$datos;
       $ch = curl_init($urls->BASEINSERCION);
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
public function conectar(){
$con= mysql_connect("localhost","semantic","semantic");
mysql_select_db("proyecto",$con);
return $con;

}
public function gen_pass() { 
$i=0; 
$password=""; 
// Aqui colocamos el largo del password 
$pw_largo = 8; 
// Colocamos el rango de caracteres ASCII para la creacion de el password 
$desde_ascii = 50; // "2" 
$hasta_ascii = 122; // "z" 
// Aqui quitamos caracteres especiales 
$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108, 111); 
while ($i < $pw_largo) { 
mt_srand ((double)microtime() * 1000000); 
// limites aleatorios con tabla ASCII 
$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
if (!in_array ($numero_aleat, $no_usar)) { 
$password = $password . chr($numero_aleat); 
$i++; 
} 
} 
return $password; 
 
}

}
