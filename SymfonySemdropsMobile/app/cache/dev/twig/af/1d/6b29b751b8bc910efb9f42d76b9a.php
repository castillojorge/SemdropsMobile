<?php

/* SemdropsSemdropsMobileBundle:Semdrops:donePropertyTag.html.twig */
class __TwigTemplate_af1d6b29b751b8bc910efb9f42d76b9a extends Twig_Template
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
        echo "Property Tag Saved";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <br>
    Uri: ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "uri", array(), "method", false), "html");
        echo " <br>
    Property: ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "propertyTag", array(), "method", false), "html");
        echo " <br>
    Destino: ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "destino", array(), "method", false), "html");
        echo "<br>
<input type= \"button\" onclick= \"location.href='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:donePropertyTag.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
