<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showtags.html.twig */
class __TwigTemplate_e259a7ec437909e526c7ce5631b89462 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("::base.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile - Results ";
    }

    // line 4
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo "\tCategories of the wiki <b>";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'filledLink'), "getUri", array(), "method", false), "html");
        echo "</b>:<br>
\t";
        // line 7
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, 'filledLink'), "getCategories", array(), "method", false));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context['_key'] => $context['result']) {
            // line 8
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->getContext($context, 'result'), "html");
            echo "<br>
\t";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 9
            echo " ";
            // line 10
            echo "\t\tNo categories.<br>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['result'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 12
        echo "\t<input type= \"button\" onclick= \"location.href='";
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategory"), "html");
        echo "'\" value=\"Add a Category\" name=\"addCategoryButton\" /><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showtags.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
