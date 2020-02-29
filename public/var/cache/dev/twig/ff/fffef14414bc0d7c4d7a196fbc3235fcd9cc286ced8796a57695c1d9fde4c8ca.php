<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* includes/nav.html.twig */
class __TwigTemplate_eb0b78f8d97ba5329d9c2ee79765cba6630d0d430eb9ecf4792815ea0a65a741 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "includes/nav.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "includes/nav.html.twig"));

        // line 1
        echo "<nav class=\"navbar navbar-expand-md navbar-info bg-danger mb-5 fixed-top\" id=\"navbar\">
        <a class=\"navbar-brand\" href=\"#\"><img src=\"img/codewell_black.svg\" width=\"150\" height=\"50\" alt=\"\"></a>
        <button class=\"navbar-toggler rounded-0\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapsibleNavbar\">
            <!-- <span class=\"navbar-toggler-icon\"></span> -->
            <span class=\"toggler-icon\"><i class=\"fas fa-bars\"></i></span>
        </button>
        <div class=\"collapse navbar-collapse justify-content-center text-light\" id=\"collapsibleNavbar\">
            <ul class=\"navbar-nav\">
                <li class=\"nav-item text-light\">
                    <a class=\"nav-link active text-light\" href=\"#\">Home</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link text-light\" href=\"#\">Link</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link text-light\" href=\"#\">About</a>
                </li>
                <li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" id=\"navbardrop\" data-toggle=\"dropdown\">
                    Create
                </a>
                <div class=\"dropdown-menu rounded-0 text-muted p-0\" id=\"dropdown-menu\">
                    <a class=\"dropdown-item\" href=\"newstudent\">New Student</a>
                    <a class=\"dropdown-item\" href=\"/\">New Teacher</a>
                    <a class=\"dropdown-item\" href=\"/\">New Parent</a>
                </div>
                </li>  

            </ul>
            <div class=\"nav-info-items d-none d-lg-flex \">
            <!-- single info -->
            <div class=\"nav-info align-items-center d-flex justify-content-between mx-lg-5\">
                <span class=\"info-icon mx-lg-3\"><i class=\"fas fa-phone\"></i></span>
                <p class=\"mb-0 text-white\">+ 123 456 789</p>
            </div>
            <!-- end of single info -->
            <!-- single info -->
            <div id=\"cart-info\" class=\"nav-info align-items-center cart-info d-flex justify-content-between mx-lg-5\">
                <span class=\"cart-info__icon mr-lg-3\"><i class=\"fas fa-sign-in-alt\"></i></span>
                <p class=\"mb-0 text-capitalize text-white\"><a href=\"#\" id=\"logout\" class=\"text-light\">Logout</a></p>
            </div>
            <!-- end of single info -->
            </div>
        </div>  
    </nav>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "includes/nav.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<nav class=\"navbar navbar-expand-md navbar-info bg-danger mb-5 fixed-top\" id=\"navbar\">
        <a class=\"navbar-brand\" href=\"#\"><img src=\"img/codewell_black.svg\" width=\"150\" height=\"50\" alt=\"\"></a>
        <button class=\"navbar-toggler rounded-0\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapsibleNavbar\">
            <!-- <span class=\"navbar-toggler-icon\"></span> -->
            <span class=\"toggler-icon\"><i class=\"fas fa-bars\"></i></span>
        </button>
        <div class=\"collapse navbar-collapse justify-content-center text-light\" id=\"collapsibleNavbar\">
            <ul class=\"navbar-nav\">
                <li class=\"nav-item text-light\">
                    <a class=\"nav-link active text-light\" href=\"#\">Home</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link text-light\" href=\"#\">Link</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link text-light\" href=\"#\">About</a>
                </li>
                <li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" id=\"navbardrop\" data-toggle=\"dropdown\">
                    Create
                </a>
                <div class=\"dropdown-menu rounded-0 text-muted p-0\" id=\"dropdown-menu\">
                    <a class=\"dropdown-item\" href=\"newstudent\">New Student</a>
                    <a class=\"dropdown-item\" href=\"/\">New Teacher</a>
                    <a class=\"dropdown-item\" href=\"/\">New Parent</a>
                </div>
                </li>  

            </ul>
            <div class=\"nav-info-items d-none d-lg-flex \">
            <!-- single info -->
            <div class=\"nav-info align-items-center d-flex justify-content-between mx-lg-5\">
                <span class=\"info-icon mx-lg-3\"><i class=\"fas fa-phone\"></i></span>
                <p class=\"mb-0 text-white\">+ 123 456 789</p>
            </div>
            <!-- end of single info -->
            <!-- single info -->
            <div id=\"cart-info\" class=\"nav-info align-items-center cart-info d-flex justify-content-between mx-lg-5\">
                <span class=\"cart-info__icon mr-lg-3\"><i class=\"fas fa-sign-in-alt\"></i></span>
                <p class=\"mb-0 text-capitalize text-white\"><a href=\"#\" id=\"logout\" class=\"text-light\">Logout</a></p>
            </div>
            <!-- end of single info -->
            </div>
        </div>  
    </nav>", "includes/nav.html.twig", "C:\\xampp\\htdocs\\symfony\\barca\\templates\\includes\\nav.html.twig");
    }
}
