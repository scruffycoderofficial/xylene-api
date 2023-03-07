<?php

declare(strict_types=1);

namespace Xylene\Annotation;

use InvalidArgumentException;

/**
 * Class UseCase
 *
 * @package Xylene\Annotation
 */
class UseCase
{
    /**
     * @var string
     */
    private $name;

    /**
     * UseCase constructor.
     *
     * @param array $data
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
                throw new InvalidArgumentException(sprintf(
                    'Unsupported options on UseCase annotation: %s', implode(', ', $invalidOptions)
                ));
            }
        }
    }
}
