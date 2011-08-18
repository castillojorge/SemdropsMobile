<?php

/* SemdropsSemdropsMobileBundle:Default:index.html.twig */
class __TwigTemplate_58e923003a11733eb27b9cfcab8540e1 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'name'), "html");
        echo "!
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
