<?php

/* SemdropsSemdropsMobileBundle:Semdrops:addCategory.html.twig */
class __TwigTemplate_768f1003194f84c30e910f9e18a45aed extends Twig_Template
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
        echo "Set a Category";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "\t<form action=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("doneCategory"), "html");
        echo "\" method=\"POST\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
\t   <br>
\t   ";
        // line 6
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false), "Here go your uri: ");
        echo " 
\t   <br>
\t   ";
        // line 8
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 10
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "category", array(), "any", false), "Here go your category: ");
        echo "
\t   <br>
\t   ";
        // line 12
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "category", array(), "any", false));
        echo "
\t   <br>
\t   <input type=\"submit\" value =\"Add\" class= \"resetButtonStyle white button\" />
\t   <input type=\"reset\" value=\"Clear\" class= \"resetButtonStyle white button\" /><br><br>
\t</form>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:addCategory.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
