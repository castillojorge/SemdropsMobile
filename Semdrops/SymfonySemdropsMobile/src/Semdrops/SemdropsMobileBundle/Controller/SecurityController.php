<?php
	namespace Semdrops\SemdropsMobileBundle\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Security\Core\SecurityContext;
	use Semdrops\SemdropsMobileBundle\Entity\User;
	
	class SecurityController extends Controller {
		
	    public function loginAction() {
	        // get the login error if there is one
	        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
	            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	        }
	        else {
	            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
	        }
	        return $this->render('SemdropsSemdropsMobileBundle:Security:login.html.twig',
	        					array(
	            					// last username entered by the user
						            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
						            'error'         => $error,
						        ));
	    }
#READ THAT repeated THING, DAAAAH!!
	    public function signupAction() {
			$user= new User();
			$form= $this->get('form.factory')->createBuilder('form', $user)
						->add('username', 'text')
						->add('password', 'repeated',
								array('type'=>'password', 'first_name'=>'Password: ', 'second_name' =>'Confirm you password: '))
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Security:signup.html.twig', array('form' => $form->createView()));
	    }
	}
?>
