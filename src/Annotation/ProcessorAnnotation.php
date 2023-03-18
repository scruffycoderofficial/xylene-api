<?php

namespace Xylene\Annotation;

/**
 * Class ProcessorAnnotation
 * s.
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
     * @throws \InvalidArgumentException
     */
    public function __construct(array $data)
    {
        if (!isset($data['value'])) {
            throw new \InvalidArgumentException(sprintf('%s Processor name must be specified.', ucfirst($this->getType())));
        }

        $this->name = $data['value'];
        unset($data['value']);
        $this->options = $data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    abstract public function getType(): string;
}
