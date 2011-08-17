<?php

/* SemdropsSemdropsMobileBundle:Semdrops:persistCategory.html.twig */
class __TwigTemplate_5ece730927c33073c3c0b6e3805d8178 extends Twig_Template
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
        echo " Semdrops Mobile - Category Added ";
    }

    // line 4
    public function block_stylesheets($context, array $blocks = array())
    {
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("iPhone.css"), "html");
        echo "\" rel=\"stylesheet\" type=\"text/css\" /> ";
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo "\tURL: ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "uri", array(), "method", false), "html");
        echo "<br>
    Category: ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "categories", array(), "method", false), "html");
        echo "<br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:persistCategory.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
