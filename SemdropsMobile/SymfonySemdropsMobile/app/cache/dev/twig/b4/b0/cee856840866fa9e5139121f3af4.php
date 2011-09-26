<?php

/* SemdropsSemdropsMobileBundle:Semdrops:doneAttributeTag.html.twig */
class __TwigTemplate_b4b0cee856840866fa9e5139121f3af4 extends Twig_Template
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
        echo "    <br>
    Uri: ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "uri", array(), "method", false), "html");
        echo " <br>
    Attribute: ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "attributeTag", array(), "method", false), "html");
        echo " <br>
    Target: ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'form'), "Target", array(), "method", false), "html");
        echo "<br>
<input type= \"button\" onclick= \"location.href='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:doneAttributeTag.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
