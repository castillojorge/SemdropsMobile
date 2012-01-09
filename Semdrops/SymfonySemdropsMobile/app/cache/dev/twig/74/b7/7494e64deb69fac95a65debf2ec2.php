<?php

/* SemdropsSemdropsMobileBundle:Semdrops:addAttributeTag.html.twig */
class __TwigTemplate_74b77494e64deb69fac95a65debf2ec2 extends Twig_Template
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
        echo "Set a Attribute Tag";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<div align=\"right\" >
<a href= ";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("logout"), "html");
        echo ">cerrar sesion</a>
</div>
\t<form action=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("doneAttributeTag"), "html");
        echo "\" method=\"POST\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
\t   <br>
\t   ";
        // line 9
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false), "Here go your uri: ");
        echo " 
\t   <br>
\t   ";
        // line 11
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 13
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "attributeTag", array(), "any", false), "Here go your Attribute Tag: ");
        echo "
\t   <br>
\t   ";
        // line 15
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "attributeTag", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 17
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "target", array(), "any", false), "Here go your Target: ");
        echo "
\t   <br>
\t   ";
        // line 19
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "target", array(), "any", false));
        echo "
\t   <br>
\t   <input type=\"submit\" value =\"Add\" class= \"resetButtonStyle white button\" />
\t   <input type=\"reset\" value=\"Clear\" class= \"resetButtonStyle white button\" /><br><br>
\t</form>
\t<input type= \"button\" onclick= \"location.href='";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:addAttributeTag.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
