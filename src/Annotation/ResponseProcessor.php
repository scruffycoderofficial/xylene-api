<?php

namespace Xylene\Annotation;

/**
 * Class ResponseProcessor
 *
 * @package Xylene\Annotation
 */
class ResponseProcessor extends ProcessorAnnotation
{
    public function getType(): string
    {
        return 'response';
    }
}