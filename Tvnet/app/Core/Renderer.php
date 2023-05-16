<?php
declare(strict_types=1);

namespace app\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class Renderer
{
    private Environment $twig;

    public function __construct(LoaderInterface $loader)
    {
        $this->twig = new Environment($loader);
    }

    public static function create(string $viewPath): self
    {
        $loader = new FilesystemLoader([$viewPath]);
        return new self($loader);
    }

    public function render(View $view): string
    {
        $template = $this->twig->load($view->getTemplatePath() . '.twig');
        return $template->render($view->getParameters());
    }
}
