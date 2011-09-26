<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showcategories.html.twig */
class __TwigTemplate_4db089a2de1604f4b3d152cc630743d6 extends Twig_Template
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
        echo "Show Categories";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "\tCategories of the wiki <b>";
        echo twig_escape_filter($this->env, $this->getContext($context, 'link'), "html");
        echo "</b>:
\t
\t";
        // line 6
        $this->env->loadTemplate("SemdropsSemdropsMobileBundle:Semdrops:showcategories_recursive.html.twig")->display(array_merge($context, array("tree" => $this->getContext($context, 'categories'))));
        // line 7
        echo "\t
\t<input type= \"button\" onclick= \"location.href='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategory"), "html");
        echo "'\" value=\"Add a Category\" name=\"addCategoryButton\" class= \"resetButtonStyle white button\"/><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showcategories.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
