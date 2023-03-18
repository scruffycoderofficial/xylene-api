<?php

namespace Xylene\Actor;

use Xylene\Actor\Contract\ActorInterface;

/**
 * Class CompositeActor.
 */
class CompositeActor implements ActorInterface
{
    /**
     * @var ActorInterface[]
     */
    private $actors;

    /**
     * @param ActorInterface[] $actors
     */
    public function __construct(array $actors = [])
    {
        foreach ($actors as $actor) {
            $this->addActor($actor);
        }
    }

    public function canExecute(string $useCaseName): bool
    {
        foreach ($this->actors as $actor) {
            if ($actor->canExecute($useCaseName)) {
                return true;
            }
        }

        return false;
    }

    public function addActor(ActorInterface $actor): void
    {
        $this->actors[$actor->getName()] = $actor;
    }

    public function getName(): string
    {
        return 'composite';
    }

    public function getActorByName(string $actorName): ?ActorInterface
    {
        return isset($this->actors[$actorName]) ? $this->actors[$actorName] : null;
    }

    public function hasActor(string $actorName): bool
    {
        return isset($this->actors[$actorName]);
    }
}
