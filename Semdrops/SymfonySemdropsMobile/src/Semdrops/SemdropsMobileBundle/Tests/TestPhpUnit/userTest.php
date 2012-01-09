<?php
namespace Semdrops\SemdropsMobileBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Semdrops\SemdropsMobileBundle\Entity\Sesame;
use Semdrops\SemdropsMobileBundle\Entity\User;

Class userTest extends TestCase
{
   protected $user;
   protected $sesame;
   protected $con;
   
  public function setUp()
   {
    $this -> user = new User();
    $this->user ->setNombre_usuario('ngnrgnlkasklhgsdfh');
	$this->user ->setClave('pepe');
	$this->user ->setNombre('Pedro');
	$this->user ->setApellido('Perez');
	$this->user ->setEmail('semdropsmobile8@gmail.com');
	$this->user ->setHabilitado(1);
	$this-> sesame= new Sesame();
	$this-> con= $this-> sesame-> conectar();
    
    }
   public function testWriteUser()
   {
		$this->user->writeAUser();	
		//asserts que validen que esta en la base
		//$con= $this-> sesame-> conectar();
		$query= "SELECT * FROM Usuario WHERE nombre_usuario='ngnrgnlkasklhgsdfh'";
		$result= mysql_query($query,$this-> con);
		$this-> assertTrue(mysql_num_rows($result)==1);
		$query= "DELETE FROM Usuario WHERE nombre_usuario= 'ngnrgnlkasklhgsdfh' ";
		$result= mysql_query($query,$this-> con);
	}
	
	public function testWriteUserFailureBecouseAlreadyExists()
	{
		$this-> user->writeAUser(); 
		$this-> assertFalse($this->user->writeAUser());	
	  //  $con= $this-> sesame-> conectar();
		$query= "DELETE FROM Usuario WHERE nombre_usuario= 'ngnrgnlkasklhgsdfh' ";
		$result= mysql_query($query,$this-> con);
		
	}
	
	public function testExists()
	{
		$this-> user->writeAUser(); 	
		$this-> assertTrue($this->user->exists());
		//$con= $this-> sesame-> conectar();
		$query= "DELETE FROM Usuario WHERE nombre_usuario= 'ngnrgnlkasklhgsdfh' ";
		$result= mysql_query($query,$this-> con);
		
		
    }
    public function testNotExists()
	{
		$this-> assertFalse($this->user->exists());
	}	
	
	public function testValidarUsuario(){
		$this-> user->writeAUser();
		$this-> assertTrue($this->user->validarUsuario());
		//$con= $this-> sesame-> conectar();
        $query= "DELETE FROM Usuario WHERE nombre_usuario= 'ngnrgnlkasklhgsdfh' ";
		$result= mysql_query($query,$this-> con);
		}
	
	
	public function testNombre_Usuario()
    {
        $this->assertEquals('ngnrgnlkasklhgsdfh', $this-> user-> getNombre_usuario());
    }
    
  public function testClave()
    {
       
        $this->assertEquals('pepe', $this->user->getClave());
    }	
    
      public function testNombre()
    {
       
        $this->assertEquals('Pedro', $this->user->getNombre());
    }	
    
      public function testApellido()
    {
       
        $this->assertEquals('Perez', $this->user->getApellido());
    }		
    
    public function testEmail()
    {
       
        $this->assertEquals('semdropsmobile8@gmail.com', $this->user->getEmail());
    }	
   
     public function testHabilitado()
    {
       
        $this->assertEquals(1, $this->user->getHabilitado());
    }	
		
	
	
	
 
 }
?>
