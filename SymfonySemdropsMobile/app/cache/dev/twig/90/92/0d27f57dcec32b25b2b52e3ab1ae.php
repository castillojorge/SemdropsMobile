<?php

/* SemdropsSemdropsMobileBundle:Security:login.html.twig */
class __TwigTemplate_90920d27f57dcec32b25b2b52e3ab1ae extends Twig_Template
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

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo " Semdrops Mobile - Log In ";
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "\t";
        if ($this->getContext($context, 'error')) {
            // line 5
            echo "\t\t<div>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'error'), "message", array(), "any", false), "html");
            echo "</div>
\t";
        }
        // line 7
        echo "
\t<form action=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("login_check"), "html");
        echo "\" method=\"post\">
\t\t<label for=\"username\">Username:</label>
\t\t<input type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->getContext($context, 'last_username'), "html");
        echo "\" /><br>

\t\t<label for=\"password\">Password:</label>
\t\t<input type=\"password\" id=\"password\" name=\"_password\" />

\t\t";
        // line 19
        echo "
\t\t<input type=\"submit\" name=\"login\" />
\t</form>
\t<a href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("signup"), "html");
        echo "\">New user?</a>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
