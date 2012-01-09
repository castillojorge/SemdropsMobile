<?php

/* SemdropsSemdropsMobileBundle:Semdrops:doneUser.html.twig */
class __TwigTemplate_172b091d6eceab4cafd6cf53b791de61 extends Twig_Template
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
        echo "Attribute Tag Saved";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
    Name User: ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "nombre_usuario", array(), "method", false), "html");
        echo " <br>
    Pass: ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "clave", array(), "method", false), "html");
        echo " <br>
    Name: ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "nombre", array(), "method", false), "html");
        echo "<br>
    Surname: ";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "apellido", array(), "method", false), "html");
        echo "<br>
    Email:  ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "email", array(), "any", false), "html");
        echo "
<input type= \"button\" onclick= \"location.href='";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("login"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:doneUser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
