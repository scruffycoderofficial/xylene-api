<?php

namespace Xylene\Container;

use Xylene\Contract\ContainerInterface;
use Xylene\Exception\ItemNotFoundException;

/**
 * Class Container.
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $items = [];

    public function set($name, $item)
    {
        $this->items[$name] = $item;
    }

    public function get($name)
    {
        if (array_key_exists($name, $this->items)) {
            return $this->items[$name];
        } else {
            throw $this->createMissingItemException($name);
        }
    }

    /**
     * @param string $name
     *
     * @return ItemNotFoundException
     */
    private function createMissingItemException($name)
    {
        return new ItemNotFoundException(sprintf('Item "%s" not found.', $name));
    }
}
