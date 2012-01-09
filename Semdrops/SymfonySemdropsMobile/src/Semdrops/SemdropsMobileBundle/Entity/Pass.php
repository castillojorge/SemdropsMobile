<?php
namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;

class Pass
{	
public $clave;
public $clave2; 
public $clave3; 
	
	
public function getclave()
{
   return $this-> clave;
}
public function setclave($aClave)
{
   $this-> clave = $aClave;
}
	
public function getClave2()
{
    return $this-> clave2;
}
public function setClave2($aClave2)
{
    $this-> clave2 = $aClave2;
}
public function getClave3()
{
    return $this-> clave3;
}
public function setClave3($aClave3)
{
    $this-> clave3 = $aClave3;
}

public function validar(){
	
	$con= mysql_connect("localhost","semantic","semantic");
	mysql_select_db("proyecto",$con);
	$query= "SELECT * FROM Usuario WHERE nombre_usuario= '".$_SESSION["nombre_usuario"]."' and clave= DES_ENCRYPT('".$this->clave."') ";
	$result= mysql_query($query,$con);
	$total= mysql_num_rows($result);
	if($total == 0 or $this->clave2 != $this->clave3){
		return false;
	}
	$query = "UPDATE Usuario SET clave= DES_ENCRYPT('".$this->clave2."'), habilitado= 1 WHERE nombre_usuario='".$_SESSION["nombre_usuario"]."'";
	$result= mysql_query($query,$con);
	return true;
}
	

}
