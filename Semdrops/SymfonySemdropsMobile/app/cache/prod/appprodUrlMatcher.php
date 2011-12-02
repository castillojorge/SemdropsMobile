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

        // login
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'login');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::index2Action',  '_route' => 'login',);
        }

        // logout
        if ($pathinfo === '/semdrops/logout') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::logoutAction',  '_route' => 'logout',);
        }

        // validar
        if ($pathinfo === '/semdrops/validar') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::validarAction',  '_route' => 'validar',);
        }

        // addUser
        if ($pathinfo === '/semdrops/addUser') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addUserAction',  '_route' => 'addUser',);
        }

        // doneAddUser
        if ($pathinfo === '/semdrops/doneAddUser') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneAddUserAction',  '_route' => 'doneAddUser',);
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

        // getProperties
        if (rtrim($pathinfo, '/') === '/semdrops/get_properties') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'getProperties');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::getPropertiesAction',  '_route' => 'getProperties',);
        }

        // showProperties
        if (rtrim($pathinfo, '/') === '/semdrops/show_properties') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'showProperties');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::showPropertiesAction',  '_route' => 'showProperties',);
        }

        // addAttributeTag
        if ($pathinfo === '/semdrops/add_attributeTag') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addAttributeTagAction',  '_route' => 'addAttributeTag',);
        }

        // doneAttributeTag
        if ($pathinfo === '/semdrops/doneattribute') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneAttributeTagAction',  '_route' => 'doneAttributeTag',);
        }

        // getAttributes
        if (rtrim($pathinfo, '/') === '/semdrops/get_attributes') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'getAttributes');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::getAttributesAction',  '_route' => 'getAttributes',);
        }

        // showAttributes
        if (rtrim($pathinfo, '/') === '/semdrops/show_attributes') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'showAttributes');
            }
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::showAttributesAction',  '_route' => 'showAttributes',);
        }

        // changePass
        if ($pathinfo === '/semdrops/changePass') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::changePassAction',  '_route' => 'changePass',);
        }

        // doneChangePass
        if ($pathinfo === '/semdrops/doneChangePass') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneChangePassAction',  '_route' => 'doneChangePass',);
        }

        // changePassRec
        if ($pathinfo === '/semdrops/changePassRec') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::changePassRecAction',  '_route' => 'changePassRec',);
        }

        // doneChangePassRec
        if ($pathinfo === '/semdrops/doneChangePassRec') {
            return array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneChangePassRecAction',  '_route' => 'doneChangePassRec',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
