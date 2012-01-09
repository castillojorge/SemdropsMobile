<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;


/**
 * appdevUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appdevUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    static private $declaredRouteNames = array(
       '_assetic_202485f' => true,
       '_assetic_202485f_0' => true,
       '_assetic_202485f_1' => true,
       '_wdt' => true,
       '_profiler_search' => true,
       '_profiler_purge' => true,
       '_profiler_import' => true,
       '_profiler_export' => true,
       '_profiler_search_results' => true,
       '_profiler' => true,
       '_configurator_home' => true,
       '_configurator_step' => true,
       '_configurator_final' => true,
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

    private function get_assetic_202485fRouteInfo()
    {
        return array(array (), array (  '_controller' => 'assetic.controller:render',  'name' => '202485f',  'pos' => NULL,  '_format' => 'js',), array (), array (  0 =>   array (    0 => 'text',    1 => '/js/202485f.js',  ),));
    }

    private function get_assetic_202485f_0RouteInfo()
    {
        return array(array (), array (  '_controller' => 'assetic.controller:render',  'name' => '202485f',  'pos' => 0,  '_format' => 'js',), array (), array (  0 =>   array (    0 => 'text',    1 => '/js/202485f_part_1_reset_form_field_1.js',  ),));
    }

    private function get_assetic_202485f_1RouteInfo()
    {
        return array(array (), array (  '_controller' => 'assetic.controller:render',  'name' => '202485f',  'pos' => 1,  '_format' => 'js',), array (), array (  0 =>   array (    0 => 'text',    1 => '/js/202485f_part_1_validate_url_2.js',  ),));
    }

    private function get_wdtRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::toolbarAction',), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/_wdt',  ),));
    }

    private function get_profiler_searchRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_profiler/search',  ),));
    }

    private function get_profiler_purgeRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_profiler/purge',  ),));
    }

    private function get_profiler_importRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_profiler/import',  ),));
    }

    private function get_profiler_exportRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '.txt',  ),  1 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/\\.]+?',    3 => 'token',  ),  2 =>   array (    0 => 'text',    1 => '/_profiler/export',  ),));
    }

    private function get_profiler_search_resultsRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/search/results',  ),  1 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  2 =>   array (    0 => 'text',    1 => '/_profiler',  ),));
    }

    private function get_profilerRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/_profiler',  ),));
    }

    private function get_configurator_homeRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_configurator/',  ),));
    }

    private function get_configurator_stepRouteInfo()
    {
        return array(array (  0 => 'index',), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'index',  ),  1 =>   array (    0 => 'text',    1 => '/_configurator/step',  ),));
    }

    private function get_configurator_finalRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_configurator/final',  ),));
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
