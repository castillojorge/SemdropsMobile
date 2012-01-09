<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;


/**
 * appprodUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appprodUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    static private $declaredRouteNames = array(
       'homepage' => true,
       'login' => true,
       'logout' => true,
       'validar' => true,
       'addUser' => true,
       'doneAddUser' => true,
       'getCategories' => true,
       'showCategories' => true,
       'addCategory' => true,
       'doneCategory' => true,
       'addPropertyTag' => true,
       'donePropertyTag' => true,
       'getProperties' => true,
       'showProperties' => true,
       'addAttributeTag' => true,
       'doneAttributeTag' => true,
       'getAttributes' => true,
       'showAttributes' => true,
       'changePass' => true,
       'doneChangePass' => true,
       'changePassRec' => true,
       'doneChangePassRec' => true,
       'tag' => true,
       'tagForm' => true,
       'procesarTag' => true,
       'doneCategoryObject' => true,
       'doneAttributeTagObject' => true,
       'donePropertyTagObject' => true,
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function generate($name, array $parameters = array(), $absolute = false)
    {
        if (!isset(self::$declaredRouteNames[$name])) {
            throw new RouteNotFoundException(sprintf('Route "%s" does not exist.', $name));
        }

        $escapedName = str_replace('.', '__', $name);

        list($variables, $defaults, $requirements, $tokens) = $this->{'get'.$escapedName.'RouteInfo'}();

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute);
    }

    private function gethomepageRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::indexAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/',  ),));
    }

    private function getloginRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::index2Action',), array (), array (  0 =>   array (    0 => 'text',    1 => '/',  ),));
    }

    private function getlogoutRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::logoutAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/logout',  ),));
    }

    private function getvalidarRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::validarAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/validar',  ),));
    }

    private function getaddUserRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addUserAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/addUser',  ),));
    }

    private function getdoneAddUserRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneAddUserAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneAddUser',  ),));
    }

    private function getgetCategoriesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::getCategoriesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/get_categories/',  ),));
    }

    private function getshowCategoriesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::showCategoriesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/show_categories/',  ),));
    }

    private function getaddCategoryRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addCategoryAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/add_category',  ),));
    }

    private function getdoneCategoryRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneCategoryAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/donecategory',  ),));
    }

    private function getaddPropertyTagRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addPropertyTagAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/add_propertyTag',  ),));
    }

    private function getdonePropertyTagRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::donePropertyTagAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneproperty',  ),));
    }

    private function getgetPropertiesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::getPropertiesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/get_properties/',  ),));
    }

    private function getshowPropertiesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::showPropertiesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/show_properties/',  ),));
    }

    private function getaddAttributeTagRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::addAttributeTagAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/add_attributeTag',  ),));
    }

    private function getdoneAttributeTagRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneAttributeTagAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneattribute',  ),));
    }

    private function getgetAttributesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::getAttributesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/get_attributes/',  ),));
    }

    private function getshowAttributesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::showAttributesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/show_attributes/',  ),));
    }

    private function getchangePassRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::changePassAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/changePass',  ),));
    }

    private function getdoneChangePassRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneChangePassAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneChangePass',  ),));
    }

    private function getchangePassRecRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::changePassRecAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/changePassRec',  ),));
    }

    private function getdoneChangePassRecRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneChangePassRecAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneChangePassRec',  ),));
    }

    private function gettagRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::TagAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/tag',  ),));
    }

    private function gettagFormRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::tagFormAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/tagForm',  ),));
    }

    private function getprocesarTagRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::tagProcesadoAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/procesarTag',  ),));
    }

    private function getdoneCategoryObjectRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneCategoryObjectAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneCategoryObject',  ),));
    }

    private function getdoneAttributeTagObjectRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::doneAttributeTagObjectAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/doneAttributeTagObject',  ),));
    }

    private function getdonePropertyTagObjectRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Semdrops\\SemdropsMobileBundle\\Controller\\SemdropsController::donePropertyTagObjectAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/semdrops/donePropertyTagObject',  ),));
    }
}
