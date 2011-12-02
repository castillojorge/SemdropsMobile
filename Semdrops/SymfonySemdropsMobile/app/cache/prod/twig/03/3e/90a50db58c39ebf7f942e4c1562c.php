<?php

/* SemdropsSemdropsMobileBundle:Semdrops:addUser.html.twig */
class __TwigTemplate_033e90a50db58c39ebf7f942e4c1562c extends Twig_Template
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
        echo "
\t<form action=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("doneAddUser"), "html");
        echo "\" method=\"POST\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
\t    <br>
\t   ";
        // line 7
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "nombre_usuario", array(), "any", false), "Here go your user name: ");
        echo " 
\t   <br>
\t   ";
        // line 9
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "nombre_usuario", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 11
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "clave", array(), "any", false), "Here go your Pass: ");
        echo "
\t   <br>
\t   ";
        // line 13
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "clave", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 15
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "nombre", array(), "any", false), "Here go your Name: ");
        echo "
\t   <br>
\t   ";
        // line 17
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "nombre", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 19
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "apellido", array(), "any", false), "Here go your surname: ");
        echo "
\t   <br>
\t   ";
        // line 21
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "apellido", array(), "any", false));
        echo "
\t   <br>
\t   ";
        // line 23
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "email", array(), "any", false), "Here go your email: ");
        echo "
\t   <br>
\t   ";
        // line 25
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "email", array(), "any", false));
        echo "
\t   <br>
\t   
\t   <br>
\t   <input type=\"submit\" value =\"Add\" class= \"resetButtonStyle white button\" />
\t   <input type=\"reset\" value=\"Clear\" class= \"resetButtonStyle white button\" /><br><br>
\t</form>
\t
\t";
        // line 33
        if (($this->getContext($context, 'msj') != "")) {
            // line 34
            echo "    ";
            echo twig_escape_filter($this->env, $this->getContext($context, 'msj'), "html");
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:addUser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
