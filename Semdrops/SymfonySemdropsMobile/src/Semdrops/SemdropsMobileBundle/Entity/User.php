<?php
namespace Semdrops\SemdropsMobileBundle\Entity;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;


class User
{	
public $id_usuario;
public $nombre_usuario; 
public $clave; 
public $nombre;
public $apellido;
public $email;	
public $habilitado;
	
public function getNombre_usuario()
{
   return $this-> nombre_usuario;
}
public function setNombre_usuario($aNombre_usuario)
{
   $this-> nombre_usuario = $aNombre_usuario;
}
	
public function getClave()
{
    return $this-> clave;
}
public function setClave($aClave)
{
    $this-> clave = $aClave;
}
public function getNombre()
{
   return $this-> nombre;
}
public function setNombre($aNombre)
{
   $this-> nombre = $aNombre;
}public function getApellido()
{
   return $this-> apellido;
}
public function setApellido($aApellido)
{
   $this-> apellido = $aApellido;
}
public function getEmail()
{
   return $this-> email;
}
public function setEmail($mail)
{
   $this-> email = $mail;
}
public function getHabilitado()
{
   return $this-> habilitado;
}
public function setHabilitado($num)
{
   $this-> habilitado = $num;
}

public function validarUsuario()
{
	$sesame= new Sesame();
	$con= $sesame->conectar();
	$name=$this-> getNombre_usuario();
	$clave= $this-> getClave();
	//$query= "INSERT INTO Usuario VALUES(NULL,'".$name."', '".$clave."','Juan', 'Perez',1)   ";
	$query= "SELECT * FROM Usuario WHERE nombre_usuario= '".$name."' and clave= DES_ENCRYPT('".$clave."') ";
	$result= mysql_query($query,$con);
	$total= mysql_num_rows($result);
	if($total == 0){
		return false;
	}
	    // session_start();
		    $usuario =  mysql_fetch_assoc($result);
			$_SESSION["id_usuario"] = $usuario['id_usuario'];
			$_SESSION["nombre_usuario"] = $usuario['nombre_usuario'];
			$_SESSION["clave"] = $usuario['clave'];
			$_SESSION["nombre"] = $usuario['nombre'];
			$_SESSION["apellido"] = $usuario['apellido'];
			$_SESSION["email"] = $usuario['email'];
			$_SESSION["habilitado"] = $usuario['habilitado'];
	return true;
}


public function writeAUser()
{
		$sesame= new Sesame();
	    $con= $sesame->conectar();
		$query= "SELECT * FROM Usuario WHERE nombre_usuario= '".$this->nombre_usuario."' or email= '".$this->email."'";
		$result= mysql_query($query,$con);
		$total= mysql_num_rows($result);
	    if($total == 0)
	    {
			$query= "INSERT INTO Usuario VALUES(NULL,'".$this->nombre_usuario."', DES_ENCRYPT('".$this->clave."'), '".$this->nombre."', '".$this->apellido."', '".$this->email."',1)   ";
			$result= mysql_query($query,$con);	
			return true;
		}
	
	return false;
		
} 
public function exists()
{
	
	$sesame= new Sesame();
	$con= $sesame->conectar();
	$name=$this-> getNombre_usuario();
	//$query= "INSERT INTO Usuario VALUES(NULL,'".$name."', '".$clave."','Juan', 'Perez',1)   ";
	$query= "SELECT * FROM Usuario WHERE nombre_usuario= '".$name."'";
	$result= mysql_query($query,$con);
	$total= mysql_num_rows($result);
	if($total == 0){
		return false;
	}
	return true;
}

public function changePass($mailer)
{
    $sesame= new Sesame();
	$con= $sesame->conectar();
	$name=$this-> getNombre_usuario();
	//$query= "INSERT INTO Usuario VALUES(NULL,'".$name."', '".$clave."','Juan', 'Perez',1)   ";
	$query= "SELECT * FROM Usuario WHERE nombre_usuario= '".$name."'";
	$result= mysql_query($query,$con);
	$usuario =  mysql_fetch_assoc($result);
	$nuevoPass = $sesame-> gen_pass(); 
	$email= $usuario['email'];
	$nombre_usuario= $usuario['nombre_usuario'];
	$query = "UPDATE Usuario SET clave= DES_ENCRYPT('".$nuevoPass."'), habilitado= 0 WHERE nombre_usuario='".$nombre_usuario."'";
	mysql_query($query,$con);
	 $message = \Swift_Message::newInstance()
        ->setSubject('Recupero de contraseña de Semdrops Mobile')
        ->setFrom('semdropsmobile8@gmail.com')
        ->setTo($email)
        ->setBody("Hi user Semdrops Mobile, your new password is: " .$nuevoPass)
    ;
   $mailer->send($message);
   
	
	
}



}
