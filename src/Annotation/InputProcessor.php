<?php

namespace Xylene\Annotation;

/**
 * Class InputProcessor.
 */
class InputProcessor extends ProcessorAnnotation
{
    public function getType(): string
    {
        return 'input';
    }
}
