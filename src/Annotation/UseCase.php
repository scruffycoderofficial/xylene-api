<?php

declare(strict_types=1);

namespace Xylene\Annotation;

/**
 * Class UseCase.
 */
class UseCase
{
    /**
     * @var string
     */
    private $name;

    /**
     * UseCase constructor.
     */
    public function __construct(array $data)
    {
        if (isset($data['value'])) {
            $this->name = $data['value'];
            unset($data['value']);
        }

        if (!empty($data)) {
            $invalidOptions = array_keys($data);
            if (count($invalidOptions) > 0) {
                throw new \InvalidArgumentException(sprintf('Unsupported options on UseCase annotation: %s', implode(', ', $invalidOptions)));
            }
        }
    }
}
