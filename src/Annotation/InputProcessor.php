<?php

namespace Xylene\Annotation;

/**
 * Class InputProcessor
 *
 * @package Xylene\Annotation
 */
class InputProcessor extends ProcessorAnnotation
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return 'input';
    }
}