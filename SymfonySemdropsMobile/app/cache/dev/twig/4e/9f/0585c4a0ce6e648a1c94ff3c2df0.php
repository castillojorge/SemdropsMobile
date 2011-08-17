<?php

/* SemdropsSemdropsMobileBundle:Semdrops:gettags.html.twig */
class __TwigTemplate_4e9f0585c4a0ce6e648a1c94ff3c2df0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        $this->displayBlock('title', $context, $blocks);
        // line 2
        $this->displayBlock('body', $context, $blocks);
    }

    // line 1
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile - Get Tags ";
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "\t<form action=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("showCategories"), "html");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
\t\tHere goes the URI: ";
        // line 4
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false));
        echo " <br>
\t
\t\t";
        // line 6
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, 'form'));
        echo " ";
        // line 7
        echo "
\t\t<input type=\"submit\" value=\"Show Tags\"/>
\t</form>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:gettags.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
