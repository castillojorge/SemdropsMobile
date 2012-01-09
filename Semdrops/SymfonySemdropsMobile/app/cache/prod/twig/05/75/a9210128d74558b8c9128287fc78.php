<?php

/* SemdropsSemdropsMobileBundle:Semdrops:doneChangePassRec.html.twig */
class __TwigTemplate_0575a9210128d74558b8c9128287fc78 extends Twig_Template
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
    Your Pass has changed correctly.
    
<input type= \"button\" onclick= \"location.href='";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("logout"), "html");
        echo "'\" value=\"Go Back to Login\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:doneChangePassRec.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
