<?php

/* SemdropsSemdropsMobileBundle:Semdrops:changePassRec.html.twig */
class __TwigTemplate_1892ca3bba0cbc4320d4d8503c04bdd6 extends Twig_Template
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
        echo "Change Pass";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "Hi User ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'user'), "nombre_usuario", array(), "any", false), "html");
        echo ", you need change Pass for login in the page Semdrops Mobile

\t<form action=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("doneChangePassRec"), "html");
        echo "\" method=\"POST\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
\t    <br>
\t   ";
        // line 8
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "clave", array(), "any", false), "Here go your actual Pass: ");
        echo " 
\t   <br>
\t   ";
        // line 10
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "clave", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 12
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "clave2", array(), "any", false), "Here go your New Pass: ");
        echo "
\t   <br>
\t   ";
        // line 14
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "clave2", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 16
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "clave3", array(), "any", false), "Here go your another New Pass: ");
        echo "
\t   <br>
\t   ";
        // line 18
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "clave3", array(), "any", false));
        echo "
\t   <br>
\t   <br>
\t   <input type=\"submit\" value =\"Change\" class= \"resetButtonStyle white button\" />
\t   <input type=\"reset\" value=\"Clear\" class= \"resetButtonStyle white button\" /><br><br>
\t</form>
\t
\t";
        // line 25
        if (($this->getContext($context, 'msj') != "")) {
            // line 26
            echo "    ";
            echo twig_escape_filter($this->env, $this->getContext($context, 'msj'), "html");
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:changePassRec.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
