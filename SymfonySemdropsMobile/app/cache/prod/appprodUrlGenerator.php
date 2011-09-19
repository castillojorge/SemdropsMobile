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
       'getCategories' => true,
       'showCategories' => true,
       'addCategory' => true,
       'doneCategory' => true,
       'addPropertyTag' => true,
       'donePropertyTag' => true,
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
}
