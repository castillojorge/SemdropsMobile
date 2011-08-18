<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showtags_error.html.twig */
class __TwigTemplate_86481268ee60eaae4c1470bffc50f641 extends Twig_Template
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
        // line 3
        $this->displayBlock('body', $context, $blocks);
        // line 8
        echo "
";
    }

    // line 1
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile - Error ";
    }

    // line 2
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "\tSome kind of error ocurred. <br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showtags_error.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
