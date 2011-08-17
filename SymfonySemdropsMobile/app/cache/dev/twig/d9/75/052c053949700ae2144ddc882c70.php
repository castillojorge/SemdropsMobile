<?php

/* SemdropsSemdropsMobileBundle:Semdrops:index.html.twig */
class __TwigTemplate_d975052c053949700ae2144ddc882c70 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("::base.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 4
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "47726d4_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_47726d4_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/47726d4_iPhone_1.css");
            // line 5
            echo "    <link  rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"";
            echo twig_escape_filter($this->env, $this->getContext($context, 'asset_url'), "html");
            echo "\"/>
";
        } else {
            // asset "47726d4"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_47726d4") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/47726d4.css");
            echo "    <link  rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"";
            echo twig_escape_filter($this->env, $this->getContext($context, 'asset_url'), "html");
            echo "\"/>
";
        }
        unset($context["asset_url"]);
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile ";
    }

    // line 7
    public function block_body($context, array $blocks = array())
    {
        // line 8
        echo "\t<p>Hello visitor!<br>
\tThis is the index of Semdrops Mobile.<br>
\t</p>
\t<p><a href= \"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("getCategories"), "html");
        echo "\" class= \"button\">Get Categories</a></p>
\t<p><a href= \"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategory"), "html");
        echo "\" class= \"white button\">Add Categories</a></p>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
