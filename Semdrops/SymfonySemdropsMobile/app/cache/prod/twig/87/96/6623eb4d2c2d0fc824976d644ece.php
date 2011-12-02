<?php

/* SemdropsSemdropsMobileBundle:Semdrops:doneChangePass.html.twig */
class __TwigTemplate_87966623eb4d2c2d0fc824976d644ece extends Twig_Template
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
        echo "Password Changed";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
    Hi user, ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "nombre_usuario", array(), "method", false), "html");
        echo " your new password has been sent to your email
    
<input type= \"button\" onclick= \"location.href='";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("login"), "html");
        echo "'\" value=\"Go Back to Login\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:doneChangePass.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
