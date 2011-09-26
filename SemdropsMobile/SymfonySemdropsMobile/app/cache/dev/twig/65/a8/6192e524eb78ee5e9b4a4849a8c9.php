<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showattributes.html.twig */
class __TwigTemplate_65a86192e524eb78ee5e9b4a4849a8c9 extends Twig_Template
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
        echo "Show Attributes";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "\tAttributes of the wiki <b>";
        echo twig_escape_filter($this->env, $this->getContext($context, 'link'), "html");
        echo "</b>:
\t<br><br>
\t ";
        // line 6
        $context['a'] = 0;
        // line 7
        echo "\t
     ";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'result'));
        foreach ($context['_seq'] as $context['_key'] => $context['datos']) {
            // line 9
            echo "       
        ";
            // line 10
            echo twig_escape_filter($this->env, $this->getContext($context, 'datos'), "html");
            echo "
            <br>
        
         
        
      
       
  
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datos'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 19
        echo "    <br>
  No more attributes to show.    
    
    
\t
\t<input type= \"button\" onclick= \"location.href='";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addAttributeTag"), "html");
        echo "'\" value=\"Add a AttributeTag\" name=\"addCategoryButton\" class= \"resetButtonStyle white button\"/><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showattributes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
