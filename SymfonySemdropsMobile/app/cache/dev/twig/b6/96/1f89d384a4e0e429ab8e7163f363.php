<?php

/* SemdropsSemdropsMobileBundle:Semdrops:mostrarcategory.html.twig */
class __TwigTemplate_b6961f89d384a4e0e429ab8e7163f363 extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("iphone.css"), "html");
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
        echo "    Uri: ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "uri", array(), "method", false), "html");
        echo " <br>
    Category: ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "category", array(), "method", false), "html");
        echo " <br>

<input type= \"button\" onclick= \"location.href='";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" />


";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:mostrarcategory.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
