<?php

/* SemdropsSemdropsMobileBundle:Semdrops:changePass.html.twig */
class __TwigTemplate_f5b81eafcab680f8def8b194ce1c24a7 extends Twig_Template
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
        echo "
\t<form action=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("doneChangePass"), "html");
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
\t   <br>
\t   <input type=\"submit\" value =\"Change pass\" class= \"resetButtonStyle white button\" />
\t   <input type=\"reset\" value=\"Clear\" class= \"resetButtonStyle white button\" /><br><br>
\t</form>
\t
\t";
        // line 16
        if (($this->getContext($context, 'msj') != "")) {
            // line 17
            echo "    ";
            echo twig_escape_filter($this->env, $this->getContext($context, 'msj'), "html");
            echo "
";
        }
        // line 18
        echo "<br>
\t

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:changePass.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
