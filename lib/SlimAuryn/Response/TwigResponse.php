<?php

declare(strict_types=1);

namespace SlimAuryn\Response;

class TwigResponse
{
    /** @var string */
    private $templateName;
    
    /** @var array */
    private $parameters;

    /** @var int */
    private $status;

    /**
     * TwigResponse constructor.
     * @param string $templateName
     * @param array $parameters
     */
    public function __construct(string $templateName, array $parameters = [], int $status = 200)
    {
        $this->templateName = $templateName;
        $this->parameters = $parameters;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
