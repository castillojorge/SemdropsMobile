<?php

/* FrameworkBundle:Exception:logs.html.twig */
class __TwigTemplate_b240b660ba60888bd0812a6619a03210 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<ol class=\"traces\">
    ";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'logs'));
        foreach ($context['_seq'] as $context['_key'] => $context['log']) {
            // line 3
            echo "        <li>
            ";
            // line 4
            if (("ERR" == $this->getAttribute($this->getContext($context, 'log'), "priorityName", array(), "any", false))) {
                // line 5
                echo "                <em>";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'log'), "priorityName", array(), "any", false), "html");
                echo "</em>
            ";
            } else {
                // line 7
                echo "                ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'log'), "priorityName", array(), "any", false), "html");
                echo "
            ";
            }
            // line 9
            echo "
            ";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'log'), "message", array(), "any", false), "html");
            echo "
        </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['log'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 13
        echo "</ol>";
    }

    public function getTemplateName()
    {
        return "FrameworkBundle:Exception:logs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
