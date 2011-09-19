<?php

/* SemdropsSemdropsMobileBundle:Semdrops:mostrarcategory.html.twig */
class __TwigTemplate_93f85f7a980eb9fcf26461037e3ff3ec extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("SemdropsSemdropsMobileBundle::baseForIPhone.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_header($context, array $blocks = array())
    {
        echo "Add a Category";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <br><br>
    Uri: ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "uri", array(), "method", false), "html");
        echo " <br>
    Category: ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "category", array(), "method", false), "html");
        echo " <br>

\t<input type= \"button\" onclick= \"location.href='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\"  class= \"resetButtonStyle white button\" />

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
