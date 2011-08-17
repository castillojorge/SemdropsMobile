<?php

/* SemdropsSemdropsMobileBundle:Security:signup.html.twig */
class __TwigTemplate_ae3b577c7c4572eb2eca7c5f75855f0f extends Twig_Template
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

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile - Sign Up ";
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "\t<form action=\"\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo " >
\t\tNew User, sign up.<br>
\t\tUsername: ";
        // line 6
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "username", array(), "any", false));
        echo "<br>
\t\t";
        // line 7
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "password", array(), "any", false));
        echo "<br>
\t
    \t";
        // line 9
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, 'form'));
        echo " ";
        // line 10
        echo "  \t\t<input type=\"submit\" value=\"Submit\"/>
\t</form>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Security:signup.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
