<?php

/* SemdropsSemdropsMobileBundle:Semdrops:userindex.html.twig */
class __TwigTemplate_6600165055cc343120e7c61e274be772 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
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
        echo " Semdrops Mobile ";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "\tHello ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "user", array(), "any", false), "username", array(), "any", false), "html");
        echo "!<br> ";
        // line 6
        echo "\tThis is the index of Semdrops Mobile.<br>
\t<a href= \"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("gettags"), "html");
        echo "\">Get tags from a wiki.</a><br>
\t<a href= \"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("logout"), "html");
        echo "\">Log Out.</a>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:userindex.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
