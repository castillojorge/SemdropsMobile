<?php

/* SemdropsSemdropsMobileBundle:Semdrops:falla.html.twig */
class __TwigTemplate_3c3f1575ff407c3552a6e0df255e0d94 extends Twig_Template
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
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('templating')->getAssetUrl("iphone.css"), "html");
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
";
        // line 2
        $this->displayBlock('title', $context, $blocks);
        echo "<br>
";
        // line 3
        $this->displayBlock('body', $context, $blocks);
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo " My Category ";
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "\tUri: ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "uri", array(), "method", false), "html");
        echo "
        <br>
       Category:";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "category", array(), "method", false), "html");
        echo " 
       <br>
          NO SE PUDO REALIZAR CONEXION CON EL SERVIDOR
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:falla.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
