<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appprodUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appprodUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = urldecode($pathinfo);

        // homepage
        if (rtrim($pathinfo, '/') === '/semdrops') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::indexAction',  '_route' => 'homepage',);
        }

        // getCategories
        if (rtrim($pathinfo, '/') === '/semdrops/get_categories') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'getCategories');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::getCategoriesAction',  '_route' => 'getCategories',);
        }

        // showCategories
        if (rtrim($pathinfo, '/') === '/semdrops/show_categories') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'showCategories');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::showCategoriesAction',  '_route' => 'showCategories',);
        }

        // addCategory
        if ($pathinfo === '/semdrops/add_category') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addCategoryAction',  '_route' => 'addCategory',);
        }

        // doneCategory
        if ($pathinfo === '/donecategory') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneCategoryAction',  '_route' => 'doneCategory',);
        }

        // addPropertyTag
        if ($pathinfo === '/semdrops/add_propertyTag') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addPropertyTagAction',  '_route' => 'addPropertyTag',);
        }

        // donePropertyTag
        if ($pathinfo === '/semdrops/doneproperty') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::donePropertyTagAction',  '_route' => 'donePropertyTag',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
