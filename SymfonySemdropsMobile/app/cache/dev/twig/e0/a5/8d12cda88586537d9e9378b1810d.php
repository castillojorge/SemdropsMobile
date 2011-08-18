<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showcategory.html.twig */
class __TwigTemplate_e0a58d12cda88586537d9e9378b1810d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        $this->displayBlock('title', $context, $blocks);
        // line 2
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 3
        $this->displayBlock('body', $context, $blocks);
        // line 12
        echo "
";
    }

    // line 1
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile - Results ";
    }

    // line 2
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "\tCategories of the wiki <b>";
        echo twig_escape_filter($this->env, $this->getContext($context, 'link'), "html");
        echo "</b>:
\t
\t";
        // line 6
        $this->env->loadTemplate("SemdropsSemdropsMobileBundle:Semdrops:asdf.html.twig")->display(array_merge($context, array("tree" => $this->getContext($context, 'categories'))));
        // line 7
        echo "\t
\t<input type= \"button\" onclick= \"location.href='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategory"), "html");
        echo "'\" value=\"Add a Category\" name=\"addCategoryButton\" /><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showcategory.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
