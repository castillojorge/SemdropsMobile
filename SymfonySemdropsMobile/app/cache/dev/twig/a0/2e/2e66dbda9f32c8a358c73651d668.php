<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showproperties.html.twig */
class __TwigTemplate_a02e2e66dbda9f32c8a358c73651d668 extends Twig_Template
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
        echo "Show Properties";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "\tProperties of the wiki <b>";
        echo twig_escape_filter($this->env, $this->getContext($context, 'link'), "html");
        echo "</b>:
\t<br><br>
     ";
        // line 6
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'result'));
        foreach ($context['_seq'] as $context['_key'] => $context['m']) {
            // line 7
            echo "        ";
            echo twig_escape_filter($this->env, $this->getContext($context, 'm'), "html");
            echo "<br>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['m'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 9
        echo "    
    
    
\t
\t<input type= \"button\" onclick= \"location.href='";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addPropertyTag"), "html");
        echo "'\" value=\"Add a PropertyTag\" name=\"addCategoryButton\" class= \"resetButtonStyle white button\"/><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showproperties.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
