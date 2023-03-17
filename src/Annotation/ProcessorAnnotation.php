<?php

namespace Xylene\Annotation;

use InvalidArgumentException;

/**
 * Class ProcessorAnnotation
 * s
 * @package Xylene\Annotation
 */
abstract class ProcessorAnnotation
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param array $data
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $data)
    {
        if (!isset($data['value'])) {
            throw new InvalidArgumentException(
                sprintf('%s Processor name must be specified.', ucfirst($this->getType()))
            );
        }

        $this->name = $data['value'];
        unset($data['value']);
        $this->options = $data;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;
}