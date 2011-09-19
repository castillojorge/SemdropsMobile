<?php

/* FrameworkBundle:Exception:exception.css.twig */
class __TwigTemplate_eb895e4e4f98be701831b9b9f5367faf extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "/*
";
        // line 2
        $this->env->loadTemplate("FrameworkBundle:Exception:exception.txt.twig")->display(array_merge($context, array("exception" => $this->getContext($context, 'exception'))));
        // line 3
        echo "*/
";
    }

    public function getTemplateName()
    {
        return "FrameworkBundle:Exception:exception.css.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
