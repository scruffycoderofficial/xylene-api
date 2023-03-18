<?php

namespace Xylene\Annotation;

/**
 * Class ResponseProcessor.
 */
class ResponseProcessor extends ProcessorAnnotation
{
    public function getType(): string
    {
        return 'response';
    }
}
