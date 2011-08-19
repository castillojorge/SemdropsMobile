<?php

/* SemdropsSemdropsMobileBundle:Semdrops:index.html.twig */
class __TwigTemplate_d975052c053949700ae2144ddc882c70 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        $this->displayBlock('title', $context, $blocks);
        // line 2
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 5
        $this->displayBlock('body', $context, $blocks);
    }

    // line 1
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile ";
    }

    // line 2
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 3
        echo "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("/style/iPhone.css"), "html");
        echo "\"/>
";
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo "\t<p>Hello visitor!<br>
\tThis is the index of Semdrops Mobile.<br>
\t</p>
\t<p><a href= \"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("getCategories"), "html");
        echo "\" class= \"white button\">Get Categories</a></p>
\t<p><a href= \"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategory"), "html");
        echo "\" class= \"white button\">Add Categories</a></p>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:index.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
