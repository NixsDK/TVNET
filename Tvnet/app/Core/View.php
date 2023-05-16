<?php
declare(strict_types=1);

namespace app\Core;

class View
{
    private string $templatePath;
    private array $parameters;

    public function __construct(string $templatePath, array $parameters = [])
    {
        $this->templatePath = $templatePath;
        $this->parameters = $parameters;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
