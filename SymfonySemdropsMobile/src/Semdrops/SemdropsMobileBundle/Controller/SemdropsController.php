<?php
	namespace Semdrops\SemdropsMobileBundle\Controller;
	
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Semdrops\SemdropsMobileBundle\Entity\Link;
	use Semdrops\SemdropsMobileBundle\Entity\CategoryForm;
    use Semdrops\SemdropsMobileBundle\Entity\Sesame;
    use Semdrops\SemdropsMobileBundle\Entity\PropertyTags;
  	use Semdrops\SemdropsMobileBundle\Entity\AttributeTags;
	class SemdropsController extends Controller {
		
		public function indexAction() {				
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
	   	}
	    
	   	public function getCategoriesAction() {
			$link= new Link('');
			$form= $this->get('form.factory')->createBuilder('form', $link)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:getcategories.html.twig', array('form' => $form->createView()));
		}
	    		
		public function showCategoriesAction() {
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
	    public function addPropertyTagAction()
  		  {
		     $property = new PropertyTags();
		     $form= $this->get('form.factory') -> createBuilder('form',$property)
					->add('uri','url')
					->add('propertyTag','text')
                    ->add('destino', 'url')
					->getForm();
			return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:addPropertyTag.html.twig', array('form'=>$form->createView()));
		  }
		public function donePropertyTagAction()
		{
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
			$property= new PropertyTags;
			$form= $this->get('form.factory')->createBuilder('form', $property)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:getproperties.html.twig', array('form' => $form->createView()));
		}
		
		public function showPropertiesAction() {
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
			$attribute= new AttributeTags();
			$form= $this->get('form.factory')->createBuilder('form', $attribute)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:getattributes.html.twig', array('form' => $form->createView()));
		}
		
		public function showAttributesAction() {
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
	    
		
	    
	}
?>
