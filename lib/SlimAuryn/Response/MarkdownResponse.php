<?php

declare(strict_types=1);

namespace SlimAuryn\Response;

class MarkdownResponse
{
    /** @var string */
    private $templateName;

    /** @var int */
    private $status;

    public function __construct(string $templateName, int $status = 200)
    {
        $this->templateName = $templateName;
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
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
