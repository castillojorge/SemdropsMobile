<?php

/* SemdropsSemdropsMobileBundle:Semdrops:addCategory.html.twig */
class __TwigTemplate_bab476750430cbf89637d6829fb39329 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("iphone.css"), "html");
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
<form action=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addCategoryphp"), "html");
        echo "\" method=\"POST\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
   ";
        // line 3
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false), "Here go your uri: ");
        echo " 
   <br>
   ";
        // line 5
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "uri", array(), "any", false));
        echo "
   <br>
   ";
        // line 7
        echo $this->env->getExtension('form')->renderLabel($this->getAttribute($this->getContext($context, 'form'), "category", array(), "any", false), "Here go your category: ");
        echo "
   <br>
   ";
        // line 9
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "category", array(), "any", false));
        echo "
   <br>
   <br><input type=\"submit\" value =\"Add\"/>
   <input type=\"reset\" value=\"Clear\"><br><br>


   
</form>

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:addCategory.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
