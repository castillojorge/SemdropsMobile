<?php

/* SemdropsSemdropsMobileBundle:Semdrops:getproperties.html.twig */
class __TwigTemplate_36444956cfc85f826fe5051b8f17a54f extends Twig_Template
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

        // line 3
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "202485f_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_202485f_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/202485f_part_1_reset_form_field_1.js");
            // line 4
            echo "\t<script src=\"";
            echo twig_escape_filter($this->env, $this->getContext($context, 'asset_url'), "html");
            echo "\"></script>
";
            // asset "202485f_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_202485f_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/202485f_part_1_validate_url_2.js");
            echo "\t<script src=\"";
            echo twig_escape_filter($this->env, $this->getContext($context, 'asset_url'), "html");
            echo "\"></script>
";
        } else {
            // asset "202485f"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_202485f") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/202485f.js");
            echo "\t<script src=\"";
            echo twig_escape_filter($this->env, $this->getContext($context, 'asset_url'), "html");
            echo "\"></script>
";
        }
        unset($context["asset_url"]);
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_header($context, array $blocks = array())
    {
        echo "Get Properties";
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "<div align=\"right\" >
<a href= ";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("logout"), "html");
        echo ">cerrar sesion</a>
</div>
\t<form action=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("showProperties"), "html");
        echo "\" method=\"post\" onSubmit= \"return validate_url(\" form.uri \")\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
\t\tHere goes the URI: ";
        // line 11
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false));
        echo " <br>
\t\t";
        // line 12
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, 'form'));
        echo " ";
        // line 13
        echo "\t\t<!--<input type= \"text\" name= \"url\" value=\"Here goes your URI\" onclick= \"clickclear(this, 'Here goes your URI')\" onblur= \"clickrecall(this,'Here goes your URI')\" />-->
\t\t<input type=\"submit\" value=\"Show Properties\" class= \"resetButtonStyle white button\" />
\t</form><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />\t
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:getproperties.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
