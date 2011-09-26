<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appdevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appdevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
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

        // _assetic_202485f
        if ($pathinfo === '/js/202485f.js') {
            return array (  '_controller' => 'assetic.controller:render',  'name' => '202485f',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_202485f',);
        }

        // _assetic_202485f_0
        if ($pathinfo === '/js/202485f_part_1_reset_form_field_1.js') {
            return array (  '_controller' => 'assetic.controller:render',  'name' => '202485f',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_202485f_0',);
        }

        // _assetic_202485f_1
        if ($pathinfo === '/js/202485f_part_1_validate_url_2.js') {
            return array (  '_controller' => 'assetic.controller:render',  'name' => '202485f',  'pos' => 1,  '_format' => 'js',  '_route' => '_assetic_202485f_1',);
        }

        // _wdt
        if (preg_match('#^/_wdt/(?P<token>[^/]+?)$#x', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::toolbarAction',)), array('_route' => '_wdt'));
        }

        if (0 === strpos($pathinfo, '/_profiler')) {
            // _profiler_search
            if ($pathinfo === '/_profiler/search') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',  '_route' => '_profiler_search',);
            }

            // _profiler_purge
            if ($pathinfo === '/_profiler/purge') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',  '_route' => '_profiler_purge',);
            }

            // _profiler_import
            if ($pathinfo === '/_profiler/import') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',  '_route' => '_profiler_import',);
            }

            // _profiler_export
            if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]+?)\\.txt$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',)), array('_route' => '_profiler_export'));
            }

            // _profiler_search_results
            if (preg_match('#^/_profiler/(?P<token>[^/]+?)/search/results$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',)), array('_route' => '_profiler_search_results'));
            }

            // _profiler
            if (preg_match('#^/_profiler/(?P<token>[^/]+?)$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array('_route' => '_profiler'));
            }

        }

        if (0 === strpos($pathinfo, '/_configurator')) {
            // _configurator_home
            if (rtrim($pathinfo, '/') === '/_configurator') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_configurator_home');
                }
                return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
            }

            // _configurator_step
            if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]+?)$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',)), array('_route' => '_configurator_step'));
            }

            // _configurator_final
            if ($pathinfo === '/_configurator/final') {
                return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
            }

        }

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

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
