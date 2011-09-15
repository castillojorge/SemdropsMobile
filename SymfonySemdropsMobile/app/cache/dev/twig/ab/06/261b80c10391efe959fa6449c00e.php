<?php

/* SemdropsSemdropsMobileBundle::baseForIPhone.html.twig */
class __TwigTemplate_ab06261b80c10391efe959fa6449c00e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
\t<title>Semdrops Mobile</title>
\t<link rel=\"stylesheet\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/semdropssemdropsmobile/style/iPhone.css"), "html");
        echo "\" type=\"text/css\" media=\"screen\" />

</head>
<body>
\t<div id= \"header\"><h1>";
        // line 10
        $this->displayBlock('header', $context, $blocks);
        echo "</h1></div>
\t<div id= \"content\">";
        // line 11
        $this->displayBlock('content', $context, $blocks);
        echo "</div>
</body>
</html>
";
    }

    // line 10
    public function block_header($context, array $blocks = array())
    {
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle::baseForIPhone.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
