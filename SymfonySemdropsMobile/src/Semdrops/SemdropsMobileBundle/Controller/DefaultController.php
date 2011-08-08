<?php

namespace Semdrops\SemdropsMobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SemdropsSemdropsMobileBundle:Default:index.html.twig');
    }
}
