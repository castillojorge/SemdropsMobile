<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showcategories_recursive.html.twig */
class __TwigTemplate_25db456db4ab2a233ebe99aefdcb5a48 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<ul>
\t";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'tree'));
        $context['_iterated'] = false;
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['category']) {
            echo "\t
\t\t<li>";
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'category'), "getName", array(), "method", false), "html");
            echo "</li>
\t\t";
            // line 4
            $this->env->loadTemplate("SemdropsSemdropsMobileBundle:Semdrops:showcategories_recursive.html.twig")->display(array_merge($context, array("tree" => $this->getAttribute($this->getContext($context, 'category'), "getFathers", array(), "method", false))));
            // line 5
            echo "\t";
            $context['_iterated'] = true;
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        if (!$context['_iterated']) {
            // line 6
            echo "\t\t<li>No more categories to show.</li>\t
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 8
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showcategories_recursive.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
