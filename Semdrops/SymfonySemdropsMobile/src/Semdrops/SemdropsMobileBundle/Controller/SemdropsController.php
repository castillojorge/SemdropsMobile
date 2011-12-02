<?php
	namespace Semdrops\SemdropsMobileBundle\Controller;
	
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Semdrops\SemdropsMobileBundle\Entity\Link;
	use Semdrops\SemdropsMobileBundle\Entity\CategoryForm;
    use Semdrops\SemdropsMobileBundle\Entity\Sesame;
    use Semdrops\SemdropsMobileBundle\Entity\PropertyTags;
  	use Semdrops\SemdropsMobileBundle\Entity\AttributeTags;
  	use Semdrops\SemdropsMobileBundle\Entity\User;
  	use Semdrops\SemdropsMobileBundle\Entity\Pass;
  	
  class SemdropsController extends Controller {
		
		//Si no esta logueado se dirige al login. Si esta logueado se dirige a la pagina principal de Semdrops Mobile
		public function indexAction() {		
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
	   	}
	   	
	   	//Para generar el form del login
	    public function index2Action() {
			
			if (isset($_SESSION["nombre_usuario"])){
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
			}
		
			$user= new User(''); $msj='';
			$form= $this->get('form.factory')->createBuilder('form', $user)
						->add('nombre_usuario','text')
						->add('clave','password')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:formUser.html.twig', array('msj'=> $msj,'form' => $form->createView()) );
		}
		
		//Valida si el usuario puede ingresar a Semdrops
		public function validarAction(){
			
			$request= $this->get('request');
			if ($request->getMethod() == 'POST') {
				$user= new User();
				$form= $this->get('form.factory')->createBuilder('form', $user)
							->add('nombre_usuario','text')
						    ->add('clave','password')
							->getForm();		
				$form->bindRequest($request); //xml to form and, somehow, to filledLink.
				//if ($form->isValid()) {
				if($user -> validarUsuario()){	
					if ($_SESSION["habilitado"]== 1){
					    return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig',
						array('user' => $user));
					}
					return $this-> changePassRecAction($user);
                }
                $msj= "Usuario o Contraseña no validos";
                return $this->render('SemdropsSemdropsMobileBundle:Semdrops:formUser.html.twig',array('msj'=> $msj,'form' => $form->createView()));			
				//}
				
             }		
		     return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showcategories_error.html.twig');
		 }
		 
		 
		 //Crea el formulario para cambiar la contraseña
		public function changePassRecAction($user) {
		    if ($_SESSION["habilitado"]==1){
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
			}
			$pass= new Pass();$msj='';
			$form= $this->get('form.factory')->createBuilder('form',$pass)
						->add('clave','password')
						->add('clave2','password')
						->add('clave3','password')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:changePassRec.html.twig', array('msj'=>$msj,'user'=>$user,'form' => $form->createView()) );
		}
		
		//Toma los valores ingresados para cambiar la contraseña, si son correctos la cambia, sino avisa que no pudo
	   public function doneChangePassRecAction() {
		    if ($_SESSION["habilitado"]==1){
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
			}
			$user= new User();
			$user-> setNombre_usuario($_SESSION["nombre_usuario"]);
			$pass= new Pass();
			$request= $this->get('request');
			$form= $this->get('form.factory')->createBuilder('form',$pass)
						->add('clave','password')
						->add('clave2','password')
						->add('clave3','password')
						->getForm();
			$form->bindRequest($request);
			if($pass->validar()){	
					return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:doneChangePassRec.html.twig', array('form'=>$form));
            }
            $msj= "La clave principal es incorrecta o ha ingresado dos claves nuevas distintas";
            return $this->render('SemdropsSemdropsMobileBundle:Semdrops:changePassRec.html.twig', array('msj'=> $msj,'user'=>$user,'form' => $form->createView()));

	  }
		
      //Crea el formulario para agregar Usuarios
     public function addUserAction() {
		 
			$user= new User('');$msj='';
			$form= $this->get('form.factory')->createBuilder('form', $user)
						->add('nombre_usuario','text')
						->add('clave','password')
						->add('nombre','text')
						->add('apellido','text')
						->add('email', 'email')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:addUser.html.twig', array('msj'=>$msj,'form' => $form->createView()) );
	 }
		  
	  //Toma los valores ingresados, si son correctos agrega el usuario, sino avisa que no pudo	  
     public function doneAddUserAction() {
			
			$request= $this->get('request');
			$aUser= new User();
			$form= $this->get('form.factory')->createBuilder('form', $aUser)
						->add('nombre_usuario','text')
						->add('clave','password')
						->add('nombre','text')
						->add('apellido','text')
						->add('email', 'email')
						->getForm();
			$form->bindRequest($request);
			if($aUser->writeAUser($aUser)){	
			    return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:doneUser.html.twig', array('form'=>$aUser));
            }
            $msj= "El usuario ya esta registrado (No se puede repetir el nombre de usuario ni el email)";
            return $this->render('SemdropsSemdropsMobileBundle:Semdrops:addUser.html.twig', array('msj'=> $msj,'form' => $form->createView()));

	 }
	  //Cierra sesion y nos dirige a la pagina de login	
     public function logoutAction(){
			$_SESSION = array();
            //session_start();
			return $this->index2Action();
	 }
	   //Crea el form para ingresar una Uri y poder obtener las categorias de ella		
     public function getCategoriesAction() {
		    if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
			$link= new Link('');
			$form= $this->get('form.factory')->createBuilder('form', $link)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:getcategories.html.twig', array('form' => $form->createView()));
	 }
	    //Muestra las categorias de la uri ingresada		
		public function showCategoriesAction() {
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
			$request= $this->get('request');
			if ($request->getMethod() == 'POST') {
				$filledLink= new Link('');
				$form= $this->get('form.factory')->createBuilder('form', $filledLink)
							->add('uri', 'url')
							->getForm();		
				$form->bindRequest($request); //xml to form and, somehow, to filledLink.
				if ($form->isValid()) {
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showcategories.html.twig',
										array('link' => $filledLink->getUri(), 'categories' => $filledLink->getCategories()));
				}
			}
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showcategories_error.html.twig');
		}

		
		//Para poder setear una Uri y guardar su categoria en la base de datos
		public function addCategoryAction() {
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
			$category = new CategoryForm();
  			$form = $this->get('form.factory') -> createBuilder('form',$category)
					->add('uri','url')
					->add('category','text')
                    ->add('father', 'text')
					->getForm();
			return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:addCategory.html.twig', array('form'=>$form->createView()));//Se redirige a la vista, para mostrar el formulario
 		}

  		// Recibe los datos del fomulario y manda a imprimirlos a la base de datos
		public function doneCategoryAction() {
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
			$request= $this->get('request');
			$aCategory = new CategoryForm();
			$form = $this->get('form.factory')->createBuilder('form', $aCategory)
					->add('uri','url')
					->add('category','text')
					->getForm();
			$form->bindRequest($request);
			$BD= new Sesame();
			if ($BD->writeACategory($aCategory)) {
				return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:mostrarcategory.html.twig', array('form'=>$aCategory));
			}
            else {
            	return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:falla.html.twig', array('form'=>$aCategory));
			}  
  		}
  		
  		//Para poder setear una Uri y guardar una propertyTag en la base de datos
	    public function addPropertyTagAction()
  		  {
			  if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
		     $property = new PropertyTags();
		     $form= $this->get('form.factory') -> createBuilder('form',$property)
					->add('uri','url')
					->add('propertyTag','text')
                    ->add('destino', 'url')
					->getForm();
			return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:addPropertyTag.html.twig', array('form'=>$form->createView()));
		  }
		  
		 // Recibe los datos del fomulario y manda a imprimirlos a la base de datos 
		public function donePropertyTagAction()
		{
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
		  	$request= $this->get('request');
			$aProperty = new PropertyTags();
			$form = $this->get('form.factory')->createBuilder('form', $aProperty)
					->add('uri','url')
					->add('propertyTag','text')
					->add('destino','url')
					->getForm();
			$form->bindRequest($request);
			if ($aProperty->writeAProperty()) {
				return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:donePropertyTag.html.twig', array('form'=>$aProperty));
			}
            else {
            	return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:falla.html.twig', array('form'=>$aProperty));
			}  
	    }
	    
	    public function getPropertiesAction()  {
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}	
			$property= new PropertyTags;
			$form= $this->get('form.factory')->createBuilder('form', $property)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:getproperties.html.twig', array('form' => $form->createView()));
		}
		
		public function showPropertiesAction() {
	        if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			} 	
			$request= $this->get('request');
			if ($request->getMethod() == 'POST') {
				$property= new PropertyTags();
				$form= $this->get('form.factory')->createBuilder('form', $property)
							->add('uri', 'url')
							->getForm();		
				$form->bindRequest($request); //xml to form and, somehow, to filledLink.
				$result=$property->getAProperty();
				if ($form->isValid()) {
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showproperties.html.twig',
										array('link' => $property->getUri(), 'result'=>$result));
				}
			}
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showcategories_error.html.twig');
		}
		
		
		  public function addAttributeTagAction()
  		  {
			 if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			} 
		     $attribute = new AttributeTags();
		     $form= $this->get('form.factory') -> createBuilder('form',$attribute)
					->add('uri','url')
					->add('attributeTag','text')
                    ->add('target','text')
					->getForm();
			return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:addAttributeTag.html.twig', array('form'=>$form->createView()));
		  }
		  
		public function doneAttributeTagAction()
		{
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
		  	$request= $this->get('request');
			$aAttribute = new AttributeTags();
			$form = $this->get('form.factory')->createBuilder('form', $aAttribute)
					->add('uri','url')
					->add('attributeTag','text')
                    ->add('target','text')
					->getForm();
			$form->bindRequest($request);
			if ($aAttribute-> writeAttributeTag()) {
				return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:doneAttributeTag.html.twig', array('form'=>$aAttribute));
			}
            else {
            	return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:falla.html.twig', array('form'=>$aAttribute));
			}  
	    }
	    
	     	public function getAttributesAction()  {
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}	
			$attribute= new AttributeTags();
			$form= $this->get('form.factory')->createBuilder('form', $attribute)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:getattributes.html.twig', array('form' => $form->createView()));
		}
		
		public function showAttributesAction() {
			if (!isset($_SESSION["nombre_usuario"])){
					return $this-> index2Action();
			}
			$request= $this->get('request');
			if ($request->getMethod() == 'POST') {
				$attribute= new AttributeTags();
				$form= $this->get('form.factory')->createBuilder('form', $attribute)
							->add('uri', 'url')
							->getForm();		
				$form->bindRequest($request); //xml to form and, somehow, to filledLink.
				$result=$attribute->getAttributes();
				if ($form->isValid()) {
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showattributes.html.twig',
										array('link' => $attribute->getUri(), 'result'=>$result));
				}
			}
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showcategories_error.html.twig');
		}
	    
		
	  public function changePassAction() {
		 if (isset($_SESSION["nombre_usuario"])){
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
			}
			$user= new User(''); $msj='';
			$form= $this->get('form.factory')->createBuilder('form', $user)
						->add('nombre_usuario','text')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:changePass.html.twig', array('msj'=>$msj, 'form' => $form->createView()) );
		}
		
	 public function doneChangePassAction() {
			if (isset($_SESSION["nombre_usuario"])){
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
			}

			$request= $this->get('request');
			$aUser= new User();
			$form= $this->get('form.factory')->createBuilder('form', $aUser)
						->add('nombre_usuario','text')
						->getForm();
			$form->bindRequest($request);
			if($aUser->exists()){	
				    //$aUser-> changePass();
				    $mailer = $this->container->get('mailer');
				    $aUser->changePass($mailer);
					return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:doneChangePass.html.twig', array('form'=>$aUser));
                    }
                     $msj= "EL nombre de usuario ingresado no existe";
                    return $this->render('SemdropsSemdropsMobileBundle:Semdrops:changePass.html.twig', array('msj'=> $msj,'form' => $form->createView()));

		}			
			
		
	    
	}
?>
