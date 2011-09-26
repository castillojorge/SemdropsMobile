<?php

/* SemdropsSemdropsMobileBundle:Semdrops:index.html.twig */
class __TwigTemplate_148b11984b1b443b8eea80111dc04453 extends Twig_Template
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
        echo "Main Menu";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "\t<p><strong>Welcome!</strong></p>
\t<p>This is the index of Semdrops Mobile</p>
\t<ul>
\t\t<li class= \"arrow\"><a href= \"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("getCategories"), "html");
        echo "\">Get Categories</a></li>
\t\t<li class= \"arrow\"><a href= \"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategory"), "html");
        echo "\">Add Categories</a></li>
\t\t<li class= \"arrow\"><a href= \"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addPropertyTag"), "html");
        echo "\">Add Property Tag</a></li>
\t\t<li class= \"arrow\"><a href= \"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("getProperties"), "html");
        echo "\">Get Properties</a></li>
\t\t<li class= \"arrow\"><a href= \"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addAttributeTag"), "html");
        echo "\">Add Attribute Tag</a></li>
\t\t<li class= \"arrow\"><a href= \"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("getAttributes"), "html");
        echo "\">Get Attributes</a></li>
\t</ul>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
